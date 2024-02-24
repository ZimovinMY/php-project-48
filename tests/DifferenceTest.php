<?php

namespace Tests\DifferenceTest;

use PHPUnit\Framework\TestCase;
use Exception;

use function Difference\Difference\runDiff;
class DifferenceTest extends TestCase
{
    public function testRunDifference(): void
    {
        $path1 = __DIR__ . '/fixtures/plain1.json';
        $path2 = __DIR__ . '/fixtures/plain2.json';
        $expected = file_get_contents(__DIR__ . "/fixtures/Plain-expected.txt");
        $this->assertEquals($expected, runDiff($path1, $path2));

        $path1 = __DIR__ . '/fixtures/plain1.yaml';
        $path2 = __DIR__ . '/fixtures/plain2.yaml';
        $expected = file_get_contents(__DIR__ . "/fixtures/Plain-expected.txt");
        $this->assertEquals($expected, runDiff($path1, $path2));

        $path1 = __DIR__ . '/fixtures/nested1.json';
        $path2 = __DIR__ . '/fixtures/nested2.json';
        $expected = file_get_contents(__DIR__ . "/fixtures/Nested-expected.txt");
        $this->assertEquals($expected, runDiff($path1, $path2));

        $path1 = __DIR__ . '/fixtures/nested1.yaml';
        $path2 = __DIR__ . '/fixtures/nested2.yaml';
        $expected = file_get_contents(__DIR__ . "/fixtures/Nested-expected.txt");
        $this->assertEquals($expected, runDiff($path1, $path2));

        $path1 = __DIR__ . '/fixtures/file1.jn';
        $path2 = __DIR__ . '/fixtures/file2.jsn';
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unknown extension!');
        runDiff($path1, $path2);
    }
}