<?php

use Jawira\CaseConverter\Glue\SnakeCase;
use PHPUnit\Framework\TestCase;

class SnakeCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\Glue\SnakeCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(SnakeCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Setting titleCase and lowerCase properties
        $reflectionObject  = new ReflectionObject($mock);
        $lowerCaseProperty = $reflectionObject->getProperty('lowerCase');
        $lowerCaseProperty->setAccessible(true);
        $lowerCaseProperty->setValue($mock, 456);

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(SnakeCase::DELIMITER, 456)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\Glue\SnakeCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
