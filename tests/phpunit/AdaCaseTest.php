<?php

use Jawira\CaseConverter\Glue\AdaCase;
use PHPUnit\Framework\TestCase;

/**
 * Class AdaCaseTest
 */
class AdaCaseTest extends TestCase
{
    /**
     * Testing that `glue` method is called and `titleCase` property is used
     *
     * @covers \Jawira\CaseConverter\Glue\AdaCase::glue
     * @throws \ReflectionException
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(AdaCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Setting proper titleCase property value
        $reflectionObject   = new ReflectionObject($mock);
        $titleCaseProperty = $reflectionObject->getProperty('titleCase');
        $titleCaseProperty->setAccessible(true);
        $titleCaseProperty->setValue($mock, 123);

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(AdaCase::DELIMITER, 123)
             ->willReturn('dummy-value-e1bfd');

        /** @var \Jawira\CaseConverter\Glue\AdaCase $mock */
        $returned = $mock->glue();
        $this->assertSame('dummy-value-e1bfd', $returned, 'Returned value is not the expected');
    }
}
