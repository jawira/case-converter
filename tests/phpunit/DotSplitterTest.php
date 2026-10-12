<?php declare(strict_types=1);

namespace Jawira\CaseConverterTests;

use Jawira\CaseConverter\CaseConverterException;
use Jawira\CaseConverter\Split\DotSplitter;
use Jawira\CaseConverter\Split\UnderscoreSplitter;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionObject;

/**
 * @internal
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 *
 * @coversNothing
 */
class DotSplitterTest extends TestCase
{
  /**
   * @covers       \Jawira\CaseConverter\Split\DotSplitter::split
   *
   * @throws CaseConverterException
   * @throws ReflectionException
   */
  public function testSplit()
  {
    // Disabling constructor with one stub method
    $mock = $this->getMockBuilder(DotSplitter::class)
      ->disableOriginalConstructor()
      ->setMethods(['splitUsingPattern'])
      ->getMock()
    ;

    // Setting value to protected property
    $reflectionObject = new ReflectionObject($mock);
    $reflectionProperty = $reflectionObject->getProperty('inputString');
    $reflectionProperty->setAccessible(true);
    $reflectionProperty->setValue($mock, 'dummyString');

    // Configuring stub
    $mock->expects($this->once())
      ->method('splitUsingPattern')
      ->with('dummyString', '#\.+#u')
      ->willReturn(['dummy', 'array'])
    ;

    /** @var UnderscoreSplitter $mock */
    $returned = $mock->split();
    $this->assertSame(['dummy', 'array'], $returned);
  }
}
