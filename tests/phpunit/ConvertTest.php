<?php

use Jawira\CaseConverter\Convert;
use PHPUnit\Framework\TestCase;

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
                     ->setMethods([])
                     ->getMock();

        $reflection = new ReflectionObject($stub);
        $method     = $reflection->getMethod('analyse');
        $method->setAccessible(true);

        $output = $method->invoke($stub, $input);

        $this->assertSame($output, $expected);
    }

    /**
     * Provider method
     *
     * @return array
     */
    public function analyseProvider()
    {
        return [
            ['hola_mundo', Convert::SNAKE],
            ['HELLO_WORLD', Convert::SNAKE],
            ['', Convert::CAMEL],
            ['HELLO', Convert::CAMEL],
            ['one', Convert::CAMEL],
            ['helloWorld', Convert::CAMEL],
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

        $this->assertSame($output, $expected);

    }

    /**
     * Provider for testToSnake
     */
    public function toSnakeProvider()
    {
        return [
            [['hello'], false, 'hello'],
            [['hello'], true, 'HELLO'],
            [['hello', 'world'], false, 'hello_world'],
            [['hello', 'world'], true, 'HELLO_WORLD'],
        ];
    }

}
