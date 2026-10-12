<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\CaseConverterException;

/**
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
class UppercaseSplitter extends Splitter
{
  // language=PhpRegExp
  public const PATTERN = '#(?=\p{Lu}{1})#u';

  /**
   * Splits $words using Uppercase letters.
   *
   * @see https://www.regular-expressions.info/unicode.html#category
   *
   * @return string[] Words in $input
   *
   * @throws CaseConverterException
   */
  public function split(): array
  {
    return $this->splitUsingPattern($this->inputString, self::PATTERN);
  }
}
