<?php
  namespace Test\Uc;

  class Controller extends \Test\MainContext {

    const N = __CLASS__;

    /**
     * @var \Uc\Controller
     */
    public $class = null;

    /**
     * @var string
     */
    public $path = null;

    protected function getClassName($className) {
      return '\TestApp\\' . trim($className);
    }

    /**
     * @Given /^i use ([a-z0-9_]+) controller$/
     */
    public function iUseController($className) {
      $classFullName = $this->getClassName('Office\\' . ucfirst($className) . '\Controller');
      $this->class = new $classFullName();
    }

    /**
     * @Given /^i check (theme|class) view file ([\/a-z0-9_-]+)$/
     */
    public function iRenderView($renderType, $view) {
      $methodName = 'get' . ucfirst($renderType) . 'ViewFilePath';
      $this->path = $this->class->{$methodName}($view);
    }

    /**
     * @Then /^i expect view path contain (.*)$/
     */
    public function iExpectViewPathContain($path) {
      if (strpos($this->path, $path) === false) {
        throw new \Exception('Expect string: ' . $this->path . " contain: " . $path);
      }
    }

  }
