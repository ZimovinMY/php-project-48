<?php

namespace Difference\Shaper;

// Обработка выходных данных
function shape(array $difference, string $format): string
{
    return match ($format) {
        'stylish' => getStylish($difference)
        /// и другие
    };
}

function getStylish(array $difference): string
{
    $stylishDiff = getStylishDiff($difference);
    $resultString = implode("\n", $stylishDiff);
    return "{\n$resultString\n}";
}
function getStylishDiff(array $difference, int $depth = 0): array
{
    $spaces = str_repeat('    ', $depth);
    $nextDepth = $depth + 1;

    return array_map(function($item) use ($spaces, $nextDepth) {
        $output = '';
        switch ($item['status']) {
            case 'node':
                $node = getStylishDiff($item['value'], $nextDepth);
                $stringNode = implode("\n", $node);
                $output = "$spaces    {$item['key']}: {\n$stringNode\n$spaces    }";
                break;
            case 'added':
                $stringValue = getStringValue($item['value'], $nextDepth);
                $output = "$spaces  + {$item['key']}: $stringValue";
                break;
            case 'deleted':
                $stringValue = getStringValue($item['value'], $nextDepth);
                $output = "$spaces  - {$item['key']}: $stringValue";
                break;
            case 'unchanged':
                $stringValue = getStringValue($item['value'], $nextDepth);
                $output = "$spaces    {$item['key']}: $stringValue";
                break;
            case 'changed':
                $stringValueBefore = getStringValue($item['valueBefore'], $nextDepth);
                $stringValueAfter = getStringValue($item['valueAfter'], $nextDepth);
                ////
                if (!$stringValueBefore) {
                    $output = "$spaces  - {$item['key']}:$stringValueBefore\n$spaces  + {$item['key']}: $stringValueAfter";
                    break;
                }
                if (!$stringValueAfter) {
                    $output = "$spaces  - {$item['key']}: $stringValueBefore\n$spaces  + {$item['key']}:$stringValueAfter";
                    break;
                }
                /////
                $output = "$spaces  - {$item['key']}: $stringValueBefore\n$spaces  + {$item['key']}: $stringValueAfter";
                break;
        }
        return $output;
    }, $difference);
}
function getStringValue(mixed $value, int $depth): string
{
    if (is_null($value)) {
        return 'null';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_array($value)) {
        $result = convertArrayToString($value, $depth);
        $spaces = str_repeat('    ', $depth);
        return "{{$result}\n$spaces}";
    }
    return "$value";
}
function convertArrayToString(array $value, int $depth): string
{
    $keys = array_keys($value);
    $nextDepth = $depth + 1;

    $callback = function ($key) use ($value, $nextDepth) {
        $newValue = getStringValue($value[$key], $nextDepth);
        $spaces = str_repeat('    ', $nextDepth);
        return "\n$spaces$key: $newValue";
    };

    return implode('', array_map($callback, $keys));
}