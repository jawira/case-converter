<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Jawira\CaseConverter\Convert;

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
     * @Given /^CaseConverter class is instantiated with "([^"]*)"$/
     * @param string $arg1 String to convert
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function caseConverterClassIsInstantiatedWith($arg1)
    {
        $this->instance = new Convert($arg1);
    }

    /**
     * @When I cast object to string
     */
    public function iCastObjectToString()
    {
        $this->result = (string)($this->instance);
    }

    /**
     * @When I call :methodName
     *
     * @param $methodName
     */
    public function iCall($methodName)
    {
        $this->result = ($this->instance)->$methodName();
    }

    /**
     * @Then method should return string :returnString
     *
     * @param string $returnString Expected string
     *
     * @throws \Exception
     */
    public function methodShouldReturnString($returnString)
    {
        if (!is_string($returnString)) {
            throw new Exception('Result is not a string');
        }

        if ($this->result !== $returnString) {
            $message = sprintf('Result "%s" is not equal to expected string "%s"', $this->result, $returnString);
            throw new Exception($message);
        }
    }

    /**
     * @Then method should return array :returnArray
     *
     * @param array $returnArray
     *
     * @throws \Exception
     */
    public function methodShouldReturnArray($returnArray)
    {
        if (!is_array($returnArray)) {
            throw new Exception('Result is not array');
        }

        if ($this->result !== $returnArray) {
            throw new Exception('Result is not the expected array');
        }
    }

    /**
     * Convert string to array.
     *
     * Array format is `[One;Two;Three]`.
     *
     * @Transform /^(\[.*\])$/
     *
     * @see https://behat.readthedocs.io/en/v2.5/guides/2.definitions.html#step-argument-transformations
     *
     * @param string $string The string to convert to array
     *
     * @return array
     */
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
}
