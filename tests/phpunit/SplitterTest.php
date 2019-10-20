<?php

use Jawira\CaseConverter\Split\SpaceSplitter;
use PHPUnit\Framework\TestCase;

class SplitterTest extends TestCase
{
    /**
     * @covers       \Jawira\CaseConverter\Split\SpaceSplitter::splitUsingPattern
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
            ['', '#-+#u', []],
            ['hola-mundo', '#-+#u', ['hola', 'mundo']],
            ['-hola-mundo-', '#-+#u', ['hola', 'mundo']],
            ['---hola-----mundo---', '#-+#u', ['hola', 'mundo']],
            ['0', '#-+#u', ['0']],
            ['---0---0---', '#-+#u', ['0', '0']],
            ['---000---000---', '#-+#u', ['000', '000']],
        ];
    }
}
