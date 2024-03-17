<?php

namespace Differ\Formatters\Plain;

use function Functional\flatten;

function render(array $difference): string
{
    $plainDiff = getPlainDiff($difference);
    return implode("\n", $plainDiff);
}

function getPlainDiff(array $difference): array
{
    $bodyDifference = $difference['value'];
    $plainDiff = iter($bodyDifference);
    return array_filter(flatten($plainDiff));
}
function iter(array $difference, string $path = ''): array
{
    return array_map(function ($item) use ($path) {
        $fullPath = "$path{$item['key']}";
        switch ($item['status']) {
            case 'node':
                return iter($item['value'], $fullPath . '.');
            case 'added':
                $stringValueAfter = getStringValue($item['value']);
                return sprintf("Property '%s' was added with value: %s", $fullPath, $stringValueAfter);
            case 'deleted':
                return sprintf("Property '%s' was removed", $fullPath);
            case 'unchanged':
                return '';
            case 'changed':
                $stringValueBefore = getStringValue($item['valueBefore']);
                $stringValueAfter = getStringValue($item['valueAfter']);
                return sprintf(
                    "Property '%s' was updated. From %s to %s",
                    $fullPath,
                    $stringValueBefore,
                    $stringValueAfter
                );
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
    if (is_array($value) || is_object($value)) {
        return '[complex value]';
    }
    if (is_string($value)) {
        return "'$value'";
    }
    return "$value";
}
