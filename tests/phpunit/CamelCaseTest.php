<?php

use Jawira\CaseConverter\CamelCase;
use PHPUnit\Framework\TestCase;

class CamelCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\CamelCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(CamelCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(CamelCase::DELIMITER, MB_CASE_TITLE)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\CamelCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
