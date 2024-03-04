<?php

namespace Difference\Formatters;

use function Difference\Formatters\Stylish\getStylish;
use function Difference\Formatters\Plain\getPlain;
use function Difference\Formatters\JSON\getJSON;

function shape(array $difference, string $format): string
{
    return match ($format) {
        'stylish' => getStylish($difference),
        'plain' => getPlain($difference),
        'json' => getJSON($difference)
    };
}
