<?php

namespace Difference\Formatters\Plain;

use function Functional\flatten;

function render(array $difference): string
{
    $plainDiff = array_filter(flatten(iter($difference)));
    return implode("\n", $plainDiff);
}
function iter(array $difference, string $path = ''): array
{
    return array_map(function ($item) use ($path) {
        $output = '';
        $path .= $path ? '.' . $item['key'] : $item['key'];
        switch ($item['status']) {
            case 'node':
                $output = iter($item['value'], $path);
                break;
            case 'added':
                $stringValueAfter = getStringValue($item['value']);
                $output = "Property '$path' was added with value: $stringValueAfter";
                break;
            case 'deleted':
                $output = "Property '$path' was removed";
                break;
            //case 'unchanged':
            //    break;
            case 'changed':
                $stringValueBefore = getStringValue($item['valueBefore']);
                $stringValueAfter = getStringValue($item['valueAfter']);
                $output = "Property '$path' was updated. From $stringValueBefore to $stringValueAfter";
                break;
        }
        return $output;
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
    return "'$value'";
}
