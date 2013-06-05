<?php
  namespace Test\Ub\Helper;

  use Behat\Behat\Context\BehatContext;

  class Arrays extends BehatContext {

    protected $mainArray = array();

    protected $localArray = array();

    protected $resultArray = array();

    /**
     * @Given /^a have main array with key "([^"]*)" and value "([^"]*)"$/
     */
    public function aHaveMainArrayWithKeyAndValue($key, $value) {
      $this->mainArray[$key] = $value;
    }

    /**
     * @Given /^other array has key "([^"]*)" and value "([^"]*)"$/
     */
    public function otherArrayHasKeyAndValue($key, $value) {
      $this->localArray[$key] = $value;
    }

    /**
     * @When /^I merge them recursive$/
     */
    public function iMergeThemRecursive() {
      $this->resultArray = \Ub\Helper\Arrays::mergeRecursive($this->mainArray, $this->localArray);
    }

    /**
     * @Then /^I expect '([^']*)'$/
     */
    public function iExpect($result) {
      $currentResult = serialize($this->resultArray);
      if ($result != $currentResult) {
        throw new \Exception('Result not valid. Current result is:' . $currentResult);
      }
    }

  }
