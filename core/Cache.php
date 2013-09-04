<?php

  namespace Uc;

  class Cache extends Component {

    private $data = array();

    public function __construct() {
      $this->init();
    }

    /**
     * @param string  $key
     * @param integer $item
     */
    public function set($key, $item) {
      $this->data[$key] = $item;
    }

    /**
     *
     * @param string|integer $key
     * @return mixed
     */
    public function get($key) {
      return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     *
     * @param string|integer $key
     * @return boolean
     */
    public function has($key) {
      return isset($this->data[$key]);
    }

  }