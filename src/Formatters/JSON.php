<?php

namespace Difference\Formatters\JSON;

function getJSON(array $difference): string
{
    return json_encode($difference, JSON_PRETTY_PRINT);
}
