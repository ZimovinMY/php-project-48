<?php

namespace Hexlet\Code\Shaper;

# Обработка выходных данных
function shape(array $difference): string
{
    $outputString = "{\n";
    array_map(function ($item) use (&$outputString) {
        $outputString .= "  {$item['symbol']} {$item['key']}: {$item['value']}\n";
    }, $difference);
    $outputString .= "}";
    ///print_r(json_encode($difference, JSON_PRETTY_PRINT));
    return $outputString;
}
