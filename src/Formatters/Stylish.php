<?php

namespace Differ\Formatters\Stylish;

function render(array $difference): string
{
    return iter($difference);
}
function iter(array $difference, int $depth = 0): string
{
    $spaces = str_repeat('    ', $depth);
    $nextDepth = $depth + 1;
    switch ($difference['status']) {
        case 'root':
            $lines = array_map(function ($node) use ($depth) {
                return iter($node, $depth);
            }, $difference['value']);
            $output = ['{', ...$lines, '}'];
            return implode("\n", $output);
        case 'node':
            $lines = array_map(function ($node) use ($nextDepth) {
                return iter($node, $nextDepth);
            }, $difference['value']);
            $output = ["$spaces    {$difference['key']}: {", ...$lines, "$spaces    }"];
            return implode("\n", $output);
        case 'added':
            $stringValue = getStringValue($difference['value'], $nextDepth);
            return sprintf("%s  + %s: %s", $spaces, $difference['key'], $stringValue);
        case 'deleted':
            $stringValue = getStringValue($difference['value'], $nextDepth);
            return sprintf("%s  - %s: %s", $spaces, $difference['key'], $stringValue);
        case 'unchanged':
            $stringValue = getStringValue($difference['value'], $nextDepth);
            return sprintf("%s    %s: %s", $spaces, $difference['key'], $stringValue);
        case 'changed':
            $stringValueBefore = getStringValue($difference['valueBefore'], $nextDepth);
            $stringValueAfter = getStringValue($difference['valueAfter'], $nextDepth);
            $output = ["$spaces  - {$difference['key']}: $stringValueBefore", "$spaces  + {$difference['key']}: $stringValueAfter"];
            return implode("\n", $output);
        default:
            throw new \RuntimeException("Unknown type!");
    }
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
