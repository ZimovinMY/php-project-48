<?php

namespace Differ\Formatters\Plain;

use function Functional\flatten;

function render(array $difference): string
{
    $plainDiff = array_filter(flatten(iter($difference)));
    return implode("\n", $plainDiff);
}
function iter(array $difference, string $path = ''): array
{
    return array_map(function ($item) use ($path) {
        $fullPath = "$path{$item['key']}";
        //$path .= $path ? '.' . $item['key'] : $item['key'];
        switch ($item['status']) {
            case 'node':
                return iter($item['value'], $fullPath . '.');
            case 'added':
                $stringValueAfter = getStringValue($item['value']);
                return "Property '$fullPath' was added with value: $stringValueAfter";
            case 'deleted':
                return "Property '$fullPath' was removed";
            case 'unchanged':
                return '';
            case 'changed':
                $stringValueBefore = getStringValue($item['valueBefore']);
                $stringValueAfter = getStringValue($item['valueAfter']);
                return "Property '$fullPath' was updated. From $stringValueBefore to $stringValueAfter";
            default:
                throw new \RuntimeException("Unknown type!");
        }
    }, $difference);
}
function getStringValue(mixed $value): string
{
    if (is_null($value)) {
        return 'null';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_array($value)) {
        return '[complex value]';
    }
    if (is_string($value)) {
        return "'$value'";
    }
    return "$value";
}
