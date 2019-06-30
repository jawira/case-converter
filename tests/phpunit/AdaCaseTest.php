<?php

use Jawira\CaseConverter\Glue\AdaCase;
use PHPUnit\Framework\TestCase;

class AdaCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\Glue\AdaCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(AdaCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(AdaCase::DELIMITER, MB_CASE_TITLE)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\Glue\AdaCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
