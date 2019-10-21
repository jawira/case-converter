<?php

use Jawira\CaseConverter\Split\DotSplitter;
use PHPUnit\Framework\TestCase;

class DotSplitterTest extends TestCase
{
    /**
     * @covers       \Jawira\CaseConverter\Split\DotSplitter::split
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     * @throws \ReflectionException
     */
    public function testSplit()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(DotSplitter::class)
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
             ->with('dummyString', '#\\.+#u')
             ->willReturn(['dummy', 'array']);

        /** @var \Jawira\CaseConverter\Split\UnderscoreSplitter $mock */
        $returned = $mock->split();
        $this->assertSame(['dummy', 'array'], $returned);
    }
}
