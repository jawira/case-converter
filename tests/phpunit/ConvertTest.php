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
                     ->setMethods(['fromAuto'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('fromAuto');

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
     * This test do not force the use of _Simple Case-Mapping_ .
     *
     * @dataProvider handleGluerMethodProvider()
     *
     * @covers       \Jawira\CaseConverter\Convert::handleGluerMethod
     *
     * @param string $methodName
     * @param string $className
     *
     * @throws \ReflectionException
     */
    public function testHandleGluerMethod(string $methodName, string $className)
    {
        // Gluer class
        $gluerMock = $this->getMockBuilder($className)
                          ->disableOriginalConstructor()
                          ->setMethods(['glue'])
                          ->getMock();
        $gluerMock->expects($this->once())
                  ->method('glue')
                  ->willReturn('this is a dummy text');

        // Convert class
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['createGluer'])
                            ->getMock();
        $convertMock->expects($this->once())
                    ->method('createGluer')
                    ->with($className, ['dummy', 'd455b'], false)
                    ->willReturn($gluerMock);

        // Setting detected words
        $reflectionObject = new ReflectionObject($convertMock);
        $wordsProperty    = $reflectionObject->getProperty('words');
        $wordsProperty->setAccessible(true);
        $wordsProperty->setValue($convertMock, ['dummy', 'd455b']);
        // Setting _Simple Case-Mapping_ as false
        $forceProperty = $reflectionObject->getProperty('forceSimpleCaseMapping');
        $forceProperty->setAccessible(true);
        $forceProperty->setValue($convertMock, false);

        // Invoking protected method
        $method = new ReflectionMethod($convertMock, 'handleGluerMethod');
        $method->setAccessible(true);
        $result = $method->invokeArgs($convertMock, [$methodName]);

        $this->assertSame('this is a dummy text', $result);
    }

    /**
     * Return and array with the name of all _converter methods_.
     */
    public function handleGluerMethodProvider()
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
     * @covers       Jawira\CaseConverter\Convert::extractWords
     * @dataProvider extractWordsProviders
     *
     * @param $splitterClass
     *
     * @throws \ReflectionException
     */
    public function testExtractWords($splitterClass)
    {
        // Preparing Splitter object
        $splitterMock = $this->getMockBuilder($splitterClass)
                             ->disableOriginalConstructor()
                             ->setMethods(['split'])
                             ->getMock();

        $splitterMock->expects($this->once())
                     ->method('split')
                     ->with()
                     ->willReturn(['dummy', 'array', '8d84d']);

        // Preparing Convert object
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods([])
                            ->getMock();

        // Calling protected method
        $reflection = new ReflectionObject($convertMock);
        $method     = $reflection->getMethod('extractWords');
        $method->setAccessible(true);
        $result = $method->invoke($convertMock, $splitterMock);

        $this->assertAttributeEquals(['dummy', 'array', '8d84d'], 'words', $convertMock);
        $this->assertInstanceOf(Convert::class, $result);
    }

    /**
     * Returns all valid splitters that can be used by Convert::extractWords()
     *
     * @return array
     */
    public function extractWordsProviders()
    {
        return [
            [SpaceSplitter::class],
            [DashSplitter::class],
            [UnderscoreSplitter::class],
            [UppercaseSplitter::class],
        ];
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
     * @covers       \Jawira\CaseConverter\Convert::createGluer
     * @covers       \Jawira\CaseConverter\Glue\Gluer::__construct
     * @dataProvider createGluerProvider
     *
     * @param string $className
     *
     * @throws \ReflectionException
     */
    public function testCreateGluerProvider(string $className)
    {
        // Preparing Convert mock
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Calling protected method
        $reflectionObject = new ReflectionObject($mock);
        $reflectionMethod = $reflectionObject->getMethod('createGluer');
        $reflectionMethod->setAccessible(true);
        $gluerObject = $reflectionMethod->invoke($mock, $className, ['dummy', 'array'], false);

        $this->assertInstanceOf(Gluer::class, $gluerObject);
    }

    public function createGluerProvider()
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

    /**
     * @covers \Jawira\CaseConverter\Convert::getSource
     * @throws \ReflectionException
     */
    public function testGetSource()
    {
        // Preparing Convert object
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods()
                            ->getMock();

        // Setting detected words
        $reflectionObject = new ReflectionObject($convertMock);
        $sourceProperty   = $reflectionObject->getProperty('source');
        $sourceProperty->setAccessible(true);
        $sourceProperty->setValue($convertMock, 'this is source string');

        /** @var Convert $convertMock */
        $result = $convertMock->getSource();
        $this->assertSame('this is source string', $result);
    }

    /**
     * @covers \Jawira\CaseConverter\Convert::forceSimpleCaseMapping
     */
    public function testForceSimpleCaseMapping()
    {
        // Preparing Convert object
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods()
                            ->getMock();

        /** @var Convert $convertMock */
        $result = $convertMock->forceSimpleCaseMapping();

        $this->assertInstanceOf(Convert::class, $result);
        $this->assertAttributeEquals(true, 'forceSimpleCaseMapping', $convertMock);
    }
}
