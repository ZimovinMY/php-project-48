<?php

namespace Difference\DifferenceTest;

use PHPUnit\Framework\TestCase;

use function Difference\Difference\runDiff;
class DifferenceTest extends TestCase
{
    public function testRunDifference(): void
    {
        $path1 = './tests/file1.json';
        $path2 = './tests/file2.json';
        $expected = file_get_contents("./tests/fixtures/expected.txt");
        $this->assertEquals($expected, runDiff($path1, $path2));
    }
}