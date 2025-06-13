<?php

use Jawira\CaseConverter\CaseConverterException;
use Jawira\CaseConverter\Convert;
use Jawira\CaseConverter\Glue\AdaCase;
use Jawira\CaseConverter\Glue\CamelCase;
use Jawira\CaseConverter\Glue\CobolCase;
use Jawira\CaseConverter\Glue\DotNotation;
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
use Jawira\CaseConverter\Split\DotSplitter;
use Jawira\CaseConverter\Split\SpaceSplitter;
use Jawira\CaseConverter\Split\Splitter;
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
     * @covers       \Jawira\CaseConverter\Convert::isUppercaseWord()
     *
     * @param string $inputString
     * @param bool   $expectedResult
     *
     * @dataProvider isUppercaseWordProvider
     *
     * @throws \ReflectionException
     */
    public function testIsUppercaseWord(string $inputString, bool $digitsAreLowercase, bool $expectedResult)
    {
        // Disabling constructor without stub methods
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Removing protected for analyze method
        $reflection = new ReflectionObject($stub);
        $method     = $reflection->getMethod('isUppercaseWord');
        $method->setAccessible(true);

        $output = $method->invoke($stub, $inputString, $digitsAreLowercase);

        $this->assertSame($expectedResult, $output);
    }

    public function isUppercaseWordProvider()
    {
        return [
            ['X', true, true],
            ['YES', true, true],
            ['HELLO', true, true],
            ['', true, false],
            ['x', true, false],
            ['HELLOxWORLD', true, false],
            ['HELLO-WORLD', true, false],
            ['HELLO_WORLD', true, false],
            ['HelloWorld', true, false],
            ['CPU486', true, false],
            ['CPU486', false, true],
            ['IR35', true, false],
            ['IR35', false, true],
            ['ISO8601', true, false],
            ['ISO8601', false, true],
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
     * @param bool   $isUppercaseWordReturn Return value for `isUppercaseWord()`
     * @param string $expected              Expected result
     * @param string $inputString           Input string
     *
     * @throws \ReflectionException
     */
    public function testAnalyse(bool $isUppercaseWordReturn, string $expected, string $inputString)
    {
        // Disabling constructor with one stub method
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['isUppercaseWord'])
                     ->getMock();

        // Configuring expectation
        $stub->expects($this->any())
             ->method('isUppercaseWord')
             ->withAnyParameters()
             ->willReturn($isUppercaseWordReturn);

        // Removing protected for analyze method
        $reflection = new ReflectionObject($stub);
        $method     = $reflection->getMethod('analyse');
        $method->setAccessible(true);

        // Testing
        $output = $method->invoke($stub, $inputString, true);
        $this->assertInstanceOf($expected, $output);
    }

    public function analyseProvider()
    {
        return [
            'Underscore 1' => [false, UnderscoreSplitter::class, 'hola_mundo'],
            'Underscore 2' => [false, UnderscoreSplitter::class, 'HELLO_WORLD'],
            'Underscore 3' => [true, UnderscoreSplitter::class, 'Ñ'],
            'Underscore 4' => [true, UnderscoreSplitter::class, 'HELLO'],
            'Underscore 5' => [false, UnderscoreSplitter::class, '_'],
            'Underscore 6' => [false, UnderscoreSplitter::class, '_____'],
            'Uppercase 1'  => [false, UppercaseSplitter::class, ''],
            'Uppercase 2'  => [false, UppercaseSplitter::class, 'ñ'],
            'Uppercase 3'  => [false, UppercaseSplitter::class, 'one'],
            'Uppercase 4'  => [false, UppercaseSplitter::class, 'helloWorld'],
            'Dash 1'       => [false, DashSplitter::class, 'hello-World'],
            'Dash 2'       => [false, DashSplitter::class, 'my-name-is-bond'],
            'Dash 3'       => [false, DashSplitter::class, '-my-name-is-bond-'],
            'Dash 4'       => [false, DashSplitter::class, '-'],
            'Dash 5'       => [false, DashSplitter::class, '------'],
            'Space 1'      => [false, SpaceSplitter::class, 'Hola mundo'],
            'Space 2'      => [false, SpaceSplitter::class, 'Mi nombre es bond'],
            'Space 3'      => [false, SpaceSplitter::class, 'Formule courte spéciale été'],
            'Space 4'      => [false, SpaceSplitter::class, ' '],
            'Space 5'      => [false, SpaceSplitter::class, '      '],
            'Dot 1'        => [false, DotSplitter::class, 'one.two'],
            'Dot 2'        => [false, DotSplitter::class, '.hello.'],
            'Dot 3'        => [false, DotSplitter::class, '.'],
            'Dot 4'        => [false, DotSplitter::class, '........'],
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
     * Test _converter methods_: _toCamel_, _toSnake_, ...
     *
     * This test do not force the use of _Simple Case-Mapping_ .
     *
     * @covers       \Jawira\CaseConverter\Convert::handleGluerMethod
     *
     * @throws \ReflectionException
     */
    public function testHandleGluerMethodWithException()
    {
        // Preparing exception
        $this->expectException(CaseConverterException::class);
        $this->expectExceptionMessage('Unknown method: myDummyMethod');

        // Convert class
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods()
                            ->getMock();

        // Invoking protected method
        $method = new ReflectionMethod($convertMock, 'handleGluerMethod');
        $method->setAccessible(true);
        $method->invokeArgs($convertMock, ['myDummyMethod']);
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
            'toDot'      => ['toDot', DotNotation::class],
        ];
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
    public function testCreateGluer(string $className)
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
     * @throws \ReflectionException
     * @covers \Jawira\CaseConverter\Convert::fromAuto
     */
    public function testFromAuto()
    {
        // Preparing Convert object
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['analyse', 'extractWords'])
                            ->getMock();

        $strategyMock = $this->getMockBuilder(Splitter::class)
                             ->disableOriginalConstructor()
                             ->getMockForAbstractClass();

        // set 'source' attribute
        $reflectionObject = new ReflectionObject($convertMock);
        $wordsProperty    = $reflectionObject->getProperty('source');
        $wordsProperty->setAccessible(true);
        $wordsProperty->setValue($convertMock, 'dummy-original-string');

        // stub analyse
        $convertMock->expects($this->once())
                    ->method('analyse')
                    ->with('dummy-original-string')
                    ->willReturn($strategyMock);

        // stub extractWords
        $convertMock->expects($this->once())
                    ->method('extractWords')
                    ->with($strategyMock)
                    ->willReturnSelf();

        // Calling protected method
        $reflectionObject = new ReflectionObject($convertMock);
        $reflectionMethod = $reflectionObject->getMethod('fromAuto');
        $reflectionMethod->setAccessible(true);
        $result = $reflectionMethod->invoke($convertMock, 'fromAuto');

        $this->assertInstanceOf(Convert::class, $result);
        $this->assertSame($convertMock, $result);
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::handleSplitterMethod
     *
     * @param string $methodName
     * @param string $splitterName
     *
     * @dataProvider handleSplitterMethodProvider
     *
     * @throws \ReflectionException
     */
    public function testHandleSplitterMethod(string $methodName = 'fromKebab', string $splitterName = DashSplitter::class, string $sourceString = 'dummy-azer12')
    {
        // Splitter class
        $splitterMock = $this->getMockBuilder($splitterName)
                             ->disableOriginalConstructor()
                             ->getMock();

        // Convert class
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['createSplitter', 'extractWords'])
                            ->getMock();
        $convertMock->expects($this->once())
                    ->method('createSplitter')
                    ->with($splitterName, $sourceString)
                    ->willReturn($splitterMock);
        $convertMock->expects($this->once())
                    ->method('extractWords')
                    ->with($splitterMock);

        // Add source attribute
        $reflectionObject = new ReflectionObject($convertMock);
        $wordsProperty    = $reflectionObject->getProperty('source');
        $wordsProperty->setAccessible(true);
        $wordsProperty->setValue($convertMock, $sourceString);

        // Invoking protected method
        $method = new ReflectionMethod($convertMock, 'handleSplitterMethod');
        $method->setAccessible(true);
        $result = $method->invoke($convertMock, $methodName);

        $this->assertSame($convertMock, $result);
    }

    public function handleSplitterMethodProvider()
    {
        return [
            ['fromCamel', UppercaseSplitter::class],
            ['fromPascal', UppercaseSplitter::class],
            ['fromSnake', UnderscoreSplitter::class],
            ['fromAda', UnderscoreSplitter::class],
            ['fromMacro', UnderscoreSplitter::class],
            ['fromKebab', DashSplitter::class],
            ['fromTrain', DashSplitter::class],
            ['fromCobol', DashSplitter::class],
            ['fromLower', SpaceSplitter::class],
            ['fromUpper', SpaceSplitter::class],
            ['fromTitle', SpaceSplitter::class],
            ['fromSentence', SpaceSplitter::class],
            ['fromDot', DotSplitter::class],
        ];
    }

    /**
     * @covers \Jawira\CaseConverter\Convert::handleSplitterMethod
     *
     * @throws \ReflectionException
     */
    public function testHandleSplitterMethodWithException()
    {
        // Preparing exception
        $this->expectException(CaseConverterException::class);
        $this->expectExceptionMessage('Unknown method: myDummyMethod');

        // Convert class
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods()
                            ->getMock();

        // Invoking protected method
        $method = new ReflectionMethod($convertMock, 'handleSplitterMethod');
        $method->setAccessible(true);
        $method->invokeArgs($convertMock, ['myDummyMethod']);
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::createSplitter
     * @covers       \Jawira\CaseConverter\Split\Splitter::__construct
     *
     * @dataProvider createSplitterProvider
     *
     * @param string $className
     *
     * @throws \ReflectionException
     */
    public function testCreateSplitter(string $className)
    {
        // Preparing Convert mock
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Calling protected method
        $reflectionObject = new ReflectionObject($mock);
        $reflectionMethod = $reflectionObject->getMethod('createSplitter');
        $reflectionMethod->setAccessible(true);
        $splitterObject = $reflectionMethod->invoke($mock, $className, 'dummy-string', false);

        $this->assertInstanceOf($className, $splitterObject);
    }

    public function createSplitterProvider()
    {
        return [
            [DashSplitter::class, 'dummy-string'],
            [SpaceSplitter::class, 'dummy-string'],
            [UnderscoreSplitter::class, 'dummy-string'],
            [UppercaseSplitter::class, 'dummy-string'],
        ];
    }

    /**
     * Testing magic function call
     *
     * @covers       \Jawira\CaseConverter\Convert::__call
     * @dataProvider callProvider
     *
     * @param string $methodName
     * @param array  $arguments
     * @param int    $splitterCount
     * @param int    $gluerCount
     * @param mixed  $handlerResult
     */
    public function testCall(string $methodName, $arguments, int $splitterCount, int $gluerCount, string $handlerResult = '')
    {
        // Preparing Convert mock
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods(['handleSplitterMethod', 'handleGluerMethod'])
                            ->getMock();

        $convertMock->expects($this->exactly($splitterCount))
                    ->method('handleSplitterMethod')
                    ->with($methodName)
                    ->willReturnSelf();

        $convertMock->expects($this->exactly($gluerCount))
                    ->method('handleGluerMethod')
                    ->with($methodName)
                    ->willReturn($handlerResult);

        /** @var string|\Jawira\CaseConverter\Split\Splitter $result */
        $result = $convertMock->__call($methodName, $arguments);

        if ($splitterCount) {
            $this->assertInstanceOf(Convert::class, $result);
        }
        if ($gluerCount) {
            $this->assertSame($handlerResult, $result);
        }
    }

    public function callProvider()
    {
        return [
            ['toDummy', [], 0, 1, '46d54fd5'],
            ['toAda', [], 0, 1, 'ed65f'],
            ['toCamel', [], 0, 1, '65hg4jk45'],
            ['toCobol', [], 0, 1, 'a1g94a1'],
            ['toKebab', [], 0, 1, 'd4g2q1df'],
            ['toLower', [], 0, 1, 'ff4f1f'],
            ['toMacro', [], 0, 1, 'fe64df'],
            ['toPascal', [], 0, 1, 'ff1f1f1f'],
            ['toSentence', [], 0, 1, 'de9e1d'],
            ['toSnake', [], 0, 1, 'fdq1nh1jl'],
            ['toTitle', [], 0, 1, 'hjy94'],
            ['toTrain', [], 0, 1, 'g4i4ol'],
            ['toUpper', [], 0, 1, 'gu1ioo1'],
            ['fromDummy', [], 1, 0],
            ['fromAda', [], 1, 0],
            ['fromCamel', [], 1, 0],
            ['fromCobol', [], 1, 0],
            ['fromKebab', [], 1, 0],
            ['fromLower', [], 1, 0],
            ['fromMacro', [], 1, 0],
            ['fromPascal', [], 1, 0],
            ['fromSentence', [], 1, 0],
            ['fromSnake', [], 1, 0],
            ['fromTitle', [], 1, 0],
            ['fromTrain', [], 1, 0],
            ['fromUpper', [], 1, 0],
        ];
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::__call
     */
    public function testCallException()
    {
        $this->expectException(Jawira\CaseConverter\CaseConverterException::class);
        $this->expectExceptionMessage('Unknown method: invalidMethod');

        // Preparing Convert mock
        $convertMock = $this->getMockBuilder(Convert::class)
                            ->disableOriginalConstructor()
                            ->setMethods()
                            ->getMock();

        /** @var string|\Jawira\CaseConverter\Split\Splitter $result */
        $convertMock->__call('invalidMethod', []);
    }
}
