<?php

use Jawira\CaseConverter\Convert;
use Jawira\CaseConverter\DashBased;
use Jawira\CaseConverter\NamingConvention;
use Jawira\CaseConverter\SpaceBased;
use Jawira\CaseConverter\UnderscoreBased;
use Jawira\CaseConverter\UppercaseBased;
use PHPUnit\Framework\TestCase;

class NamingConventionTest extends TestCase
{
    /**
     * @covers       \Jawira\CaseConverter\NamingConvention::splitUsingPattern
     * @dataProvider splitUsingPatternProvider
     *
     * @param string $pattern
     * @param string $input
     * @param array  $expected
     *
     * @throws \ReflectionException
     */
    public function testSplitUsingPattern(string $pattern, string $input, array $expected)
    {
        // Mocking abstract method
        $mock = $this->getMockBuilder(NamingConvention::class)
                     ->disableOriginalConstructor()
                     ->getMockForAbstractClass();

        // Making public a protected method
        $reflection = new ReflectionObject($mock);
        $method     = $reflection->getMethod('splitUsingPattern');
        $method->setAccessible(true);

        // Testing method
        $output = $method->invoke($mock, $input, $pattern);
        $this->assertSame($expected, $output);
    }

    public function splitUsingPatternProvider()
    {
        return [
            [DashBased::DELIMITER, 'hello-world', ['hello', 'world']],
            [DashBased::DELIMITER, 'HeLlO-WoRlD', ['HeLlO', 'WoRlD']],
            [DashBased::DELIMITER, 'Hello-World', ['Hello', 'World']],
            [DashBased::DELIMITER, 'HELLO-WORLD', ['HELLO', 'WORLD']],
            [DashBased::DELIMITER, '--hello--world--', ['hello', 'world']],
            [UnderscoreBased::DELIMITER, 'hello_world', ['hello', 'world']],
            [UnderscoreBased::DELIMITER, 'HeLlO_WoRlD', ['HeLlO', 'WoRlD']],
            [UnderscoreBased::DELIMITER, 'Hello_World', ['Hello', 'World']],
            [UnderscoreBased::DELIMITER, 'HELLO_WORLD', ['HELLO', 'WORLD']],
            [UnderscoreBased::DELIMITER, '__hello_____world__', ['hello', 'world']],
            [SpaceBased::DELIMITER, 'hEllO wOrlD', ['hEllO', 'wOrlD']],
            [SpaceBased::DELIMITER, 'hEllO wOrlD', ['hEllO', 'wOrlD']],
            [SpaceBased::DELIMITER, 'hEllO      wOrlD', ['hEllO', 'wOrlD']],
            [SpaceBased::DELIMITER, '           hEllO      wOrlD', ['hEllO', 'wOrlD']],
            [SpaceBased::DELIMITER, '           hEllO      wOrlD   ', ['hEllO', 'wOrlD']],
        ];
    }

    /**
     * @covers       \Jawira\CaseConverter\NamingConvention::glueUsingRules
     * @dataProvider glueUsingRulesProvider
     *
     * @param array  $words
     * @param string $glue
     * @param int    $mode
     * @param bool   $lowerCaseFirst
     *
     * @param string $expected
     *
     * @throws \ReflectionException
     */
    public function testGlueUsingRules(array $words, string $glue, int $mode, bool $lowerCaseFirst, string $expected)
    {
        // Disabling constructor without stub methods
        $mock = $this->getMockBuilder(NamingConvention::class)
                     ->disableOriginalConstructor()
                     ->setMethods([])
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

        // Testing
        $output = $method->invoke($mock, $glue, $mode, $lowerCaseFirst);
        $this->assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function glueUsingRulesProvider()
    {
        return [
            [['foo', 'bar'], DashBased::DELIMITER, MB_CASE_LOWER, false, 'foo-bar'],
            [['foo', 'bar'], DashBased::DELIMITER, MB_CASE_TITLE, false, 'Foo-Bar'],
            [['foo', 'bar'], DashBased::DELIMITER, MB_CASE_UPPER, false, 'FOO-BAR'],
            [['foo', 'bar'], UnderscoreBased::DELIMITER, MB_CASE_LOWER, false, 'foo_bar'],
            [['foo', 'bar'], UnderscoreBased::DELIMITER, MB_CASE_TITLE, false, 'Foo_Bar'],
            [['foo', 'bar'], UnderscoreBased::DELIMITER, MB_CASE_UPPER, false, 'FOO_BAR'],
            [['foo', 'bar'], UppercaseBased::DELIMITER, MB_CASE_LOWER, false, 'foobar'],
            [['foo', 'bar'], UppercaseBased::DELIMITER, MB_CASE_TITLE, false, 'FooBar'],
            [['foo', 'bar'], UppercaseBased::DELIMITER, MB_CASE_UPPER, false, 'FOOBAR'],
            [['foo', 'bar'], SpaceBased::DELIMITER, MB_CASE_LOWER, false, 'foo bar'],
            [['foo', 'bar'], SpaceBased::DELIMITER, MB_CASE_TITLE, false, 'Foo Bar'],
            [['foo', 'bar'], SpaceBased::DELIMITER, MB_CASE_UPPER, false, 'FOO BAR'],
            [['foo', 'bar'], '§', MB_CASE_LOWER, false, 'foo§bar'],
            [['foo', 'bar'], '§', MB_CASE_TITLE, false, 'Foo§Bar'],
            [['foo', 'bar'], '§', MB_CASE_UPPER, false, 'FOO§BAR'],
            [['foo', 'bar'], DashBased::DELIMITER, MB_CASE_LOWER, true, 'foo-bar'],
            [['foo', 'bar'], DashBased::DELIMITER, MB_CASE_TITLE, true, 'foo-Bar'],
            [['foo', 'bar'], DashBased::DELIMITER, MB_CASE_UPPER, true, 'foo-BAR'],
            [['foo', 'bar'], UnderscoreBased::DELIMITER, MB_CASE_LOWER, true, 'foo_bar'],
            [['foo', 'bar'], UnderscoreBased::DELIMITER, MB_CASE_TITLE, true, 'foo_Bar'],
            [['foo', 'bar'], UnderscoreBased::DELIMITER, MB_CASE_UPPER, true, 'foo_BAR'],
            [['foo', 'bar'], UppercaseBased::DELIMITER, MB_CASE_LOWER, true, 'foobar'],
            [['foo', 'bar'], UppercaseBased::DELIMITER, MB_CASE_TITLE, true, 'fooBar'],
            [['foo', 'bar'], UppercaseBased::DELIMITER, MB_CASE_UPPER, true, 'fooBAR'],
            [['foo', 'bar'], SpaceBased::DELIMITER, MB_CASE_LOWER, true, 'foo bar'],
            [['foo', 'bar'], SpaceBased::DELIMITER, MB_CASE_TITLE, true, 'foo Bar'],
            [['foo', 'bar'], SpaceBased::DELIMITER, MB_CASE_UPPER, true, 'foo BAR'],
            [['foo', 'bar'], '§', MB_CASE_LOWER, true, 'foo§bar'],
            [['foo', 'bar'], '§', MB_CASE_TITLE, true, 'foo§Bar'],
            [['foo', 'bar'], '§', MB_CASE_UPPER, true, 'foo§BAR'],
        ];
    }
}
