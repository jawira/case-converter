<?php

use Jawira\CaseConverter\AdaCase;
use Jawira\CaseConverter\CamelCase;
use Jawira\CaseConverter\CobolCase;
use Jawira\CaseConverter\Convert;
use Jawira\CaseConverter\DashBased;
use Jawira\CaseConverter\KebabCase;
use Jawira\CaseConverter\LowerCase;
use Jawira\CaseConverter\MacroCase;
use Jawira\CaseConverter\PascalCase;
use Jawira\CaseConverter\SentenceCase;
use Jawira\CaseConverter\SnakeCase;
use Jawira\CaseConverter\SpaceBased;
use Jawira\CaseConverter\TitleCase;
use Jawira\CaseConverter\TrainCase;
use Jawira\CaseConverter\UnderscoreBased;
use Jawira\CaseConverter\UpperCase;
use Jawira\CaseConverter\UppercaseBased;
use PHPUnit\Framework\TestCase;

/**
 * Unitary tests for \Jawira\CaseConverter\Convert
 *
 * @see https://jtreminio.com/blog/unit-testing-tutorial-part-i-introduction-to-phpunit/
 */
class ConvertTest extends TestCase
{

    /**
     * Testing \Jawira\CaseConverter\Convert::__construct
     *
     * Tests if constructor calls \Jawira\CaseConverter\Convert::load.
     *
     * @covers \Jawira\CaseConverter\Convert::__construct()
     */
    public function testConstructor()
    {
        // Disable constructor mocking one method
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['extractWords'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('extractWords')
             ->with($this->equalTo('hello_world'));

        $class = new ReflectionObject($mock);
        $class->getConstructor()
              ->invoke($mock, 'hello_world');
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::isUppercaseWord()
     *
     * @param string $inputString
     * @param bool   $expectedResult
     *
     * @dataProvider isUppercaseWordProvider
     *
     * @throws \ReflectionException
     */
    public function testIsUppercaseWord(string $inputString, bool $expectedResult)
    {
        // Disabling constructor without stub methods
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Removing protected for analyse method
        $reflection = new ReflectionObject($stub);
        $method     = $reflection->getMethod('isUppercaseWord');
        $method->setAccessible(true);

        $output = $method->invoke($stub, $inputString);

        $this->assertSame($expectedResult, $output);
    }

    public function isUppercaseWordProvider()
    {
        return [
            ['X', true],
            ['YES', true],
            ['HELLO', true],
            ['', false],
            ['x', false],
            ['HELLOxWORLD', false],
            ['HELLO-WORLD', false],
            ['HELLO_WORLD', false],
            ['HelloWorld', false],
        ];
    }

    /**
     * Testing \Jawira\CaseConverter\Convert::analyse
     *
     * \Jawira\CaseConverter\Convert::analyse should return Convert::SNAKE if $input contains '_'.
     *
     * @covers       \Jawira\CaseConverter\Convert::analyse()
     * @dataProvider analyseProvider
     *
     * @param bool   $isUppercaseWordReturn Times that `isUppercaseWord()` method is called.
     * @param string $expected              Expected result
     * @param string $input                 Input string
     *
     * @throws \ReflectionException
     */
    public function testAnalyse(bool $isUppercaseWordReturn, string $expected, string $input)
    {
        // Disabling constructor with one stub method
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['isUppercaseWord'])
                     ->getMock();

        // Configuring expectation
        $stub->expects($this->any())
             ->method('isUppercaseWord')
             ->willReturn($isUppercaseWordReturn);

        // Removing protected for analyse method
        $reflection = new ReflectionObject($stub);
        $method     = $reflection->getMethod('analyse');
        $method->setAccessible(true);

        // Testing
        $output = $method->invoke($stub, $input);
        $this->assertSame($expected, $output);
    }

    public function analyseProvider()
    {
        return [
            'Underscore 1' => [false, UnderscoreBased::class, 'hola_mundo'],
            'Underscore 2' => [false, UnderscoreBased::class, 'HELLO_WORLD'],
            'Underscore 3' => [true, UnderscoreBased::class, 'Ñ'],
            'Underscore 4' => [true, UnderscoreBased::class, 'HELLO'],
            'Uppercase 1'  => [false, UppercaseBased::class, ''],
            'Uppercase 2'  => [false, UppercaseBased::class, 'ñ'],
            'Uppercase 3'  => [false, UppercaseBased::class, 'one'],
            'Uppercase 4'  => [false, UppercaseBased::class, 'helloWorld'],
            'Dash 1'       => [false, DashBased::class, 'hello-World'],
            'Dash 2'       => [false, DashBased::class, 'my-name-is-bond'],
            'Space 1'      => [false, SpaceBased::class, 'Hola mundo'],
            'Space 2'      => [false, SpaceBased::class, 'Mi nombre es bond'],
            'Space 3'      => [false, SpaceBased::class, 'Formule courte spéciale été'],
        ];
    }

    /**
     * Test _converter methods_: _toCamel_, _toSnake_, ...
     *
     * @dataProvider converterMethodProvider()
     *
     * @covers       \Jawira\CaseConverter\Convert::toAda()
     * @covers       \Jawira\CaseConverter\Convert::toCamel()
     * @covers       \Jawira\CaseConverter\Convert::toCobol()
     * @covers       \Jawira\CaseConverter\Convert::toKebab()
     * @covers       \Jawira\CaseConverter\Convert::toLower()
     * @covers       \Jawira\CaseConverter\Convert::toMacro()
     * @covers       \Jawira\CaseConverter\Convert::toPascal()
     * @covers       \Jawira\CaseConverter\Convert::toSentence()
     * @covers       \Jawira\CaseConverter\Convert::toSnake()
     * @covers       \Jawira\CaseConverter\Convert::toTitle()
     * @covers       \Jawira\CaseConverter\Convert::toTrain()
     * @covers       \Jawira\CaseConverter\Convert::toUpper()
     *
     * @param string $methodName
     * @param string $className
     *
     */
    public function testConverterMethodCallsGlueString(string $methodName, string $className)
    {
        $expected = 'this is a dummy text';

        $namingConvention = $this->getMockBuilder($className)
                                 ->disableOriginalConstructor()
                                 ->setMethods(['glue'])
                                 ->getMock();

        $namingConvention->expects($this->once())
                         ->method('glue')
                         ->willReturn($expected);

        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['factory'])
                            ->getMock();

        $convertMock->expects($this->once())
                    ->method('factory')
                    ->willReturn($namingConvention);

        /** @var \Jawira\CaseConverter\NamingConvention $convertMock */
        $returned = $convertMock->$methodName();
        $this->assertSame($expected, $returned);
    }

