<?php

  /**
   * Container Class of Application
   *
   * require_once dirname(__FILE__) . '/lib/Uc.php';
   * Uc::init();
   *
   * @author  Ivan Scherbak <dev@funivan.com>
   */
  class Uc {

    /**
     * @var array
     */
    private static $classMap = array();

    /**
     * @author  Ivan Scherbak <dev@funivan.com>
     * @var \Uc\App
     */
    private static $app = null;

    public static $siteDirectory = '';

    public static function registerAutoloader($classMap) {
      self::$classMap = $classMap;
      spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @param string $appName
     * @param array  $config
     * @return \Uc\App
     */
    public static function initApp($appName, $config = array()) {
      register_shutdown_function(array(__CLASS__, 'errorHandler'));
      set_error_handler(array(__CLASS__, 'errorHandler'));

      self::$app = new $appName($config);
      return self::$app;
    }

    /**
     * @author  Ivan Scherbak <dev@funivan.com>
     * @return \Uc\App
     */
    public static function app() {
      return self::$app;
    }


    /**
     * Autoload classes
     *
     * @author Ivan Scherbak <dev@funivan.com>
     * @param string $className
     * @return bool
     */
    public static function autoload($className) {

      $classNameInArray = explode('\\', $className);
      $namespace = $classNameInArray[0];

      if (!empty(self::$classMap[$namespace])) {
        unset($classNameInArray[0]);
        $file = self::$classMap[$namespace] . DIRECTORY_SEPARATOR
          . implode(DIRECTORY_SEPARATOR, $classNameInArray)
          . '.php';

        include_once $file;
        return true;
      }

      return false;
    }

    /**
     * Error handler
     *
     * @param bool|\type   $type $type
     * @param string|\type $message
     * @param string|\type $file
     * @param string|\type $line
     * @return boolean
     */
    public static function errorHandler($type = false, $message = '', $file = '', $line = '') {
      $error = error_get_last();
      if ($type === false and empty($error)) {
        return true;
      }
      $showErrors = ini_get('display_errors');
      if (empty($showErrors)) {
        echo 'Errors. We fix it right now.';
      } else {
        if (is_object($type)) {

          echo $type->getMessage() . "\n";
          echo $type->getTraceAsString();
          die();
        }

        if (empty($error)) {
          $error = array(
            'type' => $type,
            'message' => $message,
            'file' => $file,
            'line' => $line,
          );
        }

        $log = "Error: "
          . $error['message']
          . " in "
          . $error['file']
          . "#" . $error['line']
          . "\n<br><br>"
          . "Stack trace: \n";

        $trace = debug_backtrace();

        foreach ($trace as $i => $t) {
          if ($i == 0) {
            continue;
          }
          if (!isset($t['file'])) {
            $t['file'] = 'unknown';
          }

          if (!isset($t['line'])) {
            $t['line'] = 0;
          }

          if (isset($t['object']) && is_object($t['object']) and !empty($t['function'])) {
            $t['function'] = get_class($t['object']) . '->' . $t['function'] . '';
          } elseif (empty($t['function'])) {
            $t['function'] = 'unknown';
          }

          $log .= "<br /><b>" . basename($t['file']) . "</b> "
            . " <font color='red'>" . $t['line'] . "</font>"
            . " <font color='green'>" . $t['function'] . "()</font>"
            . "  -- "
            . $t['file']
            . ";";
        }
        echo $log;
      }

      die();
    }
  }