Feature: Convert Case
  In order to change string case
  Dev should be able to
  change case


  Scenario Outline: Change naming convention from string using explicit methods
    Given CaseConverter class is instantiated with "<input-string>"
    When I call "<method>"
    Then method should return string "<output-string>"

    Examples:
      | method     | input-string         | output-string        |
      | toCamel    |                      |                      |
      | toCamel    | a                    | a                    |
      | toCamel    | NASA                 | nasa                 |
      | toCamel    | Fbi                  | fbi                  |
      | toCamel    | B-C-D                | bCD                  |
      | toCamel    | CamelCase            | camelCase            |
      | toCamel    | dataTransfer         | dataTransfer         |
      | toCamel    | eniac_computer       | eniacComputer        |
      | toCamel    | FIBONACCI_NUMBER     | fibonacciNumber      |
      | toCamel    | v5.3.0               | v530                 |
      | toCamel    | Good_Morning_Vietnam | goodMorningVietnam   |
      | toCamel    | Buenos Días          | buenosDías           |
      | toCamel    | Jag_förstår_inte     | jagFörstårInte       |
      | toCamel    | quicoYÑoño           | quicoYÑoño           |
      | toCamel    | Πολύ-καλό            | πολύΚαλό             |
      | toCamel    | ОЧЕНЬ_ПРИЯТНО        | оченьПриятно         |
      | toCamel    | Ես-հայերեն-չգիտեմ    | եսՀայերենՉգիտեմ      |
      | toPascal   |                      |                      |
      | toPascal   | a                    | A                    |
      | toPascal   | NASA                 | Nasa                 |
      | toPascal   | Fbi                  | Fbi                  |
      | toPascal   | B-C-D                | BCD                  |
      | toPascal   | CamelCase            | CamelCase            |
      | toPascal   | dataTransfer         | DataTransfer         |
      | toPascal   | eniac_computer       | EniacComputer        |
      | toPascal   | FIBONACCI_NUMBER     | FibonacciNumber      |
      | toPascal   | v5.3.0               | V530                 |
      | toPascal   | Good_Morning_Vietnam | GoodMorningVietnam   |
      | toPascal   | Buenos Días          | BuenosDías           |
      | toPascal   | Jag_förstår_inte     | JagFörstårInte       |
      | toPascal   | quicoYÑoño           | QuicoYÑoño           |
      | toPascal   | Πολύ-καλό            | ΠολύΚαλό             |
      | toPascal   | ОЧЕНЬ_ПРИЯТНО        | ОченьПриятно         |
      | toPascal   | Ես-հայերեն-չգիտեմ    | ԵսՀայերենՉգիտեմ      |
      | toSnake    |                      |                      |
      | toSnake    | a                    | a                    |
      | toSnake    | NASA                 | nasa                 |
      | toSnake    | Fbi                  | fbi                  |
      | toSnake    | B-C-D                | b_c_d                |
      | toSnake    | CamelCase            | camel_case           |
      | toSnake    | dataTransfer         | data_transfer        |
      | toSnake    | eniac_computer       | eniac_computer       |
      | toSnake    | FIBONACCI_NUMBER     | fibonacci_number     |
      | toSnake    | v5.3.0               | v5_3_0               |
      | toSnake    | Good_Morning_Vietnam | good_morning_vietnam |
      | toSnake    | Good_Morning_Vietnam | good_morning_vietnam |
      | toSnake    | Buenos Días          | buenos_días          |
      | toSnake    | quicoYÑoño           | quico_y_ñoño         |
      | toSnake    | Πολύ-καλό            | πολύ_καλό            |
      | toSnake    | ОЧЕНЬ_ПРИЯТНО        | очень_приятно        |
      | toSnake    | Ես-հայերեն-չգիտեմ    | ես_հայերեն_չգիտեմ    |
      | toMacro    |                      |                      |
      | toMacro    | a                    | A                    |
      | toMacro    | NASA                 | NASA                 |
      | toMacro    | Fbi                  | FBI                  |
      | toMacro    | B-C-D                | B_C_D                |
      | toMacro    | CamelCase            | CAMEL_CASE           |
      | toMacro    | dataTransfer         | DATA_TRANSFER        |
      | toMacro    | eniac_computer       | ENIAC_COMPUTER       |
      | toMacro    | FIBONACCI_NUMBER     | FIBONACCI_NUMBER     |
      | toMacro    | v5.3.0               | V5_3_0               |
      | toMacro    | Good_Morning_Vietnam | GOOD_MORNING_VIETNAM |
      | toMacro    | Buenos Días          | BUENOS_DÍAS          |
      | toMacro    | Jag_förstår_inte     | JAG_FÖRSTÅR_INTE     |
      | toMacro    | quicoYÑoño           | QUICO_Y_ÑOÑO         |
      | toMacro    | Πολύ-καλό            | ΠΟΛΎ_ΚΑΛΌ            |
      | toMacro    | ОЧЕНЬ_ПРИЯТНО        | ОЧЕНЬ_ПРИЯТНО        |
      | toMacro    | Ես-հայերեն-չգիտեմ    | ԵՍ_ՀԱՅԵՐԵՆ_ՉԳԻՏԵՄ    |
      | toAda      |                      |                      |
      | toAda      | a                    | A                    |
      | toAda      | NASA                 | Nasa                 |
      | toAda      | Fbi                  | Fbi                  |
      | toAda      | B-C-D                | B_C_D                |
      | toAda      | CamelCase            | Camel_Case           |
      | toAda      | dataTransfer         | Data_Transfer        |
      | toAda      | eniac_computer       | Eniac_Computer       |
      | toAda      | FIBONACCI_NUMBER     | Fibonacci_Number     |
      | toAda      | v5.3.0               | V5_3_0               |
      | toAda      | Good_Morning_Vietnam | Good_Morning_Vietnam |
      | toAda      | Buenos Días          | Buenos_Días          |
      | toAda      | Jag_förstår_inte     | Jag_Förstår_Inte     |
      | toAda      | quicoYÑoño           | Quico_Y_Ñoño         |
      | toAda      | Πολύ-καλό            | Πολύ_Καλό            |
      | toAda      | ОЧЕНЬ_ПРИЯТНО        | Очень_Приятно        |
      | toAda      | Ես-հայերեն-չգիտեմ    | Ես_Հայերեն_Չգիտեմ    |
      | toKebab    |                      |                      |
      | toKebab    | a                    | a                    |
      | toKebab    | NASA                 | nasa                 |
      | toKebab    | Fbi                  | fbi                  |
      | toKebab    | B-C-D                | b-c-d                |
      | toKebab    | CamelCase            | camel-case           |
      | toKebab    | dataTransfer         | data-transfer        |
      | toKebab    | eniac_computer       | eniac-computer       |
      | toKebab    | FIBONACCI_NUMBER     | fibonacci-number     |
      | toKebab    | v5.3.0               | v5-3-0               |
      | toKebab    | Good_Morning_Vietnam | good-morning-vietnam |
      | toKebab    | Buenos Días          | buenos-días          |
      | toKebab    | Jag_förstår_inte     | jag-förstår-inte     |
      | toKebab    | quicoYÑoño           | quico-y-ñoño         |
      | toKebab    | Πολύ-καλό            | πολύ-καλό            |
      | toKebab    | ОЧЕНЬ_ПРИЯТНО        | очень-приятно        |
      | toKebab    | Ես-հայերեն-չգիտեմ    | ես-հայերեն-չգիտեմ    |
      | toCobol    |                      |                      |
      | toCobol    | a                    | A                    |
      | toCobol    | NASA                 | NASA                 |
      | toCobol    | Fbi                  | FBI                  |
      | toCobol    | B-C-D                | B-C-D                |
      | toCobol    | CamelCase            | CAMEL-CASE           |
      | toCobol    | dataTransfer         | DATA-TRANSFER        |
      | toCobol    | eniac_computer       | ENIAC-COMPUTER       |
      | toCobol    | FIBONACCI_NUMBER     | FIBONACCI-NUMBER     |
      | toCobol    | v5.3.0               | V5-3-0               |
      | toCobol    | Good_Morning_Vietnam | GOOD-MORNING-VIETNAM |
      | toCobol    | Buenos Días          | BUENOS-DÍAS          |
      | toCobol    | Jag_förstår_inte     | JAG-FÖRSTÅR-INTE     |
      | toCobol    | quicoYÑoño           | QUICO-Y-ÑOÑO         |
      | toCobol    | Πολύ-καλό            | ΠΟΛΎ-ΚΑΛΌ            |
      | toCobol    | ОЧЕНЬ_ПРИЯТНО        | ОЧЕНЬ-ПРИЯТНО        |
      | toCobol    | Ես-հայերեն-չգիտեմ    | ԵՍ-ՀԱՅԵՐԵՆ-ՉԳԻՏԵՄ    |
      | toTrain    |                      |                      |
      | toTrain    | a                    | A                    |
      | toTrain    | NASA                 | Nasa                 |
      | toTrain    | Fbi                  | Fbi                  |
      | toTrain    | B-C-D                | B-C-D                |
      | toTrain    | CamelCase            | Camel-Case           |
      | toTrain    | dataTransfer         | Data-Transfer        |
      | toTrain    | eniac_computer       | Eniac-Computer       |
      | toTrain    | FIBONACCI_NUMBER     | Fibonacci-Number     |
      | toTrain    | v5.3.0               | V5-3-0               |
      | toTrain    | Good_Morning_Vietnam | Good-Morning-Vietnam |
      | toTrain    | Buenos Días          | Buenos-Días          |
      | toTrain    | Jag_förstår_inte     | Jag-Förstår-Inte     |
      | toTrain    | quicoYÑoño           | Quico-Y-Ñoño         |
      | toTrain    | Πολύ-καλό            | Πολύ-Καλό            |
      | toTrain    | ОЧЕНЬ_ПРИЯТНО        | Очень-Приятно        |
      | toTrain    | Ես-հայերեն-չգիտեմ    | Ես-Հայերեն-Չգիտեմ    |
      | toLower    |                      |                      |
      | toLower    | a                    | a                    |
      | toLower    | NASA                 | nasa                 |
      | toLower    | Fbi                  | fbi                  |
      | toLower    | B-C-D                | b c d                |
      | toLower    | CamelCase            | camel case           |
      | toLower    | dataTransfer         | data transfer        |
      | toLower    | eniac_computer       | eniac computer       |
      | toLower    | FIBONACCI_NUMBER     | fibonacci number     |
      | toLower    | v5.3.0               | v5 3 0               |
      | toLower    | Good_Morning_Vietnam | good morning vietnam |
      | toLower    | Buenos Días          | buenos días          |
      | toLower    | Jag_förstår_inte     | jag förstår inte     |
      | toLower    | quicoYÑoño           | quico y ñoño         |
      | toLower    | Πολύ-καλό            | πολύ καλό            |
      | toLower    | ОЧЕНЬ_ПРИЯТНО        | очень приятно        |
      | toLower    | Ես-հայերեն-չգիտեմ    | ես հայերեն չգիտեմ    |
      | toUpper    |                      |                      |
      | toUpper    | a                    | A                    |
      | toUpper    | NASA                 | NASA                 |
      | toUpper    | Fbi                  | FBI                  |
      | toUpper    | B-C-D                | B C D                |
      | toUpper    | CamelCase            | CAMEL CASE           |
      | toUpper    | dataTransfer         | DATA TRANSFER        |
      | toUpper    | eniac_computer       | ENIAC COMPUTER       |
      | toUpper    | v5.3.0               | V5 3 0               |
      | toUpper    | FIBONACCI_NUMBER     | FIBONACCI NUMBER     |
      | toUpper    | Good_Morning_Vietnam | GOOD MORNING VIETNAM |
      | toUpper    | Buenos Días          | BUENOS DÍAS          |
      | toUpper    | Jag_förstår_inte     | JAG FÖRSTÅR INTE     |
      | toUpper    | quicoYÑoño           | QUICO Y ÑOÑO         |
      | toUpper    | Πολύ-καλό            | ΠΟΛΎ ΚΑΛΌ            |
      | toUpper    | ОЧЕНЬ_ПРИЯТНО        | ОЧЕНЬ ПРИЯТНО        |
      | toUpper    | Ես-հայերեն-չգիտեմ    | ԵՍ ՀԱՅԵՐԵՆ ՉԳԻՏԵՄ    |
      | toTitle    |                      |                      |
      | toTitle    | a                    | A                    |
      | toTitle    | NASA                 | Nasa                 |
      | toTitle    | Fbi                  | Fbi                  |
      | toTitle    | B-C-D                | B C D                |
      | toTitle    | CamelCase            | Camel Case           |
      | toTitle    | dataTransfer         | Data Transfer        |
      | toTitle    | eniac_computer       | Eniac Computer       |
      | toTitle    | FIBONACCI_NUMBER     | Fibonacci Number     |
      | toTitle    | v5.3.0               | V5 3 0               |
      | toTitle    | Good_Morning_Vietnam | Good Morning Vietnam |
      | toTitle    | Buenos Días          | Buenos Días          |
      | toTitle    | Jag_förstår_inte     | Jag Förstår Inte     |
      | toTitle    | quicoYÑoño           | Quico Y Ñoño         |
      | toTitle    | Πολύ-καλό            | Πολύ Καλό            |
      | toTitle    | ОЧЕНЬ_ПРИЯТНО        | Очень Приятно        |
      | toTitle    | Ես-հայերեն-չգիտեմ    | Ես Հայերեն Չգիտեմ    |
      | toSentence |                      |                      |
      | toSentence | a                    | A                    |
      | toSentence | NASA                 | Nasa                 |
      | toSentence | Fbi                  | Fbi                  |
      | toSentence | B-C-D                | B c d                |
      | toSentence | CamelCase            | Camel case           |
      | toSentence | dataTransfer         | Data transfer        |
      | toSentence | eniac_computer       | Eniac computer       |
      | toSentence | FIBONACCI_NUMBER     | Fibonacci number     |
      | toSentence | v5.3.0               | V5 3 0               |
      | toSentence | Good_Morning_Vietnam | Good morning vietnam |
      | toSentence | Buenos Días          | Buenos días          |
      | toSentence | Jag_förstår_inte     | Jag förstår inte     |
      | toSentence | quicoYÑoño           | Quico y ñoño         |
      | toSentence | Πολύ-καλό            | Πολύ καλό            |
      | toSentence | ОЧЕНЬ_ПРИЯТНО        | Очень приятно        |
      | toSentence | Ես-հայերեն-չգիտեմ    | Ես հայերեն չգիտեմ    |
      | toDot      |                      |                      |
      | toDot      | a                    | a                    |
      | toDot      | NASA                 | nasa                 |
      | toDot      | Fbi                  | fbi                  |
      | toDot      | B-C-D                | b.c.d                |
      | toDot      | CamelCase            | camel.case           |
      | toDot      | dataTransfer         | data.transfer        |
      | toDot      | eniac_computer       | eniac.computer       |
      | toDot      | FIBONACCI_NUMBER     | fibonacci.number     |
      | toDot      | Good_Morning_Vietnam | good.morning.vietnam |
      | toDot      | Buenos Días          | buenos.días          |
      | toDot      | Jag_förstår_inte     | jag.förstår.inte     |
      | toDot      | quicoYÑoño           | quico.y.ñoño         |
      | toDot      | Πολύ-καλό            | πολύ.καλό            |
      | toDot      | ОЧЕНЬ_ПРИЯТНО        | очень.приятно        |
      | toDot      | Ես-հայերեն-չգիտեմ    | ես.հայերեն.չգիտեմ    |


  Scenario Outline: Convert a string to array
    Given CaseConverter class is instantiated with "<input-string>"
    When I call "<method>"
    Then method should return array "<output-array>"

    Examples:
      | method  | input-string    | output-array      |
      | toArray |                 | []                |
      | toArray | a               | [a]               |
      | toArray | HugoPacoLuis    | [Hugo;Paco;Luis]  |
      | toArray | loremIpsum      | [lorem;Ipsum]     |
      | toArray | aBc_DeF_hIj_KlM | [aBc;DeF;hIj;KlM] |
      | toArray | one__two        | [one;two]         |
      | toArray | Le Népal        | [Le;Népal]        |
      | toArray | red.green.blue  | [red;green;blue]  |


  Scenario: Force simple case mapping
    Given CaseConverter class is instantiated with "Straße"
    When I call "forceSimpleCaseMapping"
    And I call "toMacro"
    Then method should return string "STRAßE"


  Scenario Outline: Using numbers in input strings
    Given CaseConverter class is instantiated with "<input-string>"
    When I call "<method>"
    Then method should return string "<output-string>"

    Examples:
      | method     | input-string              | output-string          |
      | toCamel    | I-have-99-problems        | iHave99Problems        |
      | toPascal   | The Taking of Pelham 123  | TheTakingOfPelham123   |
      | toSnake    | 3_idiots_2009             | 3_idiots_2009          |
      | toMacro    | fantastic-4               | FANTASTIC_4            |
      | toAda      | the6ThDay                 | The6_Th_Day            |
      | toKebab    | 7samurai                  | 7samurai               |
      | toCobol    | Super8                    | SUPER8                 |
      | toTrain    | 8Mm                       | 8-Mm                   |
      | toLower    | 8MM                       | 8 m m                  |
      | toUpper    | DISTRICT_9                | DISTRICT 9             |
      | toTitle    | session9                  | Session9               |
      | toSentence | 9Songs                    | 9 songs                |
      | toCamel    | STARTER-FOR-10            | starterFor10           |
      | toPascal   | Ocean's 11                | Ocean's11              |
      | toSnake    | 12_angry_men              | 12_angry_men           |
      | toMacro    | Apollo13                  | APOLLO13               |
      | toAda      | Friday-the-13th           | Friday_The_13Th        |
      | toKebab    | 14BLADES                  | 14-b-l-a-d-e-s         |
      | toCobol    | STALAG17-1953             | STALAG17-1953          |
      | toTrain    | 21-JUMP-STREET            | 21-Jump-Street         |
      | toLower    | TheNumber23               | the number23           |
      | toUpper    | The 40-Year-Old Virgin    | THE 40 YEAR OLD VIRGIN |
      | toTitle    | planet_51                 | Planet 51              |
      | toSentence | Passenger 57              | Passenger 57           |
      | toCamel    | 10-10-a-a-10-10           | 1010AA1010             |
      | toPascal   | Hello5My5Name5Is5Bond     | Hello5My5Name5Is5Bond  |
      | toSnake    | 48-HOLA-mundo-6           | 48_hola_mundo_6        |
      | toMacro    | 0-0-0                     | 0_0_0                  |
      | toAda      | Interstate 60             | Interstate_60          |
      | toKebab    | Happy2-see-you            | happy2-see-you         |
      | toCobol    | 123BC456BC789             | 123-B-C456-B-C789      |
      | toTrain    | 21-test-test21-21Test     | 21-Test-Test21-21Test  |
      | toLower    | TheNumber23               | the number23           |
      | toUpper    | 88 Minutes                | 88 MINUTES             |
      | toTitle    | United9                   | United9                |
      | toSentence | 300                       | 300                    |
      | toCamel    | the__0__is_the_best       | the0IsTheBest          |
      | toPascal   | i-do--not--0like--number0 | IDoNot0LikeNumber0     |
      | toSnake    | IDoNot0LikeNumber0        | i_do_not0_like_number0 |
      | toMacro    | you-have-0-money          | YOU_HAVE_0_MONEY       |
      | toDot      | se7en                     | se7en                  |
      | toDot      | Red1Green2Blue3           | red1.green2.blue3      |
      | toDot      | REEL2REAL                 | r.e.e.l2.r.e.a.l       |
      | toDot      | reel2real                 | reel2real              |
      | toDot      | Reel2Real                 | reel2.real             |


  Scenario: Retrieving original string
    Given CaseConverter class is instantiated with "  A commissioned mirror swears.  "
    When I call "getSource"
    Then method should return string "  A commissioned mirror swears.  "


  Scenario Outline: Handling strings with mixed delimiters
    Given CaseConverter class is instantiated with "<input-string>"
    When I call "<from-method>"
    And I call "<to-method>"
    Then method should return string "<output-string>"

    Examples:
      | from-method | to-method | input-string    | output-string     |
      | fromSnake   | toSnake   | C-3PO_and_R2-D2 | c-3po_and_r2-d2   |
      | fromSnake   | toPascal  | C-3PO_and_R2-D2 | C-3PoAndR2-D2     |
      | fromPascal  | toSnake   | C-3PoAndR2-D2   | c-3_po_and_r2-_d2 |
      | fromUpper   | toDot     | non-SI units    | non-si.units      |


  Scenario Outline: Manually set input string format (test from* methods)
    Given CaseConverter class is instantiated with "<input-string>"
    When I call "<from-method>"
    And I call "<to-method>"
    Then method should return string "<output-string>"

    Examples:
      | from-method | to-method | input-string | output-string |
      | fromDot     | toSnake   | v5.0.2       | v5_0_2        |
