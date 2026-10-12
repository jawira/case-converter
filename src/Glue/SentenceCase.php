<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

/**
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
class SentenceCase extends SpaceGluer
{
  public function glue(): string
  {
    return $this->glueUsingRules(self::DELIMITER, $this->lowerCase, $this->titleCase);
  }
}
