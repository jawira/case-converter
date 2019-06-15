<?php

use Jawira\CaseConverter\SnakeCase;
use PHPUnit\Framework\TestCase;

class SnakeCaseTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\SnakeCase::glue
     */
    public function testGlue()
    {
        // Disabling constructor with one stub method
        $mock = $this->getMockBuilder(SnakeCase::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('glueUsingRules')
             ->with(SnakeCase::DELIMITER, MB_CASE_LOWER)
             ->willReturn('e1bfd762321e409cee4ac0b6e841963c');

        /** @var \Jawira\CaseConverter\SnakeCase $mock */
        $returned = $mock->glue();
        $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
    }
}
