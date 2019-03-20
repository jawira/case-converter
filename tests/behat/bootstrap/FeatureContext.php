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
     * @var string
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
     * @Then method should return :returnString
     *
     * @param string $returnString Expected string
     *
     * @throws \Exception
     */
    public function methodShouldReturn($returnString)
    {
        if ($this->result !== $returnString) {
            $message = sprintf('Result "%s" is not equal to expected string "%s"', $this->result, $returnString);
            throw new Exception($message);
        }
    }
}
