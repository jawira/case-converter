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
     * @dataProvider fromSnakeToCamelProvider
     *
     * @param $inputSnake
     * @param $expectedCamel
     */
    public function testFromSnakeToCamelConstructor($inputSnake, $expectedCamel)
    {
        $case = new Convert($inputSnake);
        $this->assertSame($expectedCamel, (string)$case);
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
            'two words 2'   => ['objectId', 'object_id'],
            'two words 3'   => ['firstName', 'first_name'],
            'two words 4'   => ['PascalCase', 'pascal_case'],
            'three words 1' => ['lowerCamelCase', 'lower_camel_case'],
            'three words 2' => ['numberOfProducts', 'number_of_products'],
            'acronym 1'     => ['ASCII', 'a_s_c_i_i'],
            'acronym 2'     => ['NASA', 'n_a_s_a'],
            'español 1'     => ['Ñandú', 'ñandú'],
            'español 2'     => ['VergüenzaAjena', 'vergüenza_ajena'],
            'oompa loompa'  => ['OompaLoompaDoompadeeDooIVeGotAnotherPuzzleForYou', 'oompa_loompa_doompadee_doo_i_ve_got_another_puzzle_for_you'],
        ];
    }

    public function fromSnakeToCamelProvider()
    {
        return [
            'empty'         => ['', ''],
            'one word 1'    => ['One', 'one'],
            'one word 2'    => ['Laser', 'laser'],
            'two words 1'   => ['product_id', 'productId'],
            'two words 2'   => ['last_update', 'lastUpdate'],
            'two words 3'   => ['CREATED_AT', 'createdAt'],
            'three words 1' => ['last_user_id', 'lastUserId'],
            'acronym 1'     => ['f_b_i', 'fBI'],
            'acronym 2'     => ['u_s_a', 'uSA'],
            'español 1'     => ['LETRA_EÑE', 'letraEñe'],
            'español 2'     => ['QUICO_Y_ÑOÑO', 'quicoYÑoño'],
            'español 3'     => ['Un_Gran_Árbol', 'unGranÁrbol'],
            'oompa loompa'  => ['oompa_loompa_doompadee_doo_i_ve_got_another_puzzle_for_you', 'oompaLoompaDoompadeeDooIVeGotAnotherPuzzleForYou'],
        ];
    }

}
