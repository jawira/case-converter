API
===

List of public methods.

`\Jawira\CaseConverter\Convert`
-------------------------------

### String conversion

| Method          | Description                             |
| --------------- | --------------------------------------- |
| `toCamel()`     | Return string in _Camel case_ format    |
| `toPascal()`    | Return string in _Pascal case_ format   |
| `toSnake()`     | Return string in _Snake case_ format    |
| `toAda()`       | Return string in _Ada case_ format      |
| `toMacro()`     | Return string in _Macro case_ format    |
| `toKebab()`     | Return string in _Kebab case_ format    |
| `toTrain()`     | Return string in _Train case_ format    |
| `toCobol()`     | Return string in _Cobol case_ format    |
| `toLower()`     | Return string in _Lower case_ format    |
| `toUpper()`     | Return string in _Upper case_ format    |
| `toTitle()`     | Return string in _Title case_ format    |
| `toSentence()`  | Return string in _Sentence case_ format |
| `toDot()`       | Return string in _Dot notation_         |

### Explicit case detection

| Method            | Description                                         |
| ----------------- | --------------------------------------------------- |
| `fromAuto()`      | (default) Auto-detect naming convention             |
| `fromCamel()`     | Split input string using uppercase characters       | 
| `fromPascal()`    | Split input string using uppercase characters       |
| `fromSnake()`     | Split input string using `_` (underscore character) |
| `fromAda()`       | Split input string using `_` (underscore character) |
| `fromMacro()`     | Split input string using `_` (underscore character) |
| `fromKebab()`     | Split input string using `-` (dash character)       |
| `fromTrain()`     | Split input string using `-` (dash character)       |
| `fromCobol()`     | Split input string using `-` (dash character)       |
| `fromLower()`     | Split input string using `␣` (space character)      |
| `fromUpper()`     | Split input string using `␣` (space character)      |
| `fromTitle()`     | Split input string using `␣` (space character)      |
| `fromSentence()`  | Split input string using `␣` (space character)      |
| `fromDot()`       | Split input string using `.` (dot character)        |

Please note that some methods are equivalent and have the same effect:

- `fromDot()`
- `fromCamel()` ≈ `fromPascal()`
- `fromSnake()` ≈ `fromAda()` ≈ `fromMacro()`
- `fromKebab()` ≈ `fromTrain()` ≈ `fromCobol()`
- `fromLower()` ≈ `fromUpper()` ≈ `fromTitle()` ≈ `fromSentence()`

All these methods exists only for sake of completeness.

### Utility methods

| Method                      | Description                       |
| --------------------------- | --------------------------------- |
| `getSource()`               | Returns original input string     |
| `toArray()`                 | Returns array with detected words |
| `forceSimpleCaseMapping()`  | Output sting uses [Simple Case-Mapping] even if you are using PHP 7.3 or newer | 


`\Jawira\CaseConverter\CaseConverter`
-------------------------------------

### Factory method

| Method        | Description                 |
| ------------- | --------------------------- |
| `convert()`   | Creates a `Convert` object  |


[Simple Case-Mapping]: ./case-mapping.md

