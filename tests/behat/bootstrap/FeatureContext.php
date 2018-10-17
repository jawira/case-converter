<?php

use Behat\Behat\Context\Context;
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
     * @Then /^I should have "([^"]*)"$/
     * @param string $arg1 Converted expected string
     *
     * @throws \Exception
     */
    public function iShouldHave($arg1)
    {
        if ($this->result !== $arg1) {
            $message = sprintf('Result "%s" is not equal to expected string "%s"', $this->result, $arg1);
            throw new Exception($message);
        }
    }


    /**
     * @When I call :arg1 method with :arg2 as argument
     *
     * @param string $arg1 Name of the method to call
     * @param string $arg2 'true' or 'false' string
     *
     * @throws \Exception
     */
    public function iCallMethodWithAsArgument($arg1, $arg2)
    {
        switch ($arg2) {
            case 'true':
                $argument = true;
                break;
            case 'false':
                $argument = false;
                break;
            default:
                $message = sprintf('Invalid "%s" argument', $arg2);
                throw new Exception($message);
        }

        $this->result = ($this->instance)->$arg1($argument);
    }

}
