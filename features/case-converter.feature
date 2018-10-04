Feature: Convert Case
  In order to change string case
  Dev should be able to
  change case


  Scenario Outline: Implicitly converting from Camel Case to Snake Case
    Given CaseConverter class is instantiated with "<camel>"
    When I cast object to string
    Then I should have "<snake>"

    Examples:
      | camel                                            | snake                                                      |
      |                                                  |                                                            |
      | one                                              | one                                                        |
      | Laser                                            | laser                                                      |
      | helloWorld                                       | hello_world                                                |
      | objectId                                         | object_id                                                  |
      | firstName                                        | first_name                                                 |
      | PascalCase                                       | pascal_case                                                |
      | lowerCamelCase                                   | lower_camel_case                                           |
      | numberOfProducts                                 | number_of_products                                         |
      | ASCII                                            | a_s_c_i_i                                                  |
      | NASA                                             | n_a_s_a                                                    |
      | Ñandú                                            | ñandú                                                      |
      | VergüenzaAjena                                   | vergüenza_ajena                                            |
      | OompaLoompaDoompadeeDooIVeGotAnotherPuzzleForYou | oompa_loompa_doompadee_doo_i_ve_got_another_puzzle_for_you |


  Scenario Outline: Implicitly converting from Snake Case to Camel Case
    Given CaseConverter class is instantiated with "<snake>"
    When I cast object to string
    Then I should have "<camel>"

    Examples:
      | snake                                                      | camel                                            |
      |                                                            |                                                  |
      | One                                                        | one                                              |
      | Laser                                                      | laser                                            |
      | product_id                                                 | productId                                        |
      | last_update                                                | lastUpdate                                       |
      | CREATED_AT                                                 | createdAt                                        |
      | last_user_id                                               | lastUserId                                       |
      | f_b_i                                                      | fBI                                              |
      | u_s_a                                                      | uSA                                              |
      | LETRA_EÑE                                                  | letraEñe                                         |
      | QUICO_Y_ÑOÑO                                               | quicoYÑoño                                       |
      | Un_Gran_Árbol                                              | unGranÁrbol                                      |
      | oompa_loompa_doompadee_doo_i_ve_got_another_puzzle_for_you | oompaLoompaDoompadeeDooIVeGotAnotherPuzzleForYou |


  Scenario Outline: Converting from Camel Case to screaming Snake Case
    Given CaseConverter class is instantiated with "<camel>"
    When I call "toSnake" method with "true" as argument
    Then I should have "<screaming>"

    Examples:
      | camel                                            | screaming                                                  |
      |                                                  |                                                            |
      | one                                              | ONE                                                        |
      | Laser                                            | LASER                                                      |
      | helloWorld                                       | HELLO_WORLD                                                |
      | objectId                                         | OBJECT_ID                                                  |
      | firstName                                        | FIRST_NAME                                                 |
      | PascalCase                                       | PASCAL_CASE                                                |
      | lowerCamelCase                                   | LOWER_CAMEL_CASE                                           |
      | numberOfProducts                                 | NUMBER_OF_PRODUCTS                                         |
      | ASCII                                            | A_S_C_I_I                                                  |
      | NASA                                             | N_A_S_A                                                    |
      | Ñandú                                            | ÑANDÚ                                                      |
      | VergüenzaAjena                                   | VERGÜENZA_AJENA                                            |
      | OompaLoompaDoompadeeDooIVeGotAnotherPuzzleForYou | OOMPA_LOOMPA_DOOMPADEE_DOO_I_VE_GOT_ANOTHER_PUZZLE_FOR_YOU |


  Scenario Outline: Converting from Snake Case to Pascal Case
    Given CaseConverter class is instantiated with "<snake>"
    When I call "toCamel" method with "true" as argument
    Then I should have "<pascal>"

    Examples:
      | snake                                                      | pascal                                           |
      |                                                            |                                                  |
      | One                                                        | One                                              |
      | Laser                                                      | Laser                                            |
      | product_id                                                 | ProductId                                        |
      | last_update                                                | LastUpdate                                       |
      | CREATED_AT                                                 | CreatedAt                                        |
      | last_user_id                                               | LastUserId                                       |
      | f_b_i                                                      | FBI                                              |
      | u_s_a                                                      | USA                                              |
      | LETRA_EÑE                                                  | LetraEñe                                         |
      | QUICO_Y_ÑOÑO                                               | QuicoYÑoño                                       |
      | Un_Gran_Árbol                                              | UnGranÁrbol                                      |
      | oompa_loompa_doompadee_doo_i_ve_got_another_puzzle_for_you | OompaLoompaDoompadeeDooIVeGotAnotherPuzzleForYou |
