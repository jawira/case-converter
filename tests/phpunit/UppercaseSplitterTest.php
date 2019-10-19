<?php

use Jawira\CaseConverter\Split\UppercaseSplitter;
use PHPUnit\Framework\TestCase;

class UppercaseSplitterTest extends TestCase
{
    /**
     * @covers       \Jawira\CaseConverter\Split\UppercaseSplitter::split
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     * @throws \ReflectionException
     */
    public function testSplit()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(UppercaseSplitter::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['splitUsingPattern'])
                     ->getMock();

        // Setting value to protected property
        $reflectionObject   = new ReflectionObject($mock);
        $reflectionProperty = $reflectionObject->getProperty('inputString');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($mock, 'dummyString');

        // Configuring stub
        $mock->expects($this->once())
             ->method('splitUsingPattern')
             ->with('dummyString', '#(?=\p{Lu}{1})#u')
             ->willReturn(['dummy', 'array']);

        /** @var \Jawira\CaseConverter\Split\UnderscoreSplitter $mock */
        $returned = $mock->split();
        $this->assertSame(['dummy', 'array'], $returned);
    }
}
