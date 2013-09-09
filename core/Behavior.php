<?php

  /**
   *
   * @author Ivan Shcherbak <dev@funivan.com>
   */
  namespace Uc;

  class Behavior {

    /**
     * Main object
     *
     * @var null
     */
    protected $owner = null;

    /**
     * Custom configuration of behavior
     *
     * @var array
     */
    protected $config = array();

    /**
     * You can simple create behavior if you have owner
     *
     * @param       $owner
     * @param array $config
     */
    public function __construct($owner, $config = array()) {
      $this->owner = $owner;
      $this->config = $config;
    }

    /**
     * Return owner of this behavior
     *
     * @return null
     */
    protected function getOwner() {
      return $this->owner;
    }

    /**
     * Check if you can call method outside from behavior
     * You can rewrite part this method if you use `__call`
     *
     * @param $methodName
     * @return bool
     */
    public function hasMethod($methodName) {
      return (method_exists($this, $methodName) and is_callable(array($this, $methodName)));
    }

    /**
     * Check if property exists
     * You can rewrite this method if you use __get or __isset
     *
     * @param $propertyName
     * @return bool
     */
    public function hasProperty($propertyName) {
      return property_exists($this, $propertyName);
    }

  }