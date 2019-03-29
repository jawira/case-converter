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
        //
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['detectNamingConvention'])
                     ->getMock();

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
}
