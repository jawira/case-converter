<?php

use Jawira\CaseConverter\Glue\SentenceCase;
use PHPUnit\Framework\TestCase;

class SentenceCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\Glue\SentenceCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(SentenceCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Setting titleCase and lowerCase properties
        $reflectionObject  = new ReflectionObject($mock);
        $titleCaseProperty = $reflectionObject->getProperty('titleCase');
        $titleCaseProperty->setAccessible(true);
        $titleCaseProperty->setValue($mock, 123);
        $lowerCaseProperty = $reflectionObject->getProperty('lowerCase');
        $lowerCaseProperty->setAccessible(true);
        $lowerCaseProperty->setValue($mock, 456);

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(SentenceCase::DELIMITER, 456, 123)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\Glue\SentenceCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
