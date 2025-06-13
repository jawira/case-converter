Detection algorithm
===================

When `\Jawira\CaseConverter\Convert` class is instantiated, the input string is
analyzed to detect the words in it.

This is also the algorithm used by `Convert::fromAuto` method.

![Detection algorithm](images/detection-algorithm.png "Detection algorithm")

1. If input string contains `_` (underscore character), then `_` is used to
   split string.
2. If input string contains `-` (dash character), then `-` is used to split
   string.
3. If input string contains `␣` (space character), then `␣` is used to split
   string.
4. If input string contains `.` (space character), then `.` is used to split
   string.
5. If input string contains uppercase characters only, then the input string is
   considered to be a single word.
6. Finally, uppercase characters are used to split string.
