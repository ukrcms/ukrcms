<?php

  /**
   * @package Uc
   * @author  Ivan Shcherbak <dev@funivan.com>
   */
  namespace Uc;

  class Module extends Component {

    public function __construct() {
      $this->init();
    }

    /**
     * Render file from theme with layout
     *
     * @param string $file
     * @param array  $data
     */
    public function render($file, $data = array()) {
      $content = $this->renderPartial($file, $data);
      echo $this->renderLayout($content);
    }

    /**
     * Render file from theme without layout
     *
     * <code>
     * $this->renderPartial('/test/custom')
     * </code>
     * <code>
     * $this->renderPartial('custom')
     * </code>
     *
     * @param       $file
     * @param array $data
     * @return string
     */
    public function renderPartial($file, $data = array()) {
      $moduleViewFile = $this->getThemeViewFilePath($file);
      return $this->renderFile($moduleViewFile, $data);
    }

    /**
     * @param string $file
     * @return string
     */
    public function getThemeViewFilePath($file) {
      if ($file[0] != DIRECTORY_SEPARATOR) {
        $shortClassName = preg_replace('!^(.*)\\\([^\\\]+)$!', '$1', get_class($this));
        $partialFilePath =
          DIRECTORY_SEPARATOR
          . str_replace('\\', DIRECTORY_SEPARATOR, strtolower($shortClassName))
          . DIRECTORY_SEPARATOR . $file;
        $partialFilePath = $partialFilePath;
      } else {
        $partialFilePath = $file;
      }

      $moduleViewFile = \Uc::app()->theme->getViewFilePath($partialFilePath);
      $moduleViewFile = \Uc::app()->theme->getAbsoluteFilePath($moduleViewFile);
      return $moduleViewFile;
    }


    /**
     * Render file from view folder with layout
     * Helper function for rendering files from bundles view folder
     *
     * @param string $file
     * @param array  $data
     */
    public function renderView($file, $data = array()) {
      $content = $this->renderViewPartial($file, $data);
      echo $this->renderLayout($content);
    }


    /**
     * Render file from view without layout
     *
     * @param string $file
     * @param array  $data
     * @return string
     */
    public function renderViewPartial($file, $data = array()) {
      $file = $this->getClassViewFilePath($file);
      return $this->renderFile($file, $data);
    }

    public function getClassViewFilePath($file) {
      $object = new \ReflectionObject($this);
      $file = dirname($object->getFilename())
        . DIRECTORY_SEPARATOR
        . \Uc::app()->theme->getViewsDir()
        . DIRECTORY_SEPARATOR
        . trim($file, DIRECTORY_SEPARATOR)
        . \Uc::app()->theme->getTemplateExtension();

      return $file;
    }

    /**
     * Render layout with content
     * Layout name located in theme configuration
     *
     * @param string $content
     */
    public function renderLayout($content) {
      $layoutFile = \Uc::app()->theme->getLayoutFilePath();
      echo $this->renderFile($layoutFile, array('content' => $content));
    }

    /**
     * Render file by absolute path
     *
     * @param type  $file
     * @param array $data
     * @return string
     */
    public function renderFile($file, $data = array()) {
      $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
      if (is_array($data)) {
        extract($data, EXTR_OVERWRITE);
      }

      ob_start();
      ob_implicit_flush(false);
      include $file;
      return ob_get_clean();
    }


    public function test() {

//    theme          : new
//    class location : protected/bundles/Office/Users/Controller.php
//    controller     : Ub\Office\Users\Controller

//    $this->render('list') >> /theme/new/bundles/ub/office/users/list.php
//    $this->render('/test/list') >> /theme/new/bundles/test/list.php
//
//    $this->renderView('list') >> /protected/bundles/Office/Users/views/list.php
//    $this->renderView('/test/list') >> /protectedOffice/Users/views/test/list.php
//

      # Ub\Office\Users\Widget
      # Ub\Office\Users\TestWidget
//    $this->render('top') >> /theme/new/bundles/ub/office/users/testTop.php
//    $this->render('/test/list') >> /theme/new/bundles/test/list.php
//
//    $this->renderView('list') >> /protected/bundles/office/users/views/list.php
//    $this->renderView('/test/list') >> /protected/bundles/test/views/list.php
//

//      $this->render();
//      $this->renderPartial(); // рендерить файл без лейота  з папки теми
//      $this->renderFile(); //
//
//      $this->renderView(); //  рендерить з папки вю
//      $this->renderViewPartial(); // рендерить файл без лйота з папки вю
//      $this->renderViewFile(); // рендерить файл без лйота з папки вю

    }

  }