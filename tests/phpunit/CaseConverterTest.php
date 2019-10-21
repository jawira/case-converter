<?php

use Jawira\CaseConverter\CaseConverter;
use Jawira\CaseConverter\Convert;
use PHPUnit\Framework\TestCase;

class CaseConverterTest extends TestCase
{
    /**
     * @covers \Jawira\CaseConverter\CaseConverter::convert
     *
     * @covers \Jawira\CaseConverter\Convert::__construct
     * @covers \Jawira\CaseConverter\Convert::analyse
     * @covers \Jawira\CaseConverter\Convert::contains
     * @covers \Jawira\CaseConverter\Convert::extractWords
     * @covers \Jawira\CaseConverter\Convert::fromAuto
     * @covers \Jawira\CaseConverter\Convert::getSource
     * @covers \Jawira\CaseConverter\Split\DashSplitter::split
     * @covers \Jawira\CaseConverter\Split\Splitter::__construct
     * @covers \Jawira\CaseConverter\Split\Splitter::splitUsingPattern
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function testConvert()
    {
        $cc = new CaseConverter();

        $convertObject = $cc->convert('hello-world-484');

        $this->assertInstanceOf(Convert::class, $convertObject);
        $this->assertSame('hello-world-484', $convertObject->getSource());
    }
}
