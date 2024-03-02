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
    ////
//    print_r('$stylishDiff');
//    print_r($stylishDiff);
//    print_r('$stylishDiff');
    ////
    $resultString = implode("\n", $stylishDiff);
    return "{\n{$resultString}\n}";
}
function convertToNormalString(mixed $value): string
{
    // Генерируем строковое представление
    $stringValue = var_export($value, true);
    // Удаление кавычек вокруг значения
    return trim($stringValue, "'");
}


function getStylishDiff(array $difference)
{
    $output = "";
    return array_map(function($item) use (&$output) {
        switch ($item['status']) {
            case 'added':
                $value = convertToNormalString($item['value']);
                $output = "+ {$item['key']}: $value ";
                break;
            case 'deleted':
                $value = convertToNormalString($item['value']);
                $output = "- {$item['key']}: $value ";
                break;
            case 'unchanged':
                $value = convertToNormalString($item['value']);
                $output = "  {$item['key']}: $value ";
                break;
            case 'changed':
                $output = 'getStylishDiff()';
                break;
        }
        return $output;
    }, $difference);
}




// $spaces = 2, $spacesIncr = 4

//    $outputString = "{\n";
//    array_map(function ($item) use (&$outputString, $spaces, $spacesIncr) {
//        if (isset($item['children'])) {
//            $outputString .= str_repeat(" ", $spaces) . "{$item['symbol']} {$item['key']}: "
//                . getStylish($item['children'], $spaces + $spacesIncr);
//        } else {
//            // NULL -> null
//            $value = ($item['value'] === null) ? convertToNormalString('null') : convertToNormalString($item['value']);
//            if (!$value) {
//                $outputString .= str_repeat(" ", $spaces) . "{$item['symbol']} {$item['key']}:\n";
//            } else {
//                // Формирование результирующей строки
//                $outputString .= str_repeat(" ", $spaces) . "{$item['symbol']} {$item['key']}: $value\n";
//            }
//        }
//    }, $difference);
//    $outputString .= str_repeat(" ", $spaces - 2) . "}\n";
//    return $outputString;