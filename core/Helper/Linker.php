<?php

  namespace Uc\Helper;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Linker {

    /**
     *
     * @var string
     */
    private $script = '/';

    /**
     *
     * @var array
     */
    private $params = array();

    /**
     *
     * @param type $url
     * @throws \Exception
     */
    public function __construct($url = null) {
      if ($url === null) {
        $url = $_SERVER['REQUEST_URI'];
      }

      preg_match('!^(/[^\?]*)(|\?(.*))$!', $url, $match);
      if (empty($match)) {
        throw new \Exception("bad orig_uri for linker");
      }
      $this->setUrl($match[1]);

      $params = !empty($match[3]) ? $match[3] : array();
      $this->setParams($params);
    }

    /**
     * @param mixed (array, string) $paramsList
     * @param bool                  $param
     * @return string
     */
    public function make($paramsList = array(), $param = false) {
      $uri = $this->script;
      $params = $this->params;
      if (is_string($paramsList)) {
        $paramsList = array(
          $paramsList => $param,
        );
      }
      foreach ($paramsList as $key => $value) {
        if ($value !== false and $value !== null) {
          $params[$key] = $value;
        } else {
          unset($params[$key]);
        }
      }

      if (!empty($params)) {
        $uri .= '?' . http_build_query($params);
      }
      return $uri;
    }

    /**
     * @author Ivan Scherbak <dev@funivan.com>
     * @return Helper_Linker
     */
    public function remove() {
      $arg_list = func_get_args();
      foreach ($arg_list as $arg) {
        if (is_string($arg) or is_numeric($arg)) {
          unset($this->params[$arg]);
        }
      }
      return $this;
    }

    /**
     *
     * @author Ivan Scherbak <dev@funivan.com>
     * @param string $url
     * @return boolean
     */
    public function setUrl($url) {
      if (!empty($url)) {
        $this->script = $url;
        return true;
      } else {
        return false;
      }
    }

    /**
     *
     * @author Ivan Scherbak <dev@funivan.com>
     * @param arrau | string $params
     * @return boolean
     */
    public function setParams($params) {
      if (is_string($params) and !empty($params)) {
        parse_str($params, $this->params);
        return true;
      } elseif (is_array($params)) {
        $this->params = $params;
        return true;
      } else {
        return false;
      }
    }

    /**
     *
     * @author Ivan Scherbak <dev@funivan.com>
     * @param array $params
     * @return boolean
     */
    public function addParams($params) {
      if (is_array($params)) {
        $this->params = array_merge($this->params, $params);
        return true;
      } else {
        return false;
      }
    }

  }