    /**
     * Return and array with the name of all _converterMethods_.
     */
    public function converterMethodProvider()
    {
        return [
            'toAda'      => ['toAda', AdaCase::class],
            'toCamel'    => ['toCamel', CamelCase::class],
            'toCobol'    => ['toCobol', CobolCase::class],
            'toKebab'    => ['toKebab', KebabCase::class],
            'toLower'    => ['toLower', LowerCase::class],
            'toMacro'    => ['toMacro', MacroCase::class],
            'toPascal'   => ['toPascal', PascalCase::class],
            'toSentence' => ['toSentence', SentenceCase::class],
            'toSnake'    => ['toSnake', SnakeCase::class],
            'toTitle'    => ['toTitle', TitleCase::class],
            'toTrain'    => ['toTrain', TrainCase::class],
            'toUpper'    => ['toUpper', UpperCase::class],
        ];
    }

    /**
     * @covers \Jawira\CaseConverter\Convert::__toString()
     *
     * @throws \ReflectionException
     */
    public function testToString()
    {
        // Get mock, without the constructor being called
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->getMock();

        // set expectations for constructor calls
        $mock->expects($this->once())
             ->method('toCamel');

        // now call the magic function
        $reflectedClass  = new ReflectionClass(Convert::class);
        $reflectedMethod = $reflectedClass->getMethod('__toString');
        $reflectedMethod->invoke($mock);
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::extractWords()
     *
     * @param string $analyseReturn Expected value returned by analyse() method
     * @param string $splitMethod   Split method to be called
     *
     * @dataProvider extractWordsProvider()
     *
     * @throws \ReflectionException
     */
    public function testExtractWords(string $analyseReturn, string $splitMethod)
    {
        $inputString = 'deep-space-nine';

        // Disabling constructor and setting stub methods
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['analyse', $splitMethod])
                     ->getMock();

        // set expectations for analyse()
        $mock->expects($this->once())
             ->method('analyse')
             ->with($inputString)
             ->will($this->returnValue($analyseReturn));

        // set expectations for $splitMethod
        $mock->expects($this->once())
             ->method($splitMethod)
             ->with($inputString);

        // Making public a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod('extractWords');
        $method->setAccessible(true);

        // Testing
        $output = $method->invoke($mock, $inputString);
        $this->assertInstanceOf(Convert::class, $output);
    }

