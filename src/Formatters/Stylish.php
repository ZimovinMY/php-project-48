<?php

namespace Differ\Formatters\Stylish;

function render(array $difference): string
{
    $stylishDiff = getStylishDiff($difference);
    $resultString = implode("\n", $stylishDiff);
    return "{\n$resultString\n}";
}

function getStylishDiff(array $difference): array
{
    $bodyDifference = $difference['value'];
    return iter($bodyDifference);
}
function iter(array $difference, int $depth = 0): array
{
    $spaces = str_repeat('    ', $depth);
    $nextDepth = $depth + 1;

    return array_map(function ($item) use ($spaces, $nextDepth) {
        switch ($item['status']) {
            case 'node':
                $node = iter($item['value'], $nextDepth);
                $stringNode = implode("\n", $node);
                return sprintf("%s    %s: {\n%s\n%s    }", $spaces, $item['key'], $stringNode, $spaces);
            case 'added':
                $stringValue = getStringValue($item['value'], $nextDepth);
                return sprintf("%s  + %s: %s", $spaces, $item['key'], $stringValue);
            case 'deleted':
                $stringValue = getStringValue($item['value'], $nextDepth);
                return sprintf("%s  - %s: %s", $spaces, $item['key'], $stringValue);
            case 'unchanged':
                $stringValue = getStringValue($item['value'], $nextDepth);
                return sprintf("%s    %s: %s", $spaces, $item['key'], $stringValue);
            case 'changed':
                $stringValueBefore = getStringValue($item['valueBefore'], $nextDepth);
                $stringValueAfter = getStringValue($item['valueAfter'], $nextDepth);
                return sprintf(
                    "%s  - %s: %s\n%s  + %s: %s",
                    $spaces,
                    $item['key'],
                    $stringValueBefore,
                    $spaces,
                    $item['key'],
                    $stringValueAfter
                );
            default:
                throw new \RuntimeException("Unknown type!");
        }
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
