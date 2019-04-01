<?php

use Jawira\CaseConverter\Convert;
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
                     ->setMethods(['detectNamingConvention'])
                     ->getMock();

        // Configuring stub
        $mock->expects($this->once())
             ->method('detectNamingConvention')
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
     * \Jawira\CaseConverter\Convert::analyse should return Convert::SNAKE if
     * $input contains '_'.
     *
     * @covers       \Jawira\CaseConverter\Convert::analyse()
     * @covers       \Jawira\CaseConverter\Convert::isUppercaseWord()
     * @dataProvider analyseProvider
     *
     * @param $input
     * @param $expected
     *
     * @throws \ReflectionException
     */
    public function testAnalyse($input, $expected)
    {
        // Disabling constructor without stub methods
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Removing protected for analyse method
        $reflection = new ReflectionObject($stub);
        $method     = $reflection->getMethod('analyse');
        $method->setAccessible(true);

        $output = $method->invoke($stub, $input);

        $this->assertSame($expected, $output);
    }

    public function analyseProvider()
    {
        return [
            'Dash 1'  => ['hola_mundo', Convert::STRATEGY_UNDERSCORE],
            'Dash 2'  => ['HELLO_WORLD', Convert::STRATEGY_UNDERSCORE],
            'Dash 3'  => ['HELLO', Convert::STRATEGY_UNDERSCORE],
            'Upper 1' => ['', Convert::STRATEGY_UPPERCASE],
            'Upper 3' => ['one', Convert::STRATEGY_UPPERCASE],
            'Upper 4' => ['helloWorld', Convert::STRATEGY_UPPERCASE],
            'dash 1'  => ['hello-World', Convert::STRATEGY_DASH],
        ];
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::splitString()
     *
     * @dataProvider splitStringProvider
     *
     * @param string $pattern
     * @param string $input
     * @param array  $expected
     *
     * @throws \ReflectionException
     */
    public function testSplitString(string $pattern, string $input, array $expected)
    {
        // Disabling constructor without stub methods
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Making public a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod('splitString');
        $method->setAccessible(true);

        // Testing method
        $output = $method->invoke($mock, $pattern, $input);
        $this->assertSame($expected, $output);
    }

    public function splitStringProvider()
    {
        return [
            [Convert::DASH, 'hello-world', ['hello', 'world']],
            [Convert::DASH, 'HeLlO-WoRlD', ['HeLlO', 'WoRlD']],
            [Convert::DASH, 'Hello-World', ['Hello', 'World']],
            [Convert::DASH, 'HELLO-WORLD', ['HELLO', 'WORLD']],
            [Convert::DASH, '--hello--world--', ['hello', 'world']],
            [Convert::UNDERSCORE, 'hello_world', ['hello', 'world']],
            [Convert::UNDERSCORE, 'HeLlO_WoRlD', ['HeLlO', 'WoRlD']],
            [Convert::UNDERSCORE, 'Hello_World', ['Hello', 'World']],
            [Convert::UNDERSCORE, 'HELLO_WORLD', ['HELLO', 'WORLD']],
            [Convert::UNDERSCORE, '__hello_____world__', ['hello', 'world']],
        ];
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::glueString()
     * @dataProvider glueStringProvider
     *
     * @param array  $words
     * @param string $glue
     * @param int    $mode
     * @param bool   $lcf
     *
     * @throws \ReflectionException
     */
    public function testGlueString(array $words, string $glue, int $mode, bool $lcf, string $expected)
    {
        // Disabling constructor without stub methods
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // Making "words" property accessible and setting a value
        $reflection = new ReflectionObject($mock);
        $property   = $reflection->getProperty('words');
        $property->setAccessible(true);
        $property->setValue($mock, $words);

        // Making public a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod('glueString');
        $method->setAccessible(true);

        // Testing
        $output = $method->invoke($mock, $glue, $mode, $lcf);
        $this->assertSame($expected, $output);
    }

    public function glueStringProvider()
    {
        return [
            [['foo', 'bar'], Convert::DASH, \MB_CASE_LOWER, false, 'foo-bar'],
            [['foo', 'bar'], Convert::DASH, \MB_CASE_TITLE, false, 'Foo-Bar'],
            [['foo', 'bar'], Convert::DASH, \MB_CASE_UPPER, false, 'FOO-BAR'],
            [['foo', 'bar'], Convert::UNDERSCORE, \MB_CASE_LOWER, false, 'foo_bar'],
            [['foo', 'bar'], Convert::UNDERSCORE, \MB_CASE_TITLE, false, 'Foo_Bar'],
            [['foo', 'bar'], Convert::UNDERSCORE, \MB_CASE_UPPER, false, 'FOO_BAR'],
            [['foo', 'bar'], Convert::EMPTY_STRING, \MB_CASE_LOWER, false, 'foobar'],
            [['foo', 'bar'], Convert::EMPTY_STRING, \MB_CASE_TITLE, false, 'FooBar'],
            [['foo', 'bar'], Convert::EMPTY_STRING, \MB_CASE_UPPER, false, 'FOOBAR'],
            [['foo', 'bar'], '§', \MB_CASE_LOWER, false, 'foo§bar'],
            [['foo', 'bar'], '§', \MB_CASE_TITLE, false, 'Foo§Bar'],
            [['foo', 'bar'], '§', \MB_CASE_UPPER, false, 'FOO§BAR'],
            [['foo', 'bar'], Convert::DASH, \MB_CASE_LOWER, true, 'foo-bar'],
            [['foo', 'bar'], Convert::DASH, \MB_CASE_TITLE, true, 'foo-Bar'],
            [['foo', 'bar'], Convert::DASH, \MB_CASE_UPPER, true, 'foo-BAR'],
            [['foo', 'bar'], Convert::UNDERSCORE, \MB_CASE_LOWER, true, 'foo_bar'],
            [['foo', 'bar'], Convert::UNDERSCORE, \MB_CASE_TITLE, true, 'foo_Bar'],
            [['foo', 'bar'], Convert::UNDERSCORE, \MB_CASE_UPPER, true, 'foo_BAR'],
            [['foo', 'bar'], Convert::EMPTY_STRING, \MB_CASE_LOWER, true, 'foobar'],
            [['foo', 'bar'], Convert::EMPTY_STRING, \MB_CASE_TITLE, true, 'fooBar'],
            [['foo', 'bar'], Convert::EMPTY_STRING, \MB_CASE_UPPER, true, 'fooBAR'],
            [['foo', 'bar'], '§', \MB_CASE_LOWER, true, 'foo§bar'],
            [['foo', 'bar'], '§', \MB_CASE_TITLE, true, 'foo§Bar'],
            [['foo', 'bar'], '§', \MB_CASE_UPPER, true, 'foo§BAR'],
        ];
    }

    /**
     * Test _converter methods_: _toCamel_, _toSnake_, ...
     *
     * @dataProvider converterMethodProvider()
     *
     * @covers       \Jawira\CaseConverter\Convert::toCamel()
     * @covers       \Jawira\CaseConverter\Convert::toAda()
     * @covers       \Jawira\CaseConverter\Convert::toCobol()
     * @covers       \Jawira\CaseConverter\Convert::toKebab()
     * @covers       \Jawira\CaseConverter\Convert::toMacro()
     * @covers       \Jawira\CaseConverter\Convert::toPascal()
     * @covers       \Jawira\CaseConverter\Convert::toSnake()
     * @covers       \Jawira\CaseConverter\Convert::toTrain()
     *
     * @throws \ReflectionException
     */
    public function testConverterMethodCallsGlueString($converterMethod)
    {
        // Disabling constructor without stub methods
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['glueString'])
                     ->getMock();

        // Stub called once and returns value
        $mock->expects($this->once())
             ->method('glueString');

        // Removing protected for converter method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod($converterMethod);
        $method->setAccessible(true);

        $method->invoke($mock);
    }

    /**
     * Return and array with the name of all _converterMethods_.
     */
    public function converterMethodProvider()
    {
        return [
            'toAda'      => ['toAda'],
            'toCamel'    => ['toCamel'],
            'toCobol'    => ['toCobol'],
            'toKebab'    => ['toKebab'],
            'toMacro'    => ['toMacro'],
            'toPascal'   => ['toPascal'],
            'toSnake'    => ['toSnake'],
            'toTrain'    => ['toTrain'],
        ];
    }

}
