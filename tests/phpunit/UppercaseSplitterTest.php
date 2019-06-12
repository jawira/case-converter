<?php

use Jawira\CaseConverter\UppercaseSplitter;
use PHPUnit\Framework\TestCase;

class UppercaseSplitterTest extends TestCase
{
    /**
     * @covers       \Jawira\CaseConverter\UppercaseSplitter::split
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

        /** @var \Jawira\CaseConverter\UppercaseSplitter $mock */
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
     * @covers \Jawira\CaseConverter\UppercaseSplitter::splitUsingUnderscore
     * @covers \Jawira\CaseConverter\UnderscoreSplitter::split
     * @covers \Jawira\CaseConverter\Splitter::__construct
     * @covers \Jawira\CaseConverter\Splitter::splitUsingPattern
     *
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
}
