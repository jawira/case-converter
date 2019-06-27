<?php

use Jawira\CaseConverter\Convert;
use Jawira\CaseConverter\Glue\AdaCase;
use Jawira\CaseConverter\Glue\CamelCase;
use Jawira\CaseConverter\Glue\CobolCase;
use Jawira\CaseConverter\Glue\Gluer;
use Jawira\CaseConverter\Glue\KebabCase;
use Jawira\CaseConverter\Glue\LowerCase;
use Jawira\CaseConverter\Glue\MacroCase;
use Jawira\CaseConverter\Glue\PascalCase;
use Jawira\CaseConverter\Glue\SentenceCase;
use Jawira\CaseConverter\Glue\SnakeCase;
use Jawira\CaseConverter\Glue\TitleCase;
use Jawira\CaseConverter\Glue\TrainCase;
use Jawira\CaseConverter\Glue\UpperCase;
use Jawira\CaseConverter\Split\DashSplitter;
use Jawira\CaseConverter\Split\SpaceSplitter;
use Jawira\CaseConverter\Split\UnderscoreSplitter;
use Jawira\CaseConverter\Split\UppercaseSplitter;
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
     * @covers       \Jawira\CaseConverter\Convert::analyse
     * @covers       \Jawira\CaseConverter\Split\Splitter::__construct
     *
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
        $this->assertInstanceOf($expected, $output);
    }

    public function analyseProvider()
    {
        return [
            'Underscore 1' => [false, UnderscoreSplitter::class, 'hola_mundo'],
            'Underscore 2' => [false, UnderscoreSplitter::class, 'HELLO_WORLD'],
            'Underscore 3' => [true, UnderscoreSplitter::class, 'Ñ'],
            'Underscore 4' => [true, UnderscoreSplitter::class, 'HELLO'],
            'Uppercase 1'  => [false, UppercaseSplitter::class, ''],
            'Uppercase 2'  => [false, UppercaseSplitter::class, 'ñ'],
            'Uppercase 3'  => [false, UppercaseSplitter::class, 'one'],
            'Uppercase 4'  => [false, UppercaseSplitter::class, 'helloWorld'],
            'Dash 1'       => [false, DashSplitter::class, 'hello-World'],
            'Dash 2'       => [false, DashSplitter::class, 'my-name-is-bond'],
            'Space 1'      => [false, SpaceSplitter::class, 'Hola mundo'],
            'Space 2'      => [false, SpaceSplitter::class, 'Mi nombre es bond'],
            'Space 3'      => [false, SpaceSplitter::class, 'Formule courte spéciale été'],
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

        /** @var \Jawira\CaseConverter\Glue\Gluer $convertMock */
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

    /**
     * @covers Jawira\CaseConverter\Convert::extractWords
     *
     * @throws \ReflectionException
     */
    public function testExtractWords()
    {
        // Preparing Splitter object
        $splitterMock = $this->getMockBuilder(DashSplitter::class)
                             ->disableOriginalConstructor()
                             ->setMethods(['split'])
                             ->getMock();

        $splitterMock->expects($this->once())
                     ->method('split')
                     ->with()
                     ->willReturn(['dummy', 'array']);

        // Preparing Convert object
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['analyse'])
                            ->getMock();

        $convertMock->expects($this->once())
                    ->method('analyse')
                    ->with('dummy-value')
                    ->will($this->returnValue($splitterMock));

        // Calling protected method
        $reflection = new ReflectionObject($convertMock);
        $method     = $reflection->getMethod('extractWords');
        $method->setAccessible(true);
        $result = $method->invoke($convertMock, 'dummy-value');

        $this->assertAttributeEquals(['dummy', 'array'], 'words', $convertMock);
        $this->assertInstanceOf(Convert::class, $result);
    }

    /**
     * @covers \Jawira\CaseConverter\Convert::toArray
     *
     * @throws \ReflectionException
     */
    public function testToArray()
    {
        // Preparing Convert mock
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Setting value to protected property
        $reflectionObject   = new ReflectionObject($mock);
        $reflectionProperty = $reflectionObject->getProperty('words');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($mock, ['dummy', 'array']);

        /** @var \Jawira\CaseConverter\Convert $mock */
        $currentArray = $mock->toArray();

        $this->assertIsArray($currentArray);
        $this->assertEquals(['dummy', 'array'], $currentArray);
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::factory
     * @covers       \Jawira\CaseConverter\Glue\Gluer::__construct
     * @dataProvider factoryProvider
     *
     * @param string $className
     *
     * @throws \ReflectionException
     */
    public function testFactory(string $className)
    {
        // Preparing Convert mock
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Setting value to protected property
        $reflectionObject   = new ReflectionObject($mock);
        $reflectionProperty = $reflectionObject->getProperty('words');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($mock, ['dummy', 'array']);

        // Calling protected method
        $reflectionMethod = $reflectionObject->getMethod('factory');
        $reflectionMethod->setAccessible(true);
        $result = $reflectionMethod->invoke($mock, $className);

        $this->assertInstanceOf(Gluer::class, $result);
    }

    public function factoryProvider()
    {
        return [
            [AdaCase::class],
            [CamelCase::class],
            [CobolCase::class],
            [KebabCase::class],
            [LowerCase::class],
            [MacroCase::class],
            [PascalCase::class],
            [SentenceCase::class],
            [SnakeCase::class],
            [TitleCase::class],
            [TrainCase::class],
            [UpperCase::class],
        ];
    }
}
