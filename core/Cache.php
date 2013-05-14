<?php

  namespace Uc;

  class Cache {

    private static $data = array();

    /**
     * @param string  $key
     * @param integer $item
     */
    public static function set($key, $item) {
      self::$data[$key] = $item;
    }

    /**
     *
     * @param string|integer $key
     * @return mixed
     */
    public static function get($key) {
      return isset(self::$data[$key]) ? self::$data[$key] : null;
    }

    /**
     *
     * @param string|integer $key
     * @return boolean
     */
    public static function has($key) {
      return isset(self::$data[$key]);
    }

  }