<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RuntimeException;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private string $path = __DIR__ . "/fixtures/";
    private function getFilePath($name): string
    {
        return $this->path . $name;
    }
    /**
     * @dataProvider runDifferProvider
     */
    public function testRunDiffer($pathFirst, $pathSecond, $format, $expected): void
    {
        $this->assertStringEqualsFile(
            $this->getFilePath($expected),
            genDiff($this->getFilePath($pathFirst), $this->getFilePath($pathSecond), $format)
        );
    }
    public static function runDifferProvider(): array
    {
        return [
            ['file1.json', 'file2.json', 'stylish', 'StylishFormat-expected.txt'],
            ['file1.yaml', 'file2.yaml', 'stylish', 'StylishFormat-expected.txt'],
            ['file1.json', 'file2.yaml', 'stylish', 'StylishFormat-expected.txt'],
            ['file1.json', 'file2.json', 'plain', 'PlainFormat-expected.txt'],
            ['file1.yaml', 'file2.yaml', 'plain', 'PlainFormat-expected.txt'],
            ['file1.yaml', 'file2.json', 'plain', 'PlainFormat-expected.txt'],
            //['file1.json', 'file2.json', 'json', 'JSONFormat-expected.txt'],
            //['file1.yaml', 'file2.yaml', 'json', 'JSONFormat-expected.txt'],
            //['file1.yaml', 'file2.json', 'json', 'JSONFormat-expected.txt'],
        ];
    }
    public function testRunDifferenceExceptionUnknownExtension()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Unknown extension: xml");
        genDiff($this->getFilePath('file1.xml'), $this->getFilePath('file2.json'));
    }
    public function testRunDifferenceExceptionErrorReadingFile()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Error reading file: file1.jsn");
        genDiff($this->getFilePath('file1.jsn'), $this->getFilePath('file2.json'));
    }
}
