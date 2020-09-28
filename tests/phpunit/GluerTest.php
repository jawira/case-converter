<?php

use Jawira\CaseConverter\Glue\Gluer;
use PHPUnit\Framework\TestCase;

class GluerTest extends TestCase
{
    /**
     * @covers       \Jawira\CaseConverter\Glue\Gluer::glueUsingRules
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

    /**
     * @covers       \Jawira\CaseConverter\Glue\Gluer::changeWordsCase
     * @dataProvider changeWordsCaseProvider
     *
     * @param array $words
     * @param int   $caseMode
     * @param array $expected
     *
     * @throws \ReflectionException
     */
    public function testChangeWordsCase($words, $caseMode, $expected)
    {
        // Disabling constructor without stub methods
        $mock = $this->getMockBuilder(Gluer::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMockForAbstractClass();

        // Making public a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod('changeWordsCase');
        $method->setAccessible(true);
        $result = $method->invoke($mock, $words, $caseMode);

        $this->assertSame($expected, $result);
    }

    public function changeWordsCaseProvider()
    {
        return [
            [[], MB_CASE_LOWER, []],
            [['hola', 'mundo'], MB_CASE_LOWER, ['hola', 'mundo']],
            [['hola', 'mundo'], MB_CASE_UPPER, ['HOLA', 'MUNDO']],
            [['hola', 'mundo'], MB_CASE_TITLE, ['Hola', 'Mundo']],
            [['HoLa', 'MuNdO'], MB_CASE_LOWER, ['hola', 'mundo']],
            [['HoLa', 'MuNdO'], MB_CASE_UPPER, ['HOLA', 'MUNDO']],
            [['HoLa', 'MuNdO'], MB_CASE_TITLE, ['Hola', 'Mundo']],
        ];
    }

    /**
     * @covers       \Jawira\CaseConverter\Glue\Gluer::changeFirstWordCase
     * @dataProvider changeFirstWordCaseProvider
     *
     * @param array $words
     * @param int   $caseMode
     * @param array $expected
     *
     * @throws \ReflectionException
     */
    public function testChangeFirstWordsCase($words, $caseMode, $expected)
    {
        // Disabling constructor without stub methods
        $mock = $this->getMockBuilder(Gluer::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMockForAbstractClass();

        // Making public a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod('changeFirstWordCase');
        $method->setAccessible(true);
        $result = $method->invoke($mock, $words, $caseMode);

        $this->assertSame($expected, $result);
    }

    public function changeFirstWordCaseProvider()
    {
        return [
            [[], MB_CASE_LOWER, []],
            [['hola', 'mundo'], MB_CASE_LOWER, ['hola', 'mundo']],
            [['hola', 'mundo'], MB_CASE_UPPER, ['HOLA', 'mundo']],
            [['hola', 'mundo'], MB_CASE_TITLE, ['Hola', 'mundo']],
            [['HoLa', 'MuNdO'], MB_CASE_LOWER, ['hola', 'MuNdO']],
            [['HoLa', 'MuNdO'], MB_CASE_UPPER, ['HOLA', 'MuNdO']],
            [['HoLa', 'MuNdO'], MB_CASE_TITLE, ['Hola', 'MuNdO']],
        ];
    }

    /**
     * @requires     PHP 7.3
     * @covers       \Jawira\CaseConverter\Glue\Gluer::setSimpleCaseMappingConstants
     * @throws \ReflectionException
     */
    public function testSet()
    {
        // Disabling constructor without stub methods
        $mock = $this->getMockBuilder(Gluer::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueUsingRules'])
                     ->getMockForAbstractClass();

        // Making accessible a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod('setSimpleCaseMappingConstants');
        $method->setAccessible(true);
        $result = $method->invoke($mock);

        $this->assertInstanceOf(Gluer::class, $result);
        $this->assertAttributeSame(Gluer::getValueOfConstant(Gluer::BASIC_CONSTANT_CASE_UPPER), 'upperCase', $mock);
        $this->assertAttributeSame(Gluer::getValueOfConstant(Gluer::BASIC_CONSTANT_CASE_LOWER), 'lowerCase', $mock);
        $this->assertAttributeSame(Gluer::getValueOfConstant(Gluer::BASIC_CONSTANT_CASE_TITLE), 'titleCase', $mock);
    }

    /**
     * @covers       \Jawira\CaseConverter\Glue\Gluer::__construct
     * @dataProvider constructorProvider
     *
     *
     * @param array $words
     * @param bool  $forceSimpleCaseMapping
     * @param int   $callCount
     *
     * @throws \ReflectionException
     */
    public function testConstructor(array $words = ['ab', 'cd'], bool $forceSimpleCaseMapping = false, int $callCount = 0)
    {
        // Disabling constructor without stub methods
        $mock = $this->getMockBuilder(Gluer::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['setSimpleCaseMappingConstants'])
                     ->getMockForAbstractClass();

        // Method will be called once
        $mock->expects($this->exactly($callCount))
             ->method('setSimpleCaseMappingConstants');

        // now call the constructor
        $reflectedClass = new ReflectionClass($mock);
        $constructor    = $reflectedClass->getConstructor();
        $constructor->invoke($mock, $words, $forceSimpleCaseMapping);

        $this->assertAttributeSame(0, 'upperCase', $mock);
        $this->assertAttributeSame(1, 'lowerCase', $mock);
        $this->assertAttributeSame(2, 'titleCase', $mock);
        $this->assertAttributeSame($words, 'words', $mock);
    }

    public function constructorProvider()
    {
        return [
            [['dummy', 'f4s2Q'], false, 0],
            [['dummy', '7e7e7'], true, 1],
        ];
    }
}