    public function extractWordsProvider()
    {
        return [
            'underscore' => [UnderscoreBased::class, 'splitUnderscoreString'],
            'dash'       => [DashBased::class, 'splitDashString'],
            'uppercase'  => [UppercaseBased::class, 'splitUppercaseString'],
            'space'      => [SpaceBased::class, 'splitSpaceString'],
        ];
    }

    /**
     * Tested methods should call Convert::splitString() method
     *
     * @covers       \Jawira\CaseConverter\Convert::splitDashString()
     * @covers       \Jawira\CaseConverter\Convert::splitUnderscoreString()
     * @covers       \Jawira\CaseConverter\Convert::splitSpaceString()
     *
     * @dataProvider splitStringCallProvider()
     *
     * @param string $splitMethod
     *
     * @throws \ReflectionException
     */
    public function testSplitStringCall(string $splitMethod)
    {
        $splitReturnValue = ['this', 'can', 'be', 'anything'];

        // Disabling constructor and setting stub method
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['splitString'])
                     ->getMock();

        // Making public a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod($splitMethod);
        $method->setAccessible(true);

        // Expectation
        $mock->expects($this->once())
             ->method('splitString')
             ->will($this->returnValue($splitReturnValue));

        // Testing
        $output = $method->invoke($mock, $splitMethod);
        $this->assertSame($splitReturnValue, $output);
    }

    public function splitStringCallProvider()
    {
        return [
            'splitDashString'       => ['splitDashString'],
            'splitUnderscoreString' => ['splitUnderscoreString'],
            'splitSpaceString'      => ['splitSpaceString'],
        ];
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::splitUppercaseString()
     * @dataProvider splitUppercaseStringProvider()
     *
     * @param string $input
     * @param string $parameter
     *
     * @throws \ReflectionException
     */
    public function testSplitUppercaseString(string $input, string $parameter)
    {
        // Disabling constructor and setting stub method
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['splitUnderscoreString'])
                     ->getMock();

        // Setting expectation for Stub method
        $mock->expects($this->once())
             ->method('splitUnderscoreString')
             ->with($parameter);

        // Making public a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod('splitUppercaseString');
        $method->setAccessible(true);

        // Testing
        $method->invoke($mock, $input);
    }

    public function splitUppercaseStringProvider()
    {
        return [
            ['HolaMundo', '_Hola_Mundo'],
            ['yes', 'yes'],
            ['airBus', 'air_Bus'],
        ];
    }

    /**
     * @see          http://beriba.pl/?p=262
     *
     * @param array $myArray
     * @param int   $expectedCount
     *
     * @throws \ReflectionException
     * @covers       Jawira\CaseConverter\Convert::count
     * @dataProvider countProvider()
     */
    public function testCount(array $myArray, int $expectedCount)
    {
        // Disabling constructor, keeping original methods
        /** @var Convert $mock */
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Setting value to protected property
        $reflectionObject   = new ReflectionObject($mock);
        $reflectionProperty = $reflectionObject->getProperty('words');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($mock, $myArray);

        $currentCount = $mock->count();

        $this->assertEquals($expectedCount, $currentCount);
    }

    public function countProvider()
    {
        return [
            'empty array'  => [[], 0],
            'small array'  => [['a'], 1],
            'medium array' => [['a', 'a', 'a', 'a',], 4],
            'large array'  => [['a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',], 12],
        ];
    }
}
