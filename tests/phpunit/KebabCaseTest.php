<?php

use Jawira\CaseConverter\Glue\KebabCase;
use PHPUnit\Framework\TestCase;

class KebabCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\Glue\KebabCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(KebabCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(KebabCase::DELIMITER, MB_CASE_LOWER)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\Glue\KebabCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
