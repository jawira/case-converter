<?php

use Jawira\CaseConverter\DashSplitter;
use PHPUnit\Framework\TestCase;

class DashSplitterTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\DashSplitter::split
     */
    public function testSplit()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(DashSplitter::class)
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
             ->with('dummyString', '-+')
             ->willReturn(['dummy', 'array']);

        /** @var \Jawira\CaseConverter\DashSplitter $mock */
        $returned = $mock->split();
        $this->assertSame(['dummy', 'array'], $returned);
    }
}
