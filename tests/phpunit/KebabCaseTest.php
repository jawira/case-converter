<?php

use Jawira\CaseConverter\Glue\KebabCase;
use PHPUnit\Framework\TestCase;

class KebabCaseTest extends TestCase
{
    /**
     * Testing that `glue` method is called and `lowerCase` property is used.
     *
     * @covers \Jawira\CaseConverter\Glue\KebabCase::glue
     * @throws \ReflectionException
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(KebabCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Setting lowerCase properties
        $reflectionObject  = new ReflectionObject($mock);
        $titleCaseProperty = $reflectionObject->getProperty('lowerCase');
        $titleCaseProperty->setAccessible(true);
        $titleCaseProperty->setValue($mock, 456);

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(KebabCase::DELIMITER, 456)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\Glue\KebabCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
