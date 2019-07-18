API
===

List of `\Jawira\CaseConverter\Convert` public methods.

String conversion
-----------------

| Method          | Description                       |
| --------------- | --------------------------------- |
| `toCamel()`     | Return string in _Camel case_     |
| `toPascal()`    | Return string in _Pascal case_    |
| `toSnake()`     | Return string in _Snake case_     |
| `toAda()`       | Return string in _Ada case_       |
| `toMacro()`     | Return string in _Macro case_     |
| `toKebab()`     | Return string in _Kebab case_     |
| `toTrain()`     | Return string in _Train case_     |
| `toCobol()`     | Return string in _Cobol case_     |
| `toLower()`     | Return string in _Lower case_     |
| `toUpper()`     | Return string in _Upper case_     |
| `toTitle()`     | Return string in _Title case_     |
| `toSentence()`  | Return string in _Sentence case_  |

Explicit case detection
-----------------------

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

Please note that some methods are equivalent and have the same effect:

- `fromCamel()` ≈ `fromPascal()`
- `fromSnake()` ≈ `fromAda()` ≈ `fromMacro()`
- `fromKebab()` ≈ `fromTrain()` ≈ `fromCobol()`
- `fromLower()` ≈ `fromUpper()` ≈ `fromTitle()` ≈ `fromSentence()`

All these methods exists only for sake of completeness.

Utility methods
---------------

| Method                      | Description                       |
| --------------------------- | --------------------------------- |
| `toArray()`                 | Returns array with detected words | 
| `forceSimpleCaseMapping()`  | Output sting uses _Simple Case-Mapping_ even if you are using PHP 7.3 or newer | 
