<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use RuntimeException;
use function Difference\Difference\runDiff;
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
    public function testRunDifference($pathFirst, $pathSecond, $expected): void
    {
        $this->assertStringEqualsFile(
            $this->getFilePath($expected),
            runDiff($this->getFilePath($pathFirst), $this->getFilePath($pathSecond))
        );
    }
    public static function RunDifferenceProvider(): array
    {
        return [
            ['plain1.json', 'plain2.json', 'Plain-expected.txt'],
            ['plain1.yaml', 'plain2.yaml', 'Plain-expected.txt'],
            ['nested1.json', 'nested2.json', 'Nested-expected.txt'],
            ['nested1.json', 'nested2.json', 'Nested-expected.txt'],
        ];
    }
    public function testRunDifferenceException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unknown extension!');
        runDiff($this->getFilePath('plain1.jsn'), $this->getFilePath('plain2.jn'));
    }
}