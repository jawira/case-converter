<?php declare(strict_types=1);

namespace Jawira\CaseConverterTests;

use Jawira\CaseConverter\Glue\CobolCase;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionObject;

/**
 * Class CobolCaseTest.
 *
 * @internal
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 *
 * @coversNothing
 */
class CobolCaseTest extends TestCase
{
  /**
   * Testing that `glue` method is called and `upperCase` property is used.
   *
   * @covers \Jawira\CaseConverter\Glue\CobolCase::glue
   *
   * @throws ReflectionException
   */
  public function testGlue()
  {
    // Disabling constructor with one stub method
    $mock = $this->getMockBuilder(CobolCase::class)
      ->disableOriginalConstructor()
      ->setMethods(['glueUsingRules'])
      ->getMock()
    ;

    // Setting `upperCase` property value
    $reflectionObject = new ReflectionObject($mock);
    $titleCaseProperty = $reflectionObject->getProperty('upperCase');
    $titleCaseProperty->setAccessible(true);
    $titleCaseProperty->setValue($mock, 789);

    // Configuring stub
    $mock->expects($this->once())
      ->method('glueUsingRules')
      ->with(CobolCase::DELIMITER, 789)
      ->willReturn('e1bfd762321e409cee4ac0b6e841963c')
    ;

    /** @var CobolCase $mock */
    $returned = $mock->glue();
    $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
  }
}
