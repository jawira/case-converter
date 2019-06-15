<?php

use Jawira\CaseConverter\SentenceCase;
use PHPUnit\Framework\TestCase;

class SentenceCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\SentenceCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(SentenceCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(SentenceCase::DELIMITER, MB_CASE_LOWER, MB_CASE_TITLE)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\SentenceCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
