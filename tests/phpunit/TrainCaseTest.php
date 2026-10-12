<?php declare(strict_types=1);

namespace Jawira\CaseConverterTests;

use Jawira\CaseConverter\Glue\TrainCase;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

/**
 * @internal
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 *
 * @coversNothing
 */
class TrainCaseTest extends TestCase
{
  /**
   * @covers \Jawira\CaseConverter\Glue\TrainCase::glue
   */
  public function testGlue()
  {
    // Disabling constructor with one stub method
    $mock = $this->getMockBuilder(TrainCase::class)
      ->disableOriginalConstructor()
      ->setMethods(['glueUsingRules'])
      ->getMock()
    ;

    // Setting titleCase and lowerCase properties
    $reflectionObject = new ReflectionObject($mock);
    $titleCaseProperty = $reflectionObject->getProperty('titleCase');
    $titleCaseProperty->setAccessible(true);
    $titleCaseProperty->setValue($mock, 123);

    // Configuring stub
    $mock->expects($this->once())
      ->method('glueUsingRules')
      ->with(TrainCase::DELIMITER, 123)
      ->willReturn('e1bfd762321e409cee4ac0b6e841963c')
    ;

    /** @var TrainCase $mock */
    $returned = $mock->glue();
    $this->assertSame('e1bfd762321e409cee4ac0b6e841963c', $returned, 'Returned value is not the expected');
  }
}
