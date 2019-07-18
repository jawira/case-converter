<?php

use Jawira\CaseConverter\Glue\CamelCase;
use PHPUnit\Framework\TestCase;

/**
 * Class CamelCaseTest
 */
class CamelCaseTest extends TestCase
{
    /**
     * Testing that `glue()` method is called and `titleCase` and `lowerCase`
     * properties are being used.
     *
     * @covers \Jawira\CaseConverter\Glue\CamelCase::glue
     * @throws \ReflectionException
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(CamelCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Setting titleCase and lowerCase properties
        $reflectionObject   = new ReflectionObject($mock);
        $titleCaseProperty = $reflectionObject->getProperty('titleCase');
        $titleCaseProperty->setAccessible(true);
        $titleCaseProperty->setValue($mock, 123);
        $lowerCaseProperty = $reflectionObject->getProperty('lowerCase');
        $lowerCaseProperty->setAccessible(true);
        $lowerCaseProperty->setValue($mock, 456);

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(CamelCase::DELIMITER, 123, 456)
             ->willReturn('dummy-value-32ea');

        /** @var \Jawira\CaseConverter\Glue\CamelCase $mock */
        $returned = $mock->glue();
        $this->assertSame('dummy-value-32ea', $returned, 'Returned value is not the expected');
    }
}
