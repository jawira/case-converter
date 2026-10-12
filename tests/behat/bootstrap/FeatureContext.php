<?php

namespace Jawira\CaseConverterBehat;

use Behat\Behat\Context\Context;
use Behat\Transformation\Transform;
use Jawira\CaseConverter\Convert;
use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var string|array
     */
    protected $result;

    /**
     * @var \Jawira\CaseConverter\Convert
     */
    protected $instance;

    /**
     * @var int Result of count()
     */
    protected $count;

    /**
     * @param string $argument String to convert
     */
    #[Given('CaseConverter class is instantiated with :argument')]
    public function caseConverterClassIsInstantiatedWith(string $argument)
    {
        $this->instance = new Convert($argument);
    }

    #[When('I call :methodName')]
    public function iCall(string $methodName)
    {
        $this->result = ($this->instance)->$methodName();
    }

    /**
     * @param string $returnString Expected string
     */
    #[Then('method should return string :returnString')]
    public function methodShouldReturnString(string $returnString)
    {
        if (!is_string($returnString)) {
            throw new \Exception('Result is not a string');
        }

        if ($this->result !== $returnString) {
            $message = sprintf('Result "%s" is not equal to expected string "%s"', $this->result, $returnString);
            throw new \Exception($message);
        }
    }

    /**
     * @param array $returnArray
     */
    #[Then('method should return array :returnArray')]
    public function methodShouldReturnArray($returnArray)
    {
        if (!is_array($returnArray)) {
            throw new \Exception('Result is not array');
        }

        if ($this->result !== $returnArray) {
            throw new \Exception('Result is not the expected array');
        }
    }

    /**
     * Convert string to array.
     *
     * Array format is `[One;Two;Three]`.
     *
     * @see https://behat.readthedocs.io/en/v2.5/guides/2.definitions.html#step-argument-transformations
     *
     * @param string $string The string to convert to array
     *
     * @return array
     */
    #[Transform('/^(\[.*\])$/')]
    public function transformStringToArray($string): array
    {
        $trimmed = trim($string, '[]');
        if ($trimmed === false) {
            $trimmed = '';
        }

        $exploded = explode(';', $trimmed);

        // Filtering since CaseConverter does the same.
        return array_filter($exploded);
    }

    /**
     * @When I use count function
     */
    public function iUseCountFunction()
    {
        $this->count = count($this->instance);
    }

    /**
     * @Then functions should return :expectedCount
     *
     * @param $expectedCount
     *
     * @throws \Exception
     */
    public function functionsShouldReturn($expectedCount)
    {
        if (!is_numeric($expectedCount)) {
            throw new \Exception('Count value is not numeric');
        }

        $expectedCount = (int)$expectedCount;

        if ($this->count !== $expectedCount) {
            throw new \Exception('Invalid count');
        }
    }
}
