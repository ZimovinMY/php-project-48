<?php

namespace Difference\Shaper;

// Обработка выходных данных
function shape(array $difference, string $format): string
{
    return match ($format) {
        'stylish' => stylish($difference)
        /// и другие
    };
}

function stylish(array $difference, $spaces = 2, $spacesIncr = 4): string
{
    // Подумать над другим способом формирования итоговой строки
    $outputString = "{\n";
    array_map(function ($item) use (&$outputString, $spaces, $spacesIncr) {
        if (isset($item['children'])) {
            $outputString .= str_repeat(" ", $spaces) . "{$item['symbol']} {$item['key']}: "
                . stylish($item['children'], $spaces + $spacesIncr);
        } else {
            // NULL -> null
            if ($item['value'] === null) {
                $value = convertToNormalString('null');
            }
            else {
                // Формируем "нормальное" строковое представление значения
                $value = convertToNormalString($item['value']);
            }
            // '' ->
            if ($value === "''") {
                $outputString .= str_repeat(" ", $spaces) . "{$item['symbol']} {$item['key']}:\n";
            } else {
                // Формирование результирующей строки
                $outputString .= str_repeat(" ", $spaces) . "{$item['symbol']} {$item['key']}: $value\n";
            }
        }
    }, $difference);
    $outputString .= str_repeat(" ", $spaces - 2) . "}\n";
    return $outputString;
}
function convertToNormalString(mixed $value): string
{
    // Генерируем строковое представление
    $stringValue = var_export($value, true);
    // Удаление кавычек вокруг значения
    return preg_replace("/'([^']+)'/", "$1", $stringValue);
}