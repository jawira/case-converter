<?php

use Jawira\CaseConverter\Glue\LowerCase;
use PHPUnit\Framework\TestCase;

class LowerCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\Glue\LowerCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(LowerCase::class)
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
             ->with(LowerCase::DELIMITER, 456)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\Glue\LowerCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
