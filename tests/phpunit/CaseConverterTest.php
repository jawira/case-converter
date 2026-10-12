<?php declare(strict_types=1);

namespace Jawira\CaseConverterTests;

use Jawira\CaseConverter\CaseConverter;
use Jawira\CaseConverter\CaseConverterException;
use Jawira\CaseConverter\Convert;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 *
 * @coversNothing
 */
class CaseConverterTest extends TestCase
{
  /**
   * @covers \Jawira\CaseConverter\CaseConverter::convert
   * @covers \Jawira\CaseConverter\Convert::__construct
   * @covers \Jawira\CaseConverter\Convert::analyse
   * @covers \Jawira\CaseConverter\Convert::extractWords
   * @covers \Jawira\CaseConverter\Convert::fromAuto
   * @covers \Jawira\CaseConverter\Convert::getSource
   * @covers \Jawira\CaseConverter\Split\DashSplitter::split
   * @covers \Jawira\CaseConverter\Split\Splitter::__construct
   * @covers \Jawira\CaseConverter\Split\Splitter::splitUsingPattern
   *
   * @throws CaseConverterException
   */
  public function testConvert()
  {
    $cc = new CaseConverter();

    $convertObject = $cc->convert('hello-world-484');

    $this->assertInstanceOf(Convert::class, $convertObject);
    $this->assertSame('hello-world-484', $convertObject->getSource());
  }
}
