<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

/**
 * Class CaseConverter
 *
 * Factory class which returns a Convert object.
 *
 * @author  Jawira Portugal <dev@tugal.be>
 */
class CaseConverter implements CaseConverterInterface
{
    /**
     * Returns a Convert object
     *
     * @param string $source Input string to be converted
     *
     * @return \Jawira\CaseConverter\Convert
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function convert(string $source): Convert
    {
        return new Convert($source);
    }
}
