<?php

namespace Hexlet\Code\Parser;

# Обработка входных данных
function parse(string $filePath): array
{
    $fileContent = file_get_contents($filePath);
    return json_decode($fileContent, true);
    ///Добавить обработку исключений
}
