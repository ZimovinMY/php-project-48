<?php

namespace Difference\Shaper;

// Обработка выходных данных
function shape(array $difference): string
{
    // Подумать над другим способом формирования итоговой строки
    $outputString = "{\n";
    array_map(function ($item) use (&$outputString) {
        // Генерируем строковое представление
        $value = var_export($item['value'], true);
        // Удаление кавычек вокруг значения
        $valueF = preg_replace("/'([^']+)'/", "$1", $value);
        // Формирование результирующей строки
        $outputString .= "  {$item['symbol']} {$item['key']}: $valueF\n";
    }, $difference);
    $outputString .= "}";
    return $outputString;
}
