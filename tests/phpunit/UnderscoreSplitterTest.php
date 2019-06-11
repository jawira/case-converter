<?php

use Jawira\CaseConverter\UnderscoreSplitter;
use PHPUnit\Framework\TestCase;

class UnderscoreSplitterTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\UnderscoreSplitter::split
     * @throws \ReflectionException
     */
    public function testSplit()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(UnderscoreSplitter::class)
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
             ->with('dummyString', '_+')
             ->willReturn(['dummy', 'array']);

        /** @var \Jawira\CaseConverter\UnderscoreSplitter $mock */
        $returned = $mock->split();
        $this->assertSame(['dummy', 'array'], $returned);
    }
}
