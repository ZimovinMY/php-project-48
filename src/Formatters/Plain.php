<?php

namespace Difference\Formatters\Plain;

function getPlain(array $difference): string
{
    $plainDiff = getPlainDiff($difference);
    return implode("\n", $plainDiff);
}
function getPlainDiff(array $difference, string $path = ''): array
{
    return array_reduce($difference, function ($acc, $item) use ($path) {
        $path .= $path ? '.' . $item['key'] : $item['key'];
        switch ($item['status']) {
            case 'node':
                // Такая реализация нужна для формирования плоского массива
                $nestedAcc = getPlainDiff($item['value'], $path);
                $acc = array_merge($acc, $nestedAcc);
                break;
            case 'added':
                $stringValueAfter = getStringValue($item['value']);
                $acc[] = "Property '$path' was added with value: $stringValueAfter";
                break;
            case 'deleted':
                $acc[] = "Property '$path' was removed";
                break;
            case 'unchanged':
                break;
            case 'changed':
                $stringValueBefore = getStringValue($item['valueBefore']);
                $stringValueAfter = getStringValue($item['valueAfter']);
                $acc[] = "Property '$path' was updated. From $stringValueBefore to $stringValueAfter";
                break;
        }
        return $acc;
    }, []);
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
