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
function getStylishDiff(array $difference, int $level = 0): array
{
    $spaces = getSpaces($level);
    $nextLevel = $level + 1;

    return array_map(function($item) use ($spaces, $nextLevel) {
        $output = '';
        switch ($item['status']) {
            case 'node':
                $node = getStylishDiff($item['value'], $nextLevel);
                $stringNode = implode("\n", $node);
                $output = "$spaces    {$item['key']}: {\n$stringNode\n$spaces    }";
                break;
            case 'added':
                $stringValue = getStringValue($item['value'], $nextLevel);
                $output = "$spaces  + {$item['key']}: $stringValue";
                break;
            case 'deleted':
                $stringValue = getStringValue($item['value'], $nextLevel);
                $output = "$spaces  - {$item['key']}: $stringValue";
                break;
            case 'unchanged':
                $stringValue = getStringValue($item['value'], $nextLevel);
                $output = "$spaces    {$item['key']}: $stringValue";
                break;
            case 'changed':
                $stringValueBefore = getStringValue($item['valueBefore'], $nextLevel);
                $stringValueAfter = getStringValue($item['valueAfter'], $nextLevel);
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
function getSpaces(int $level): string
{
    return str_repeat('    ', $level);
}
function getStringValue(mixed $value, int $level): string
{
    if (is_null($value)) {
        return 'null';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_array($value)) {
        $result = convertArrayToString($value, $level);
        $spaces = getSpaces($level);
        return "{{$result}\n$spaces}";
    }
    return "$value";
}
function convertArrayToString(array $value, int $level): string
{
    $keys = array_keys($value);
    $nextLevel = $level + 1;

    $callback = function ($key) use ($value, $nextLevel) {
        $newValue = getStringValue($value[$key], $nextLevel);
        $spaces = getSpaces($nextLevel);
        if ($newValue === "11111") {
            return "\n$spaces$key:";
        }
        return "\n$spaces$key: $newValue";
    };

    return implode('', array_map($callback, $keys));
}