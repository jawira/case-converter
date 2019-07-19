<?php

use Jawira\CaseConverter\Glue\TitleCase;
use PHPUnit\Framework\TestCase;

class TitleCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\Glue\TitleCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(TitleCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Setting titleCase and lowerCase properties
        $reflectionObject  = new ReflectionObject($mock);
        $titleCaseProperty = $reflectionObject->getProperty('titleCase');
        $titleCaseProperty->setAccessible(true);
        $titleCaseProperty->setValue($mock, 123);

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(TitleCase::DELIMITER, 123)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\TitleCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
