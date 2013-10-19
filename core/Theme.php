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
    public $layout = null;

    /**
     *
     * @var string
     */
    public $basePath = null;

    /**
     *
     * @var string
     */
    public $baseUrl = null;

    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @var string
     */
    public $themeName = null;

    /**
     * @var string
     */
    public $viewsDir = 'views';

    /**
     * @var string
     */
    public $templateExtension = '.php';

    /**
     * @var array
     */
    protected $values = array();

    public function __toString() {
      return $this->themeName;
    }

    /**
     * Get path to view file from theme
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @param string $file
     * @return string
     */
    public function getViewFilePath($file) {
      $file = DIRECTORY_SEPARATOR . $this->viewsDir . DIRECTORY_SEPARATOR . 'bundles' . DIRECTORY_SEPARATOR . trim($file, DIRECTORY_SEPARATOR) . $this->templateExtension;
      return $file;
    }

    /**
     * Get path to layout file
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @return string
     */
    public function getLayoutFilePath() {
      $file = '/' . $this->viewsDir . '/layouts/' . $this->layout . $this->templateExtension;
      $file = \Uc::app()->theme->getAbsoluteFilePath($file);
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
      return $this->basePath . DIRECTORY_SEPARATOR . $this->themeName . DIRECTORY_SEPARATOR . trim($file, DIRECTORY_SEPARATOR);
    }

    public function getUrl() {
      return \Uc::app()->url->getBaseUrl() . $this->baseUrl . '/' . $this->themeName;
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

    /**
     * @return string
     */
    public function getViewsDir() {
      return $this->viewsDir;
    }

    /**
     * @return string
     */
    public function getTemplateExtension() {
      return $this->templateExtension;
    }

  }