<?php

namespace Difference\Formatters;

use RuntimeException;
use Difference\Formatters\Stylish;
use Difference\Formatters\Plain;
use Difference\Formatters\JSON;

function shape(array $difference, string $format): string
{
    return match ($format) {
        'stylish' => Stylish\render($difference),
        'plain' => Plain\render($difference),
        'json' => JSON\render($difference),
        default => throw new RuntimeException('Unknown output format!')
    };
}
