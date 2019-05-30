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
        // Disabling constructor without stub methods
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
            'Underscore 1' => [false, Convert::STRATEGY_UNDERSCORE, 'hola_mundo'],
            'Underscore 2' => [false, Convert::STRATEGY_UNDERSCORE, 'HELLO_WORLD'],
            'Underscore 3' => [true, Convert::STRATEGY_UNDERSCORE, 'Ñ'],
            'Underscore 4' => [true, Convert::STRATEGY_UNDERSCORE, 'HELLO'],
            'Uppercase 1'  => [false, Convert::STRATEGY_UPPERCASE, ''],
            'Uppercase 2'  => [false, Convert::STRATEGY_UPPERCASE, 'ñ'],
            'Uppercase 3'  => [false, Convert::STRATEGY_UPPERCASE, 'one'],
            'Uppercase 4'  => [false, Convert::STRATEGY_UPPERCASE, 'helloWorld'],
            'Dash 1'       => [false, Convert::STRATEGY_DASH, 'hello-World'],
            'Dash 2'       => [false, Convert::STRATEGY_DASH, 'my-name-is-bond'],
            'Space 1'      => [false, Convert::STRATEGY_SPACE, 'Hola mundo'],
            'Space 2'      => [false, Convert::STRATEGY_SPACE, 'Mi nombre es bond'],
            'Space 3'      => [false, Convert::STRATEGY_SPACE, 'Formule courte spéciale été'],
        ];
    }

    /**
     * @covers       \Jawira\CaseConverter\Convert::splitString()
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
            [Convert::SPACE, 'hEllO wOrlD', ['hEllO', 'wOrlD']],
            [Convert::SPACE, 'hEllO wOrlD', ['hEllO', 'wOrlD']],
            [Convert::SPACE, 'hEllO      wOrlD', ['hEllO', 'wOrlD']],
            [Convert::SPACE, '           hEllO      wOrlD', ['hEllO', 'wOrlD']],
            [Convert::SPACE, '           hEllO      wOrlD   ', ['hEllO', 'wOrlD']],
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
     * @param string $expected
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

    /**
     * @return array
     */
    public function glueStringProvider()
    {
        return [
            [['foo', 'bar'], Convert::DASH, MB_CASE_LOWER, false, 'foo-bar'],
            [['foo', 'bar'], Convert::DASH, MB_CASE_TITLE, false, 'Foo-Bar'],
            [['foo', 'bar'], Convert::DASH, MB_CASE_UPPER, false, 'FOO-BAR'],
            [['foo', 'bar'], Convert::UNDERSCORE, MB_CASE_LOWER, false, 'foo_bar'],
            [['foo', 'bar'], Convert::UNDERSCORE, MB_CASE_TITLE, false, 'Foo_Bar'],
            [['foo', 'bar'], Convert::UNDERSCORE, MB_CASE_UPPER, false, 'FOO_BAR'],
            [['foo', 'bar'], Convert::EMPTY_STRING, MB_CASE_LOWER, false, 'foobar'],
            [['foo', 'bar'], Convert::EMPTY_STRING, MB_CASE_TITLE, false, 'FooBar'],
            [['foo', 'bar'], Convert::EMPTY_STRING, MB_CASE_UPPER, false, 'FOOBAR'],
            [['foo', 'bar'], Convert::SPACE, MB_CASE_LOWER, false, 'foo bar'],
            [['foo', 'bar'], Convert::SPACE, MB_CASE_TITLE, false, 'Foo Bar'],
            [['foo', 'bar'], Convert::SPACE, MB_CASE_UPPER, false, 'FOO BAR'],
            [['foo', 'bar'], '§', MB_CASE_LOWER, false, 'foo§bar'],
            [['foo', 'bar'], '§', MB_CASE_TITLE, false, 'Foo§Bar'],
            [['foo', 'bar'], '§', MB_CASE_UPPER, false, 'FOO§BAR'],
            [['foo', 'bar'], Convert::DASH, MB_CASE_LOWER, true, 'foo-bar'],
            [['foo', 'bar'], Convert::DASH, MB_CASE_TITLE, true, 'foo-Bar'],
            [['foo', 'bar'], Convert::DASH, MB_CASE_UPPER, true, 'foo-BAR'],
            [['foo', 'bar'], Convert::UNDERSCORE, MB_CASE_LOWER, true, 'foo_bar'],
            [['foo', 'bar'], Convert::UNDERSCORE, MB_CASE_TITLE, true, 'foo_Bar'],
            [['foo', 'bar'], Convert::UNDERSCORE, MB_CASE_UPPER, true, 'foo_BAR'],
            [['foo', 'bar'], Convert::EMPTY_STRING, MB_CASE_LOWER, true, 'foobar'],
            [['foo', 'bar'], Convert::EMPTY_STRING, MB_CASE_TITLE, true, 'fooBar'],
            [['foo', 'bar'], Convert::EMPTY_STRING, MB_CASE_UPPER, true, 'fooBAR'],
            [['foo', 'bar'], Convert::SPACE, MB_CASE_LOWER, true, 'foo bar'],
            [['foo', 'bar'], Convert::SPACE, MB_CASE_TITLE, true, 'foo Bar'],
            [['foo', 'bar'], Convert::SPACE, MB_CASE_UPPER, true, 'foo BAR'],
            [['foo', 'bar'], '§', MB_CASE_LOWER, true, 'foo§bar'],
            [['foo', 'bar'], '§', MB_CASE_TITLE, true, 'foo§Bar'],
            [['foo', 'bar'], '§', MB_CASE_UPPER, true, 'foo§BAR'],
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
     * @param string $converterMethod
     *
     * @throws \ReflectionException
     */
    public function testConverterMethodCallsGlueString(string $converterMethod)
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
            'to' . Convert::ADA      => ['to' . Convert::ADA],
            'to' . Convert::CAMEL    => ['to' . Convert::CAMEL],
            'to' . Convert::COBOL    => ['to' . Convert::COBOL],
            'to' . Convert::KEBAB    => ['to' . Convert::KEBAB],
            'to' . Convert::LOWER    => ['to' . Convert::LOWER],
            'to' . Convert::MACRO    => ['to' . Convert::MACRO],
            'to' . Convert::PASCAL   => ['to' . Convert::PASCAL],
            'to' . Convert::SENTENCE => ['to' . Convert::SENTENCE],
            'to' . Convert::SNAKE    => ['to' . Convert::SNAKE],
            'to' . Convert::TITLE    => ['to' . Convert::TITLE],
            'to' . Convert::TRAIN    => ['to' . Convert::TRAIN],
            'to' . Convert::UPPER    => ['to' . Convert::UPPER],
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
     * @covers       \Jawira\CaseConverter\Convert::detectNamingConvention()
     *
     * @param string $analyseReturn Expected value returned by analyse() method
     * @param string $splitMethod   Split method to be called
     *
     * @dataProvider detectNamingConventionProvider()
     *
     * @throws \ReflectionException
     */
    public function testDetectNamingConvention(string $analyseReturn, string $splitMethod)
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
        $method     = $reflection->getMethod('detectNamingConvention');
        $method->setAccessible(true);

        // Testing
        $output = $method->invoke($mock, $inputString);
        $this->assertInstanceOf(Convert::class, $output);
    }

    public function detectNamingConventionProvider()
    {
        return [
            'underscore' => [Convert::STRATEGY_UNDERSCORE, 'splitUnderscoreString'],
            'dash'       => [Convert::STRATEGY_DASH, 'splitDashString'],
            'uppercase'  => [Convert::STRATEGY_UPPERCASE, 'splitUppercaseString'],
            'space'      => [Convert::STRATEGY_SPACE, 'splitSpaceString'],
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
