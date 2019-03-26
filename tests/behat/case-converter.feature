Feature: Convert Case
  In order to change string case
  Dev should be able to
  change case


  Scenario Outline: Convert a string calling a CaseConverter method
    Given CaseConverter class is instantiated with "<input-string>"
    When I call "<method>"
    Then method should return "<output-string>"

    Examples:
      | method   | input-string         | output-string        |
      | toCamel  |                      |                      |
      | toCamel  | a                    | a                    |
      | toCamel  | NASA                 | nasa                 |
      | toCamel  | Fbi                  | fbi                  |
      | toCamel  | B-C-D                | bCD                  |
      | toCamel  | CamelCase            | camelCase            |
      | toCamel  | dataTransfer         | dataTransfer         |
      | toCamel  | eniac_computer       | eniacComputer        |
      | toCamel  | FIBONACCI_NUMBER     | fibonacciNumber      |
      | toCamel  | Good_Morning_Vietnam | goodMorningVietnam   |
      | toCamel  | Jag_förstår_inte     | jagFörstårInte       |
      | toCamel  | quicoYÑoño           | quicoYÑoño           |
      | toCamel  | Πολύ-καλό            | πολύΚαλό             |
      | toCamel  | ОЧЕНЬ_ПРИЯТНО        | оченьПриятно         |
      | toCamel  | Ես-հայերեն-չգիտեմ    | եսՀայերենՉգիտեմ      |
      | toPascal |                      |                      |
      | toPascal | a                    | A                    |
      | toPascal | NASA                 | Nasa                 |
      | toPascal | Fbi                  | Fbi                  |
      | toPascal | B-C-D                | BCD                  |
      | toPascal | CamelCase            | CamelCase            |
      | toPascal | dataTransfer         | DataTransfer         |
      | toPascal | eniac_computer       | EniacComputer        |
      | toPascal | FIBONACCI_NUMBER     | FibonacciNumber      |
      | toPascal | Good_Morning_Vietnam | GoodMorningVietnam   |
      | toPascal | Jag_förstår_inte     | JagFörstårInte       |
      | toPascal | quicoYÑoño           | QuicoYÑoño           |
      | toPascal | Πολύ-καλό            | ΠολύΚαλό             |
      | toPascal | ОЧЕНЬ_ПРИЯТНО        | ОченьПриятно         |
      | toPascal | Ես-հայերեն-չգիտեմ    | ԵսՀայերենՉգիտեմ      |
      | toSnake  |                      |                      |
      | toSnake  | a                    | a                    |
      | toSnake  | NASA                 | nasa                 |
      | toSnake  | Fbi                  | fbi                  |
      | toSnake  | B-C-D                | b_c_d                |
      | toSnake  | CamelCase            | camel_case           |
      | toSnake  | dataTransfer         | data_transfer        |
      | toSnake  | eniac_computer       | eniac_computer       |
      | toSnake  | FIBONACCI_NUMBER     | fibonacci_number     |
      | toSnake  | Good_Morning_Vietnam | good_morning_vietnam |
      | toSnake  | Jag_förstår_inte     | jag_förstår_inte     |
      | toSnake  | quicoYÑoño           | quico_y_ñoño         |
      | toSnake  | Πολύ-καλό            | πολύ_καλό            |
      | toSnake  | ОЧЕНЬ_ПРИЯТНО        | очень_приятно        |
      | toSnake  | Ես-հայերեն-չգիտեմ    | ես_հայերեն_չգիտեմ    |
      | toMacro  |                      |                      |
      | toMacro  | a                    | A                    |
      | toMacro  | NASA                 | NASA                 |
      | toMacro  | Fbi                  | FBI                  |
      | toMacro  | B-C-D                | B_C_D                |
      | toMacro  | CamelCase            | CAMEL_CASE           |
      | toMacro  | dataTransfer         | DATA_TRANSFER        |
      | toMacro  | eniac_computer       | ENIAC_COMPUTER       |
      | toMacro  | FIBONACCI_NUMBER     | FIBONACCI_NUMBER     |
      | toMacro  | Good_Morning_Vietnam | GOOD_MORNING_VIETNAM |
      | toMacro  | Jag_förstår_inte     | JAG_FÖRSTÅR_INTE     |
      | toMacro  | quicoYÑoño           | QUICO_Y_ÑOÑO         |
      | toMacro  | Πολύ-καλό            | ΠΟΛΎ_ΚΑΛΌ            |
      | toMacro  | ОЧЕНЬ_ПРИЯТНО        | ОЧЕНЬ_ПРИЯТНО        |
      | toMacro  | Ես-հայերեն-չգիտեմ    | ԵՍ_ՀԱՅԵՐԵՆ_ՉԳԻՏԵՄ    |
      | toAda    |                      |                      |
      | toAda    | a                    | A                    |
      | toAda    | NASA                 | Nasa                 |
      | toAda    | Fbi                  | Fbi                  |
      | toAda    | B-C-D                | B_C_D                |
      | toAda    | CamelCase            | Camel_Case           |
      | toAda    | dataTransfer         | Data_Transfer        |
      | toAda    | eniac_computer       | Eniac_Computer       |
      | toAda    | FIBONACCI_NUMBER     | Fibonacci_Number     |
      | toAda    | Good_Morning_Vietnam | Good_Morning_Vietnam |
      | toAda    | Jag_förstår_inte     | Jag_Förstår_Inte     |
      | toAda    | quicoYÑoño           | Quico_Y_Ñoño         |
      | toAda    | Πολύ-καλό            | Πολύ_Καλό            |
      | toAda    | ОЧЕНЬ_ПРИЯТНО        | Очень_Приятно        |
      | toAda    | Ես-հայերեն-չգիտեմ    | Ես_Հայերեն_Չգիտեմ    |
      | toKebab  |                      |                      |
      | toKebab  | a                    | a                    |
      | toKebab  | NASA                 | nasa                 |
      | toKebab  | Fbi                  | fbi                  |
      | toKebab  | B-C-D                | b-c-d                |
      | toKebab  | CamelCase            | camel-case           |
      | toKebab  | dataTransfer         | data-transfer        |
      | toKebab  | eniac_computer       | eniac-computer       |
      | toKebab  | FIBONACCI_NUMBER     | fibonacci-number     |
      | toKebab  | Good_Morning_Vietnam | good-morning-vietnam |
      | toKebab  | Jag_förstår_inte     | jag-förstår-inte     |
      | toKebab  | quicoYÑoño           | quico-y-ñoño         |
      | toKebab  | Πολύ-καλό            | πολύ-καλό            |
      | toKebab  | ОЧЕНЬ_ПРИЯТНО        | очень-приятно        |
      | toKebab  | Ես-հայերեն-չգիտեմ    | ես-հայերեն-չգիտեմ    |
      | toCobol  |                      |                      |
      | toCobol  | a                    | A                    |
      | toCobol  | NASA                 | NASA                 |
      | toCobol  | Fbi                  | FBI                  |
      | toCobol  | B-C-D                | B-C-D                |
      | toCobol  | CamelCase            | CAMEL-CASE           |
      | toCobol  | dataTransfer         | DATA-TRANSFER        |
      | toCobol  | eniac_computer       | ENIAC-COMPUTER       |
      | toCobol  | FIBONACCI_NUMBER     | FIBONACCI-NUMBER     |
      | toCobol  | Good_Morning_Vietnam | GOOD-MORNING-VIETNAM |
      | toCobol  | Jag_förstår_inte     | JAG-FÖRSTÅR-INTE     |
      | toCobol  | quicoYÑoño           | QUICO-Y-ÑOÑO         |
      | toCobol  | Πολύ-καλό            | ΠΟΛΎ-ΚΑΛΌ            |
      | toCobol  | ОЧЕНЬ_ПРИЯТНО        | ОЧЕНЬ-ПРИЯТНО        |
      | toCobol  | Ես-հայերեն-չգիտեմ    | ԵՍ-ՀԱՅԵՐԵՆ-ՉԳԻՏԵՄ    |
      | toTrain  |                      |                      |
      | toTrain  | a                    | A                    |
      | toTrain  | NASA                 | Nasa                 |
      | toTrain  | Fbi                  | Fbi                  |
      | toTrain  | B-C-D                | B-C-D                |
      | toTrain  | CamelCase            | Camel-Case           |
      | toTrain  | dataTransfer         | Data-Transfer        |
      | toTrain  | eniac_computer       | Eniac-Computer       |
      | toTrain  | FIBONACCI_NUMBER     | Fibonacci-Number     |
      | toTrain  | Good_Morning_Vietnam | Good-Morning-Vietnam |
      | toTrain  | Jag_förstår_inte     | Jag-Förstår-Inte     |
      | toTrain  | quicoYÑoño           | Quico-Y-Ñoño         |
      | toTrain  | Πολύ-καλό            | Πολύ-Καλό            |
      | toTrain  | ОЧЕНЬ_ПРИЯТНО        | Очень-Приятно        |
      | toTrain  | Ես-հայերեն-չգիտեմ    | Ես-Հայերեն-Չգիտեմ    |
