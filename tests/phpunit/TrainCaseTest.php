<?php

use Jawira\CaseConverter\Glue\TrainCase;
use PHPUnit\Framework\TestCase;

class TrainCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\Glue\TrainCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(TrainCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(TrainCase::DELIMITER, MB_CASE_TITLE)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\Glue\TrainCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
