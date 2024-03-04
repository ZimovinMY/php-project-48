<?php

namespace Difference\Parser;

use RuntimeException;
use Symfony\Component\Yaml\Yaml;

// Обработка входных данных
function parse(string $filePath): array
{
    $extension = pathinfo($filePath)['extension'];
    return match ($extension) {
        'json' => parseJSON($filePath),
        'yaml', 'yml' => parseYAML($filePath),
        default => throw new RuntimeException('Unknown extension!')
    };
}
function parseJSON(string $filePath): array
{
    $fileContent = file_get_contents($filePath);
    return json_decode($fileContent, true);
}
function parseYAML(string $filePath): array
{
    $fileContent = file_get_contents($filePath);
    return Yaml::parse($fileContent);
}
