<?php

use Jawira\CaseConverter\Split\UppercaseSplitter;
use PHPUnit\Framework\TestCase;

class UppercaseSplitterTest extends TestCase
{
    /**
     * @covers       \Jawira\CaseConverter\Split\UppercaseSplitter::split
     * @dataProvider splitProvider
     *
     * @param string $inputString
     * @param string $newString
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     * @throws \ReflectionException
     */
    public function testSplit($inputString, $newString)
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(UppercaseSplitter::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['splitUsingUnderscore'])
                     ->getMock();

        // Setting value to protected property
        $reflectionObject   = new ReflectionObject($mock);
        $reflectionProperty = $reflectionObject->getProperty('inputString');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($mock, $inputString);

        // Configuring stub
        $mock->expects($this->once())
             ->method('splitUsingUnderscore')
             ->with($newString)
             ->willReturn(['dummy', 'array']);

        /** @var \Jawira\CaseConverter\Split\UppercaseSplitter $mock */
        $returned = $mock->split();
        $this->assertSame(['dummy', 'array'], $returned);
    }

    public function splitProvider()
    {
        return [
            ['ABCDE', '_A_B_C_D_E'],
            ['HelloWorld', '_Hello_World'],
            ['helloWorld', 'hello_World'],
        ];
    }

    /**
     * @covers \Jawira\CaseConverter\Split\UppercaseSplitter::splitUsingUnderscore
     * @covers \Jawira\CaseConverter\Split\UnderscoreSplitter::split
     * @covers \Jawira\CaseConverter\Split\Splitter::__construct
     * @covers \Jawira\CaseConverter\Split\Splitter::splitUsingPattern
     *
     * @dataProvider splitUsingUnderscoreProvider
     *
     * @param string $inputString
     * @param array  $expected
     *
     * @throws \ReflectionException
     */
    public function testSplitUsingUnderscore($inputString = 'hello_world', $expected = ['hello', 'world'])
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(UppercaseSplitter::class)
                     ->disableOriginalConstructor()
                     ->setMethods([])
                     ->getMock();

        // Invoking protected method
        $method = new ReflectionMethod($mock, 'splitUsingUnderscore');
        $method->setAccessible(true);
        $result = $method->invokeArgs($mock, [$inputString]);

        $this->assertSame($expected, $result);
    }

    public function splitUsingUnderscoreProvider()
    {
        return [
            ['input_string', ['input', 'string']],
            ['___input_string___', ['input', 'string']],
            ['HeLLo_wORLd', ['HeLLo', 'wORLd']],
        ];
    }
}
