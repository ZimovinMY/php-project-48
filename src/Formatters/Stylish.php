<?php

namespace Differ\Formatters\Stylish;

function render(array $difference): string
{
    $stylishDiff = iter($difference);
    $resultString = implode("\n", $stylishDiff);
    return "{\n$resultString\n}";
}
function iter(array $difference, int $depth = 0): array
{
    $spaces = str_repeat('    ', $depth);
    $nextDepth = $depth + 1;

    return array_map(function ($item) use ($spaces, $nextDepth) {
        $output = '';
        switch ($item['status']) {
            case 'node':
                $node = iter($item['value'], $nextDepth);
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
                $lines[] = "$spaces  - {$item['key']}: $stringValueBefore";
                $lines[] = "$spaces  + {$item['key']}: $stringValueAfter";
                $output = implode("\n", $lines);
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

    return implode('', array_map(function ($key) use ($value, $nextDepth) {
        $newValue = getStringValue($value[$key], $nextDepth);
        $spaces = str_repeat('    ', $nextDepth);
        return "\n$spaces$key: $newValue";
    }, $keys));
}
