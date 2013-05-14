<?php

  namespace Uc;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Theme extends Component {

    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @var string
     */
    public $layout = '';

    /**
     *
     * @var type
     */
    public $basePath = '';

    /**
     *
     * @var type
     */
    public $baseUrl = '';

    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @var type
     */
    public $themeName = '';


    protected $values = array();

    public function __toString() {
      return $this->themeName;
    }

    public function getViewFilePath($file) {
      $file = DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR) . '.php';
      return $file;
    }

    /**
     * Get path to view file
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @param string $file
     * @return string
     */
    public function getModuleFilePath($file) {
      $file = DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'bundles' . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR) . '.php';
      return $file;
    }

    /**
     * Get path to layout file
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @return string
     */
    public function getLayoutFilePath() {
      $file = '/views/layouts/' . $this->layout . '.php';
      return $file;
    }

    public function getLayout() {
      return $this->layout;
    }

    public function setLayout($layout) {
      $this->layout = $layout;
    }

    public function getThemeName() {
      return $this->themeName;
    }

    public function setThemeName($themeName) {
      $this->themeName = $themeName;
    }

    public function getAbsoluteFilePath($file) {
      return $this->basePath . DIRECTORY_SEPARATOR . $this->themeName . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR);
    }

    public function getUrl() {
      return \Uc::app()->url->getBaseUrl() . $this->baseUrl . DIRECTORY_SEPARATOR . $this->themeName;
    }

    public function getBaseUrl() {
      return $this->baseUrl;
    }


    public function setValue($name, $value) {
      $this->values[$name] = $value;
    }

    public function getValue($name) {
      return isset($this->values[$name]) ? $this->values[$name] : null;
    }

  }