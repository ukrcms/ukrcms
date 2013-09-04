<?php

  namespace Uc;

  /**
   * Application class
   *
   * @author  Ivan Scherbak <dev@funivan.com>
   */
  class App extends Component {

    /**
     *
     * @var \Uc\Url
     */
    public $url = null;

    /**
     *
     * @var \Uc\Theme
     */
    public $theme = null;

    /**
     *
     * @var \Uc\Db
     */
    public $db = null;

    /**
     *
     * @var \Uc\User\Identity
     */
    public $userIdentity = null;

    /**
     * Params of application
     *
     * @var array
     */
    public $params = array();

    /**
     *
     * @var \Uc\Controller
     */
    public $controller = null;

    /**
     * Used for more flexible of controller names
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @var string
     */
    private $controllerPrefix = '';

    /**
     * Used for more flexible of controller names
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @var string
     */
    private $controllerPostfix = 'Controller';

    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @var string
     */
    private $actionPrefix = 'action';

    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @var string
     */
    private $actionPostfix = '';

    /**
     * Set config of application
     * Init components
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @param array|\Uc\type $config
     * @return \Uc\App
     */
    public function __construct($config = array()) {

      if (!empty($config['params']) and is_array($config['params'])) {
        $this->params = $config['params'];
      }

      if (!empty($config['components'])) {
        foreach ($config['components'] as $componentName => $options) {
          if (is_array($options) and !empty($options['class'])) {
            $className = $options['class'];
            unset($options['class']);
          } else {
            $className = '\\Uc\\' . ucfirst($componentName);
          }

          $component = new $className();
          # set options
          if (is_array($options)) {
            foreach ($options as $key => $value) {
              $component->$key = $value;
            }
          }

          $component->init();

          $this->$componentName = $component;
        }
      }

      $this->init();

      return $this;
    }

    /**
     * Run Application
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @throws \Exception
     */
    public function run() {
      try {

        # start parse request usin url class
        $controllerName = $this->url->getControllerName();
        $actionName = $this->url->getActionName();

        if (!$controllerName) {
          throw new \Exception('Controller name is empty');
        }

        if (!$actionName) {
          throw new \Exception('Action name is empty');
        }

        # get names of controller and action
        $controllerRealName = $this->getControllerClassName($controllerName);
        $actionRelName = $this->getActionName($actionName);

        $this->controller = new $controllerRealName();

        # validation of action
        if (!is_callable(array($this->controller, $actionRelName))) {
          throw new \Exception('Action #' . $actionRelName . ' in controller #' . $controllerRealName . ' can not be call');
        }

        return $this->controller->$actionRelName();
      } catch (\Exception $exc) {
        # exception handler
        self::showError($exc);
        \Uc::errorHandler($exc); # mail admin about error
      }
      return false;
    }

    public function showError(\Exception $exc) {
      # run custom controller for show error
      if (!empty($this->params) and !empty($this->params['errorHandler'])) {
        $controllerActionName = \Uc::app()->url->getControllerActionFromRoute($this->params['errorHandler']);
        if (!empty($controllerActionName[0]) and !empty($controllerActionName[1])) {
          $controllerClass = $this->getControllerClassName($controllerActionName[0]);
          $actionName = $this->getActionName($controllerActionName[1]);
          $this->controller = new $controllerClass();
          return $this->controller->$actionName($exc);
        }
      }
      return false;
    }

    /**
     *
     * @author   Ivan Scherbak <dev@funivan.com>
     * @param $controllerName
     * @return string
     */
    protected function getControllerClassName($controllerName) {
      $controllerName = implode('\\', array_map("ucfirst", explode('/', $controllerName)));
      return '\\' . $this->controllerPrefix . $controllerName . '\\' . $this->controllerPostfix;
    }

    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @param string $actionName
     * @return string
     */
    protected function getActionName($actionName) {
      return $controllerActionName = $this->actionPrefix . ucfirst($actionName) . $this->actionPostfix;
    }

    /**
     *
     * @param string $controllerClassName
     * @return string
     */
    public function getControllerName($controllerClassName) {
      return preg_replace('!^' . $this->controllerPrefix . '(.*)' . $this->controllerPostfix . '$!', '$1', $controllerClassName);
    }


    public static function getDebugInfo() {
      $runTime = $useMemory = 0;
      if (defined('UC_START_TIME')) {
        $runTime = round(microtime(true) - UC_START_TIME, 5);
      }
      if (defined('UC_START_MEMORY')) {
        $useMemory = round((memory_get_usage() - UC_START_MEMORY) / 1024 / 1024, 5);
      }

      return array(
        $runTime,
        $useMemory,
      );
    }
  }