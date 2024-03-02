<?php

namespace Difference\Parser;

use RuntimeException;
use Symfony\Component\Yaml\Yaml;
// Обработка входных данных
function parse(string $filePath): array
{
    $extension = pathinfo($filePath)['extension'];
    if ($extension === 'yaml' || $extension === 'yml') {
        $fileContent = file_get_contents($filePath);
        return Yaml::parse($fileContent);
    } else if ($extension === 'json') {
        $fileContent = file_get_contents($filePath);
        return json_decode($fileContent, true);
    } else {
        throw new RuntimeException('Unknown extension!');
    }
}