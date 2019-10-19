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
     * @param string $expected
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     * @throws \ReflectionException
     */
    public function testSplit($inputString, $expected)
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(UppercaseSplitter::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Setting value to protected property
        $reflectionObject   = new ReflectionObject($mock);
        $reflectionProperty = $reflectionObject->getProperty('inputString');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($mock, $inputString);

        /** @var \Jawira\CaseConverter\Split\UppercaseSplitter $mock */
        $returned = $mock->split();
        $this->assertSame($expected, $returned);
    }

    public function splitProvider()
    {
        return [['ABCDE', ['A', 'B', 'C', 'D', 'E']], ['HelloWorld', ['Hello', 'World']],
                ['helloWorld', ['hello', 'World']],];
    }
}
