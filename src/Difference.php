<?php

namespace Difference\Difference;

use function Difference\Parser\parse;
use function Difference\Shaper\shape;

// Интерфейс запуска расчета разницы
function runDiff(string $filePathFirst, string $filePathSecond, string $format = 'stylish'): string
{
    $fileContentFirst = parse($filePathFirst);
    $fileContentSecond = parse($filePathSecond);
    $difference = getDifference($fileContentFirst, $fileContentSecond);
    return substr(shape($difference, $format), 0, -1);
}

// Выполняет расчет разницы
function getDifference(array $fileContentFirst, array $fileContentSecond): array
{
    // Объединенный массив, содержащий все ключи
    $mergedContent = array_merge($fileContentFirst, $fileContentSecond);
    // Сортировка по ключам
    ksort($mergedContent);
    return array_reduce(array_keys($mergedContent), function ($acc, $key) use ($fileContentFirst, $fileContentSecond) {
        // Ключ не найден в 1 массиве
        if (!array_key_exists($key, $fileContentFirst)) {
            // Если значение 2-го массива является массивом
            if (is_array($fileContentSecond[$key])) {
                // В children заносится массив в виде выбранной структуры
                $acc[] = ['symbol' => '+', 'key' => $key, 'children' => getDifference($fileContentSecond[$key], $fileContentSecond[$key])];
            } else {
                $acc[] = ['symbol' => '+', 'key' => $key, 'value' => $fileContentSecond[$key]];
            }
            return $acc;
        }
        // Ключ не найден во 2 массиве
        if (!array_key_exists($key, $fileContentSecond)) {
            // Если значение 1-го массива является массивом
            if (is_array($fileContentFirst[$key])) {
                // В children заносится массив в виде выбранной структуры
                $acc[] = ['symbol' => '-', 'key' => $key, 'children' => getDifference($fileContentFirst[$key], $fileContentFirst[$key])];
            } else {
                $acc[] = ['symbol' => '-', 'key' => $key, 'value' => $fileContentFirst[$key]];
            }
            return $acc;
        }
        // Если значение в обоих массивах является массивом
        if (is_array($fileContentFirst[$key]) && is_array($fileContentSecond[$key])) {
            $acc[] = ['symbol' => ' ', 'key' => $key, 'children' => getDifference($fileContentFirst[$key], $fileContentSecond[$key])];
            return $acc;
        }
        // Если значение в обоих массивах обинаково
        if ($fileContentFirst[$key] === $fileContentSecond[$key]) {
            // Если значение - массив, приводим его к выбранной структуре
            if (is_array($fileContentFirst[$key]) || is_array($fileContentSecond[$key])) {
                $acc[] = ['symbol' => ' ', 'key' => $key, 'children' => getDifference($fileContentFirst[$key], $fileContentSecond[$key])];
            } else {
                $acc[] = ['symbol' => ' ', 'key' => $key, 'value' => $fileContentFirst[$key]];
            }
        } else {
            // Если значение в обоих массивах разное
            // Если значение в первом массиве - массив
            if (is_array($fileContentFirst[$key]) && !is_array($fileContentSecond[$key])) {
                $acc[] = ['symbol' => '-', 'key' => $key, 'children' => getDifference($fileContentFirst[$key], $fileContentFirst[$key])];
                $acc[] = ['symbol' => '+', 'key' => $key, 'value' => $fileContentSecond[$key]];
                return $acc;
            }
            $acc[] = ['symbol' => '-', 'key' => $key, 'value' => $fileContentFirst[$key]];
            // Если значение во втором массиве - массив
            if (!is_array($fileContentFirst[$key]) && is_array($fileContentSecond[$key])) {
                $acc[] = ['symbol' => '+', 'key' => $key, 'children' => getDifference($fileContentSecond[$key], $fileContentSecond[$key])];
                return $acc;
            }
            $acc[] = ['symbol' => '+', 'key' => $key, 'value' => $fileContentSecond[$key]];
        }
        return $acc;
    }, []);
}