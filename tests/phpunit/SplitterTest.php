<?php declare(strict_types=1);

namespace Jawira\CaseConverterTests;

use Jawira\CaseConverter\Split\SpaceSplitter;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionMethod;

/**
 * @internal
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 *
 * @coversNothing
 */
class SplitterTest extends TestCase
{
  /**
   * @covers       \Jawira\CaseConverter\Split\SpaceSplitter::splitUsingPattern
   *
   * @dataProvider splitUsingPatternProvider
   *
   * @param mixed $inputString
   * @param mixed $pattern
   * @param mixed $expected
   *
   * @throws ReflectionException
   */
  public function testSplitUsingPattern($inputString, $pattern, $expected)
  {
    // Disabling constructor with one stub method
    $mock = $this->getMockBuilder(SpaceSplitter::class)
      ->disableOriginalConstructor()
      ->setMethods([])
      ->getMock()
    ;

    // Invoking protected method
    $method = new ReflectionMethod($mock, 'splitUsingPattern');
    $method->setAccessible(true);
    $result = $method->invokeArgs($mock, [$inputString, $pattern]);

    $this->assertSame($expected, $result);
  }

  public function splitUsingPatternProvider()
  {
    return [
      ['', '#-+#u', []],
      ['hola-mundo', '#-+#u', ['hola', 'mundo']],
      ['-hola-mundo-', '#-+#u', ['hola', 'mundo']],
      ['---hola-----mundo---', '#-+#u', ['hola', 'mundo']],
      ['0', '#-+#u', ['0']],
      ['---0---0---', '#-+#u', ['0', '0']],
      ['---000---000---', '#-+#u', ['000', '000']],
    ];
  }
}
