<?php

use Jawira\CaseConverter\SpaceSplitter;
use PHPUnit\Framework\TestCase;

class SplitterTest extends TestCase
{
    /**
     * @covers       \Jawira\CaseConverter\SpaceSplitter::splitUsingPattern
     * @dataProvider splitUsingPatternProvider
     *
     * @param $inputString
     * @param $pattern
     * @param $expected
     *
     * @throws \ReflectionException
     */
    public function testSplitUsingPattern($inputString, $pattern, $expected)
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(SpaceSplitter::class)
                     ->disableOriginalConstructor()
                     ->setMethods([])
                     ->getMock();

        // Invoking protected method
        $method = new ReflectionMethod($mock, 'splitUsingPattern');
        $method->setAccessible(true);
        $result = $method->invokeArgs($mock, [$inputString, $pattern]);

        $this->assertSame($expected, $result);
    }

    public function splitUsingPatternProvider()
    {
        return [
            ['', '-+', []],
            ['hola-mundo', '-+', ['hola', 'mundo']],
            ['-hola-mundo-', '-+', ['hola', 'mundo']],
            ['---hola-----mundo---', '-+', ['hola', 'mundo']],
        ];
    }
}
