Feature: Convert Case
  In order to change string case
  Dev should be able to
  change case


  Scenario Outline: Implicitly converting from Camel Case to Snake Case
    Given CaseConverter class is instantiated with "<camel>"
    When I cast object to string
    Then I should have "<snake>"

    Examples:
      | camel            | snake              |
      |                  |                    |
      | one              | one                |
      | Laser            | laser              |
      | helloWorld       | hello_world        |
      | objectId         | object_id          |
      | firstName        | first_name         |
      | PascalCase       | pascal_case        |
      | lowerCamelCase   | lower_camel_case   |
      | numberOfProducts | number_of_products |
      | ASCII            | a_s_c_i_i          |
      | NASA             | n_a_s_a            |
      | Ñandú            | ñandú              |
      | VergüenzaAjena   | vergüenza_ajena    |
      | πολύΚαλό         | πολύ_καλό          |
      | ОченьПриятно     | очень_приятно      |
      | եսՀայերենՉգիտեմ  | ես_հայերեն_չգիտեմ  |
      | jagFörstårInte   | jag_förstår_inte   |


  Scenario Outline: Implicitly converting from Snake Case to Camel Case
    Given CaseConverter class is instantiated with "<snake>"
    When I cast object to string
    Then I should have "<camel>"

    Examples:
      | snake             | camel           |
      |                   |                 |
      | One               | one             |
      | Laser             | laser           |
      | product_id        | productId       |
      | last_update       | lastUpdate      |
      | CREATED_AT        | createdAt       |
      | last_user_id      | lastUserId      |
      | f_b_i             | fBI             |
      | u_s_a             | uSA             |
      | LETRA_EÑE         | letraEñe        |
      | QUICO_Y_ÑOÑO      | quicoYÑoño      |
      | Un_Gran_Árbol     | unGranÁrbol     |
      | Πολύ_καλό         | πολύΚαλό        |
      | ОЧЕНЬ_ПРИЯТНО     | оченьПриятно    |
      | Ես_հայերեն_չգիտեմ | եսՀայերենՉգիտեմ |
      | Jag_förstår_inte  | jagFörstårInte  |


  Scenario Outline: Converting from Camel Case to screaming Snake Case
    Given CaseConverter class is instantiated with "<camel>"
    When I call "toSnake" method with "true" as argument
    Then I should have "<screaming>"

    Examples:
      | camel            | screaming          |
      |                  |                    |
      | one              | ONE                |
      | Laser            | LASER              |
      | helloWorld       | HELLO_WORLD        |
      | objectId         | OBJECT_ID          |
      | firstName        | FIRST_NAME         |
      | PascalCase       | PASCAL_CASE        |
      | lowerCamelCase   | LOWER_CAMEL_CASE   |
      | numberOfProducts | NUMBER_OF_PRODUCTS |
      | ASCII            | A_S_C_I_I          |
      | NASA             | N_A_S_A            |
      | Ñandú            | ÑANDÚ              |
      | VergüenzaAjena   | VERGÜENZA_AJENA    |
      | ΠολύΚαλό         | ΠΟΛΎ_ΚΑΛΌ          |
      | ОченьПриятно     | ОЧЕНЬ_ПРИЯТНО      |
      | եսՀայերենՉգիտեմ  | ԵՍ_ՀԱՅԵՐԵՆ_ՉԳԻՏԵՄ  |
      | jagFörstårInte   | JAG_FÖRSTÅR_INTE   |


  Scenario Outline: Converting from Snake Case to Pascal Case
    Given CaseConverter class is instantiated with "<snake>"
    When I call "toCamel" method with "true" as argument
    Then I should have "<pascal>"

    Examples:
      | snake             | pascal          |
      |                   |                 |
      | One               | One             |
      | Laser             | Laser           |
      | product_id        | ProductId       |
      | last_update       | LastUpdate      |
      | CREATED_AT        | CreatedAt       |
      | last_user_id      | LastUserId      |
      | f_b_i             | FBI             |
      | u_s_a             | USA             |
      | LETRA_EÑE         | LetraEñe        |
      | DON_RAMÓN_Y_ÑOÑO  | DonRamónYÑoño   |
      | Un_Gran_Árbol     | UnGranÁrbol     |
      | Πολύ_καλό         | ΠολύΚαλό        |
      | Очень_приятно     | ОченьПриятно    |
      | Ես_հայերեն_չգիտեմ | ԵսՀայերենՉգիտեմ |
      | Jag_förstår_inte  | JagFörstårInte  |


  Scenario Outline: Converting from Snake Case to Kebab case
    Given CaseConverter class is instantiated with "<snake>"
    When I call "toKebab" method with "false" as argument
    Then I should have "<kebab>"

    Examples:
      | snake             | kebab             |
      |                   |                   |
      | One               | one               |
      | Laser             | laser             |
      | product_id        | product-id        |
      | last_update       | last-update       |
      | CREATED_AT        | created-at        |
      | last_user_id      | last-user-id      |
      | f_b_i             | f-b-i             |
      | u_s_a             | u-s-a             |
      | LETRA_EÑE         | letra-eñe         |
      | QUICO_Y_ÑOÑO      | quico-y-ñoño      |
      | Un_Gran_Árbol     | un-gran-árbol     |
      | πολύ_Καλό         | πολύ-καλό         |
      | Очень_Приятно     | очень-приятно     |
      | ես_Հայերեն_Չգիտեմ | ես-հայերեն-չգիտեմ |
      | jag_Förstår_Inte  | jag-förstår-inte  |

  Scenario Outline: Converting from Snake Case to Train case
    Given CaseConverter class is instantiated with "<snake>"
    When I call "toKebab" method with "true" as argument
    Then I should have "<kebab>"

    Examples:
      | snake             | kebab             |
      |                   |                   |
      | One               | One               |
      | Laser             | Laser             |
      | product_id        | Product-Id        |
      | last_update       | Last-Update       |
      | CREATED_AT        | Created-At        |
      | last_user_id      | Last-User-Id      |
      | f_b_i             | F-B-I             |
      | u_s_a             | U-S-A             |
      | LETRA_EÑE         | Letra-Eñe         |
      | QUICO_Y_ÑOÑO      | Quico-Y-Ñoño      |
      | Un_Gran_Árbol     | Un-Gran-Árbol     |
      | πολύ_Καλό         | Πολύ-Καλό         |
      | Очень_Приятно     | Очень-Приятно     |
      | ես_Հայերեն_Չգիտեմ | Ես-Հայերեն-Չգիտեմ |
      | jag_Förstår_Inte  | Jag-Förstår-Inte  |

  Scenario Outline: Converting from Kebab case to Snake case
    Given CaseConverter class is instantiated with "<kebab>"
    When I call "toSnake" method with "false" as argument
    Then I should have "<snake>"

    Examples:
      | kebab             | snake            |
      |                   |                   |
      | One               | one               |
      | Laser             | laser             |
      | Product-Id        | product_id        |
      | Last-Update       | last_update       |
      | Created-At        | created_at        |
      | Last-User-Id      | last_user_id      |
      | F-B-I             | f_b_i             |
      | U-S-A             | u_s_a             |
      | Letra-Eñe         | letra_eñe         |
      | Quico-Y-Ñoño      | quico_y_ñoño      |
      | Un-Gran-Árbol     | un_gran_árbol     |
      | Πολύ-Καλό         | πολύ_καλό         |
      | Очень-Приятно     | очень_приятно     |
      | Ես-Հայերեն-Չգիտեմ | ես_հայերեն_չգիտեմ |
      | Jag-Förstår-Inte  | jag_förstår_inte  |
