<?php
  namespace Uc;

  class Widget extends Module {

    protected $data = array();

    protected $options = array();


    /**
     * View file located near class file
     *
     * @return string
     */
    protected function getClassViewFile() {

    }

    /**
     * View file located in theme folder
     *
     * @return string
     */
    protected function getViewFile() {

    }


    public function setData($data) {
      $this->data = $data;
    }

    public function getData() {
      return $this->data;
    }

    public function setOptions($options) {
      $this->options = $options;
    }

    public function getOptions() {
      return $this->options;
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function show() {
      $this->beforeShow();

      if ($classViewFile = $this->getClassViewFile()) {
        $content = $this->renderViewPartial($classViewFile, $this->data);
      } elseif ($themeViewFile = $this->getViewFile()) {
        $content = $this->renderPartial($themeViewFile, $this->data);
      } else {
        throw new \Exception('Please provide view file');
      }

      $this->afterShow();

      return $content;
    }

    protected function beforeShow() {

    }

    protected function afterShow() {

    }

    public static function run($data = array(), $options = array()) {
      $class = get_called_class();
      /** @var $widget \Uc\Widget */
      $widget = new $class();
      $widget->setData($data);
      $widget->setOptions($options);
      return $widget->show($data, $options);
    }

  }