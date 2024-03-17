<?php

namespace Differ\Formatters\JSON;

function render(array $difference): string
{
    return json_encode($difference, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
}
