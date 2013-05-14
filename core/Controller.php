<?php

  namespace Uc;

  /**
   *
   * @package Uc
   * @author  Ivan Scherbak <dev@funivan.com>
   */
  class Controller {

    /**
     * @param string         $file
     * @param array|\Uc\type $data
     */
    public function render($file, $data = array()) {
      # render module view file
      $content = $this->renderPartial($file, $data);

      # render layout
      $layoutFile = \Uc::app()->theme->getLayoutFilePath();
      $layoutFileAbsolute = \Uc::app()->theme->getAbsoluteFilePath($layoutFile);
      echo $this->renderFile($layoutFileAbsolute, array('content' => $content));
    }

    /**
     * @param       $file
     * @param array $data
     * @return string
     */
    public function renderPartial($file, $data = array()) {

      $controllerViewFile = $file;
      if ($controllerViewFile[0] != DIRECTORY_SEPARATOR) {
        $shortControllerName = \Uc::app()->getControllerName(get_class($this));
        $controllerViewFile = DIRECTORY_SEPARATOR . str_replace(array('_', '\\'), DIRECTORY_SEPARATOR, strtolower($shortControllerName)) . DIRECTORY_SEPARATOR . $controllerViewFile;
        $controllerViewFile = \Uc::app()->theme->getModuleFilePath($controllerViewFile);
      } else {
        $controllerViewFile = \Uc::app()->theme->getViewFilePath($controllerViewFile);
      }

      $controllerViewFile = \Uc::app()->theme->getAbsoluteFilePath($controllerViewFile);
      return $this->renderFile($controllerViewFile, $data);
    }

    /**
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

  }