<?php

use Jawira\CaseConverter\Gluer;
use PHPUnit\Framework\TestCase;

class GluerTest extends TestCase
{
    /**
     * @covers       \Jawira\CaseConverter\Gluer::glueUsingRules
     * @dataProvider glueUsingRulesProvider
     *
     * @param array  $words
     * @param string $glue
     * @param int    $wordsMode
     * @param        $firstWordMode
     * @param string $expected
     *
     * @throws \ReflectionException
     */
    public function testGlueUsingRules(array $words, string $glue, int $wordsMode, $firstWordMode, string $expected)
    {
        // Disabling constructor without stub methods
        $mock = $this->getMockBuilder(Gluer::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['changeWordsCase', 'changeFirstWordCase'])
                     ->getMockForAbstractClass();

        // Making "words" property accessible and setting a value
        $reflection = new ReflectionObject($mock);
        $property   = $reflection->getProperty('words');
        $property->setAccessible(true);
        $property->setValue($mock, $words);

        // Making public a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod('glueUsingRules');
        $method->setAccessible(true);

        // Expectations for changeWordsCase
        $mock->expects($this->once())
             ->method('changeWordsCase')
             ->with($this->equalTo($words, $wordsMode))
             ->will($this->returnValue($words));

        // Only checking that method is called
        $expectation = ($firstWordMode) ? $this->once() : $this->never();
        $mock->expects($expectation)
             ->method('changeFirstWordCase')
             ->with($words, $firstWordMode)
             ->will($this->returnValue($words));

        // Testing
        $output = $method->invoke($mock, $glue, $wordsMode, $firstWordMode);
        $this->assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function glueUsingRulesProvider()
    {
        return [
            [['fOo', 'bAr'], '§', MB_CASE_LOWER, null, 'fOo§bAr'],
            [['fOo', 'bAr'], '§', MB_CASE_LOWER, MB_CASE_LOWER, 'fOo§bAr'],
            [['fOo', 'bAr'], 'X', MB_CASE_LOWER, null, 'fOoXbAr'],
            [['fOo', 'bAr'], 'X', MB_CASE_LOWER, MB_CASE_LOWER, 'fOoXbAr'],
        ];
    }
}
