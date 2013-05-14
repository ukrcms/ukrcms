<?php

  namespace Uc;

  /**
   * @author  Ivan Scherbak <dev@funivan.com> 7/20/12
   */
  class Url extends Component {

    /**
     *
     *
     * @var array
     */
    public $rules = array();

    /**
     * @var string
     */
    protected $protocol = '';

    /**
     * @var string
     */
    protected $hostName = '';

    /**
     * @var string
     */
    public $baseUrl = '';

    /**
     *
     * @var string
     */
    protected $requestUrl = '';

    /**
     *
     * @var type
     */
    protected $requestPath = '';

    /**
     *
     * @var boolean
     */
    private $_urlIsParsed = false;

    /**
     *
     * @var string
     */
    private $_controllerName = '';

    /**
     *
     * @var string
     */
    private $_actionName = '';

    /**
     *
     * @var string
     */
    private $_route = '';

    /**
     *
     * @var array
     */
    private $_params = array();

    public function init() {

      if (empty($this->protocol) and !empty($_SERVER['SERVER_PROTOCOL'])) {
        $this->protocol = strtolower(preg_replace('!/(.*)$!', '', $_SERVER['SERVER_PROTOCOL']));
      }

      if (empty($this->hostName) and !empty($_SERVER[strtoupper($this->protocol) . '_HOST'])) {
        $this->hostName = $_SERVER[strtoupper($this->protocol) . '_HOST'];
      }

      if (empty($this->protocol) or empty($this->hostName)) {
        trigger_error('Please set $hostName and $protocol in class ' . get_class($this));
      }
    }

    /**
     *
     * @throws \Exception
     * @return boolean
     */
    private function _parseUrl() {
      if ($this->_urlIsParsed) {
        return true;
      }

      if (!empty($this->rules)) {

        $url = $_SERVER['REQUEST_URI'];

        if (!empty($this->baseUrl)) {
          $this->requestUrl = preg_replace('!^' . $this->baseUrl . '!', '', $url);
        } else {
          $this->requestUrl = $url;
        }

        if (empty($this->requestUrl)) {
          $this->requestUrl = '/';
        }

        $this->requestPath = str_replace('?' . $_SERVER['QUERY_STRING'], '', $this->requestUrl);

        foreach ($this->rules as $routeRegex => $routeAction) {
          # prepere regexp Url
          $regex = '!^' . $routeRegex . '[/]{0,1}(\?.*|)$!U';
          $regex = preg_replace('!<([^:]+)>!U', '<$1:.*>', $regex);
          $regex = preg_replace('!<([^:]+):([^>]+)>!U', '(?P<$1>$2)', $regex);
          if (preg_match($regex, $this->requestUrl, $match)) {
            foreach ($match as $k => $v) {
              if (is_int($k)) {
                unset($match[$k]);
              }
            }

            $match = array_merge(array_filter($match), $_GET);
            if ($match) {
              $this->_params = $match;
            }
            if (strpos($routeAction, '<') !== false) {
              foreach ($match as $key => $value) {
                $routeAction = str_replace('<' . $key . '>', $value, $routeAction);
              }
            }

            $caNames = $this->getControllerActionFromRoute($routeAction);

            if (empty($caNames)) {
              throw new \Exception('Route {' . $routeAction . '} is not valid. Can not detect Controller and Action');
            }
            $this->_controllerName = $caNames[0];
            $this->_actionName = $caNames[1];
            $this->_route = $this->_controllerName . '/' . $this->_actionName;

            $this->_urlIsParsed = true;
            return true;
          }
        }
      } else {
        throw new \Exception('Url rules is empty');
      }
      return false;
    }

    public function getControllerActionFromRoute($route) {
      preg_match('!^(?<controller>.*)/(?<action>[^/]+)$!', $route, $controllerActionNames);
      if (empty($controllerActionNames)) {
        return false;
      } else {
        return array(
          $controllerActionNames['controller'],
          $controllerActionNames['action']
        );
      }
    }

    public function createUrl($route, $params = array()) {
      return $this->create($route, $params);
    }

    public function create($route, $params = array()) {
      $url = $route;
      if (empty($url) or $url == '/') {
        return $this->getUrl();
      }
      foreach ($this->rules as $routeRegex => $routeAction) {
        # prepare regexp Url
        $regex = '!^' . $routeAction . '$!';
        $regex = preg_replace('!<([^:]+)>!U', '<$1:.*>', $regex);
        $regex = preg_replace('!<([^:]+):([^>]+)>!U', '(?P<$1>$2)', $regex);
        if (preg_match($regex, $route, $match)) {
          $url = $routeRegex;

          if (strpos($routeRegex, '<') !== false) {
            foreach ($match as $key => $value) {
              $url = preg_replace('!<' . $key . '(:[^>]+|)>!U', trim($value, '/'), $url);
            }
          }
          break;
        }
      }

      if (!empty($params)) {

        foreach ($params as $k => $v) {
          $url = preg_replace('!<' . $k . '(:[^>]+|)>!', $v, $url, -1, $count);
          if ($count) {
            unset($params[$k]);
          }
        }

        if (!empty($params)) {
          $url .= '?' . http_build_query($params);
        }
      }

      return $this->getUrl() . $url;
    }

    /**
     *
     * @return type
     */
    public function getControllerName() {
      $this->_parseUrl();
      return $this->_controllerName;
    }

    /**
     *
     * @return type
     */
    public function getActionName() {
      $this->_parseUrl();
      return $this->_actionName;
    }

    /**
     *
     * @return type
     */
    public function getParams() {
      $this->_parseUrl();
      return $this->_params;
    }

    /**
     * Absolute url to index
     *
     * @author  Ivan Scherbak <dev@funivan.com> 8/13/12
     * @return type
     */
    public function getUrl() {
      return $this->protocol . '://' . $this->hostName . $this->baseUrl;
    }

    public function getBaseUrl() {
      return $this->baseUrl;
    }

    public function getRequestUrl() {
      return $this->requestUrl;
    }

    public function getAbsoluteRequestUrl() {
      return $this->getUrl() . $this->requestUrl;
    }

    public function getRequestPath() {
      return $this->requestPath;
    }

    public function getRoute() {
      return $this->_route;
    }

    public function getHostName() {
      return $this->hostName;
    }

    public function redirect($url = false, $code = 302) {
      if (empty($url) and !empty($_SERVER['HTTP_REFERER'])) {
        $url = $_SERVER['HTTP_REFERER'];
      }

      if (empty($url)) {
        throw new \Exception('Url can not be empty');
      }

      header('Location: ' . $url);
      die();
    }

    public function redirectToRoute($route, $params = array(), $code = null) {
      $url = $this->create($route, $params);
      $this->redirect($url, $code);
    }

  }