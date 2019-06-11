<?php

use Jawira\CaseConverter\UpperCase;
use PHPUnit\Framework\TestCase;

class UpperCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\UpperCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(UpperCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(UpperCase::DELIMITER, MB_CASE_UPPER)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\UpperCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
