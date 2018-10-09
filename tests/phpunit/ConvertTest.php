<?php

use Jawira\CaseConverter\Convert;
use PHPUnit\Framework\TestCase;

/**
 * Class ConvertTest
 *
 * @see https://jtreminio.com/blog/unit-testing-tutorial-part-i-introduction-to-phpunit/
 */
class ConvertTest extends TestCase
{

    /**
     * Testing constructor
     *
     * @covers \Jawira\CaseConverter\Convert::__construct()
     *
     */
    public function testContructor()
    {
        $mock = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['load'])
                     ->getMock();

        $mock->expects($this->once())
             ->method('load')
             ->with($this->equalTo('hello_world'));

        $class = new ReflectionObject($mock);
        $class->getConstructor()
              ->invoke($mock, 'hello_world');
    }

    /**
     * Tests if analyse() detects if string as "_" or not
     *
     * @covers       \Jawira\CaseConverter\Convert::analyse()
     * @dataProvider analyseProvider
     *
     * @param $input
     * @param $expected
     */
    public function testAnalyse($input, $expected)
    {
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        $reflection = new ReflectionObject($stub);
        $method     = $reflection->getMethod('analyse');
        $method->setAccessible(true);

        $output = $method->invoke($stub, $input);

        $this->assertSame($expected, $output);
    }

    /**
     * Provider method
     *
     * @return array
     */
    public function analyseProvider()
    {
        return [
            'Snake 1' => ['hola_mundo', Convert::SNAKE],
            'Snake 2' => ['HELLO_WORLD', Convert::SNAKE],
            'Camel 1' => ['', Convert::CAMEL],
            'Camel 2' => ['HELLO', Convert::CAMEL],
            'Camel 3' => ['one', Convert::CAMEL],
            'Camel 4' => ['helloWorld', Convert::CAMEL],
        ];
    }


    /**
     * @covers       \Jawira\CaseConverter\Convert::toSnake()
     *
     * @param array  $words     Words to transform to snake case
     * @param bool   $uppercase Get uppercase snake case
     * @param string $expected  Expected output
     *
     * @dataProvider toSnakeProvider
     */
    public function testToSnake($words, $uppercase, $expected)
    {
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        $reflection = new ReflectionObject($stub);
        $property   = $reflection->getProperty('words');
        $property->setAccessible(true);
        $property->setValue($stub, $words);

        /** @noinspection PhpUndefinedMethodInspection */
        $output = $stub->toSnake($uppercase);

        $this->assertSame($expected, $output);

    }

    /**
     * Provider for testToSnake
     */
    public function toSnakeProvider()
    {
        return [
            'One word lowercase'  => [['hello'], false, 'hello'],
            'One word uppercase'  => [['hello'], true, 'HELLO'],
            'Two words lowercase' => [['hello', 'world'], false, 'hello_world'],
            'Two words uppercase' => [['hello', 'world'], true, 'HELLO_WORLD'],
        ];
    }

    /**
     * @dataProvider toCamelProvider
     *
     * @covers       \Jawira\CaseConverter\Convert::toCamel()
     *
     * @param $words
     * @param $uppercase
     * @param $expected
     */
    public function testToCamel($words, $uppercase, $expected)
    {
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        $reflection = new ReflectionObject($stub);
        $property   = $reflection->getProperty('words');
        $property->setAccessible(true);
        $property->setValue($stub, $words);

        /** @noinspection PhpUndefinedMethodInspection */
        $output = $stub->toCamel($uppercase);

        $this->assertSame($expected, $output);
    }


    /**
     * Provider for testToSnake
     */
    public function toCamelProvider()
    {
        return [
            'One word lowercase'  => [['hello'], false, 'hello'],
            'One word uppercase'  => [['hello'], true, 'Hello'],
            'Two words lowercase' => [['hello', 'world'], false, 'helloWorld'],
            'Two words uppercase' => [['hello', 'world'], true, 'HelloWorld'],
        ];
    }

    /**
     * @dataProvider readSnakeProvider
     *
     * @covers       \Jawira\CaseConverter\Convert::readSnake()
     *
     * @param $snake
     * @param $expected
     */
    public function testReadSnake($snake, $expected)
    {
        // Disabling constructor
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods()
                     ->getMock();

        // making readSnake public
        $reflection = new ReflectionObject($stub);
        $method     = $reflection->getMethod('readSnake');
        $method->setAccessible(true);

        $output = $method->invoke($stub, $snake);

        // comparing arrays
        $this->assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function readSnakeProvider()
    {
        return [
            ['hello_world', ['hello', 'world']],
            ['hello', ['hello']],
            ['_hello_world_', ['hello', 'world']],
            ['__hello__world__', ['hello', 'world']],
            ['', []],
            ['_', []],
            ['__', []],
        ];
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::readCamel()
     *
     * @dataProvider readCamelProvider
     *
     * @param string $camel
     * @param string $expected
     * @param string $returnValue
     */
    public function testReadCamel($camel, $expected, $returnValue)
    {
        // Disabling constructor
        $stub = $this->getMockBuilder(Convert::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['readSnake'])
                     ->getMock();

        // Setting expectation
        $stub->expects($this->once())
             ->method('readSnake')
             ->with($this->equalTo($expected))
             ->willReturn($returnValue);

        // making readSnake public
        $reflection = new ReflectionObject($stub);
        $method     = $reflection->getMethod('readCamel');
        $method->setAccessible(true);

        // $output must be the same value returned by readSnake()
        $output = $method->invoke($stub, $camel);

        $this->assertSame($returnValue, $output);
    }

    public function readCamelProvider()
    {
        return [
            ['HelloWorld', '_Hello_World', 'dummy_value'],
            ['helloWorld', 'hello_World', 'dummy_value'],
        ];
    }


}
