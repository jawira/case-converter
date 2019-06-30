<?php

use Jawira\CaseConverter\Glue\MacroCase;
use PHPUnit\Framework\TestCase;

class MacroCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\Glue\MacroCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(MacroCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(MacroCase::DELIMITER, MB_CASE_UPPER)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\Glue\MacroCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
