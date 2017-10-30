<?php
use Jawira\CaseConverter\Convert;
use PHPUnit\Framework\TestCase;

class ConvertTest extends TestCase
{

    /**
     * @dataProvider fromCamelToSnakeProvider
     *
     * @param string $inputCamel
     * @param string $expectedSnake
     */
    public function testFromCamelToSnakeConstructor($inputCamel, $expectedSnake)
    {
        $case = new Convert($inputCamel);
        $this->assertSame($expectedSnake, (string)$case);
    }


    /**
     * Camel to Snake provider
     *
     * @return array
     */
    public function fromCamelToSnakeProvider()
    {
        return [
            'empty'         => ['', ''],
            'one word 1'    => ['one', 'one'],
            'one word 2'    => ['Laser', 'laser'],
            'two words 1'   => ['helloWorld', 'hello_world'],
            'two words 2'   => ['HelloWorld', 'hello_world'],
            'two words 3'   => ['objectId', 'object_id'],
            'two words 4'   => ['firstName', 'first_name'],
            'two words 5'   => ['PascalCase', 'pascal_case'],
            'three words 1' => ['lowerCamelCase', 'lower_camel_case'],
            'three words 2' => ['numberOfProducts', 'number_of_products'],
            'acronym 1'     => ['ASCII', 'a_s_c_i_i'],
            'acronym 2'     => ['NASA', 'n_a_s_a'],
            'Oompa Loompa'  => ['OompaLoompaDoompadeeDooIVeGotAnotherPuzzleForYou', 'oompa_loompa_doompadee_doo_i_ve_got_another_puzzle_for_you'],
        ];
    }

}
