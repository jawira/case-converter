<?php
use Jawira\CaseConverter\Convert;
use PHPUnit\Framework\TestCase;

class ConvertTest extends TestCase
{

    public function testFromCamelToSnake()
    {
        $case = new Convert('HelloWorld');
        $this->assertSame('hello_world', (string)$case);
    }
}
