<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RuntimeException;

use function Difference\Difference\genDiff;
class DifferenceTest extends TestCase
{
    private string $path = __DIR__ . "/fixtures/";
    private function getFilePath($name): string
    {
        return $this->path . $name;
    }
    /**
     * @dataProvider RunDifferenceProvider
     */
    public function testRunDifference($pathFirst, $pathSecond, $format, $expected): void
    {
        $this->assertStringEqualsFile(
            $this->getFilePath($expected),
            genDiff($this->getFilePath($pathFirst), $this->getFilePath($pathSecond), $format)
        );
    }
    public static function RunDifferenceProvider(): array
    {
        return [
            ['file1.json', 'file2.json', 'stylish', 'StylishFormat-expected.txt'],
            ['file1.yaml', 'file2.yaml', 'stylish', 'StylishFormat-expected.txt'],
            ['file1.json', 'file2.yaml', 'stylish', 'StylishFormat-expected.txt'],
            ['file1.json', 'file2.json', 'plain', 'PlainFormat-expected.txt'],
            ['file1.yaml', 'file2.yaml', 'plain', 'PlainFormat-expected.txt'],
            ['file1.yaml', 'file2.json', 'plain', 'PlainFormat-expected.txt'],
            ['file1.json', 'file2.json', 'json', 'JSONFormat-expected.txt'],
            ['file1.yaml', 'file2.yaml', 'json', 'JSONFormat-expected.txt'],
            ['file1.yaml', 'file2.json', 'json', 'JSONFormat-expected.txt'],
        ];
    }
    public function testRunDifferenceException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unknown extension!');
        genDiff($this->getFilePath('file1.jsn'), $this->getFilePath('file2.jn'));
    }
}