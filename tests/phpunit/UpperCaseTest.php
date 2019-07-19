<?php

use Jawira\CaseConverter\Glue\UpperCase;
use PHPUnit\Framework\TestCase;

class UpperCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\Glue\UpperCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(UpperCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Setting titleCase and lowerCase properties
        $reflectionObject  = new ReflectionObject($mock);
        $titleCaseProperty = $reflectionObject->getProperty('upperCase');
        $titleCaseProperty->setAccessible(true);
        $titleCaseProperty->setValue($mock, 789);

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(UpperCase::DELIMITER, 789)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\Glue\UpperCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
