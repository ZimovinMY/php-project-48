<?php

namespace Differ\Formatters;

function shape(array $difference, string $format): string
{
    return match ($format) {
        'stylish' => Stylish\render($difference),
        'plain' => Plain\render($difference),
        'json' => JSON\render($difference),
        default => throw new \RuntimeException("Unknown output format: $format")
    };
}
