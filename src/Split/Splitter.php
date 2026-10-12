<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\CaseConverterException;

use function preg_split;

/**
 * Class Splitter.
 *
 * A Splitter subclass allows to read the words contained in a string
 *
 * @author  Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
abstract class Splitter
{
  final public function __construct(
    /**
     * @var string Words extracted from input string
     */
    protected string $inputString
  ) {}

  /**
   * Tells how to split a string into valid words.
   *
   * @return string[]
   */
  abstract public function split(): array;

  /**
   * This is a utility method, typically this method is used by to split a string based on pattern.
   *
   * @return string[]
   *
   * @throws CaseConverterException
   */
  protected function splitUsingPattern(string $inputString, string $pattern): array
  {
    if (empty($pattern)) {
      throw new CaseConverterException('Pattern must not be empty.'); // @codeCoverageIgnore
    }

    $words = preg_split($pattern, $inputString, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

    if (false === $words) {
      throw new CaseConverterException("Error while processing {$this->inputString}"); // @codeCoverageIgnore
    }

    return $words;
  }
}
