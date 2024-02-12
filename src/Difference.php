<?php

namespace Hexlet\Code\Difference;

use function Hexlet\Code\Parser\parse;
use function Hexlet\Code\Shaper\shape;

# Интерфейс запуска расчета разницы
function runDiff(string $filePathFirst, string $filePathSecond, string $format = 'plain'): string
{
    $fileContentFirst = parse($filePathFirst);
    $fileContentSecond = parse($filePathSecond);
    $difference = getDifference($fileContentFirst, $fileContentSecond);
    $differenceOutput = shape($difference);
    return $differenceOutput;
}

# Выполняет расчет разницы
function getDifference(array $fileContentFirst, array $fileContentSecond): array
{
    # Объединенный массив, содержащий все ключи
    $mergedContent = array_merge($fileContentFirst, $fileContentSecond);
    # Сортировка по ключам
    ksort($mergedContent);
    # Возвращается массив "разниц" двух массивов
    return array_reduce(array_keys($mergedContent), function ($acc, $key)
 use ($fileContentFirst, $fileContentSecond, $mergedContent) {
        $value = $mergedContent[$key];
        # Если ключ имеется в обоих массивах
        if (array_key_exists($key, $fileContentFirst) && array_key_exists($key, $fileContentSecond)) {
            # Если значения в этих массивах по данному ключу одинаковы
            if ($fileContentFirst[$key] === $fileContentSecond[$key]) {
                $acc[] = ['symbol' => ' ', 'key' => $key, 'value' => $value];
            } else {
                $acc[] = ['symbol' => '-', 'key' => $key, 'value' => $fileContentFirst[$key]];
                $acc[] = ['symbol' => '+', 'key' => $key, 'value' => $fileContentSecond[$key]];
            }
        } elseif (!array_key_exists($key, $fileContentFirst)) { # Если ключ не найден в первом массиве
            $acc[] = ['symbol' => '+', 'key' => $key, 'value' => $fileContentSecond[$key]];
        } else { # Если ключ не найден во втором массиве
            $acc[] = ['symbol' => '-', 'key' => $key, 'value' => $fileContentFirst[$key]];
        }
        return $acc;
    }, []);
}
