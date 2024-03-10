<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

// Обработка входных данных
function parse(string $filePath): array
{
    $extension = pathinfo($filePath)['extension'] ?? null;
    return match ($extension) {
        'json' => parseJSON($filePath),
        'yaml', 'yml' => parseYAML($filePath),
        default => throw new \RuntimeException('Unknown extension!')
    };
}
function parseJSON(string $filePath): array
{
    $fileContent = file_get_contents($filePath);
    return $fileContent !== false
        ? json_decode($fileContent, true)
        : throw new \RuntimeException('File reading error!');
}
function parseYAML(string $filePath): array
{
    $fileContent = file_get_contents($filePath);
    return $fileContent !== false
        ? Yaml::parse($fileContent)
        : throw new \RuntimeException('File reading error!');
}
