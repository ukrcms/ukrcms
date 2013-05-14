<?php
  namespace Uc;

  abstract class Widget {

    protected $data = array();

    protected $options = array();

    abstract protected function getViewFile();

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


    public function render() {
      $this->beforeRender();

      extract($this->data);

      $file = $this->getFullViewPath($this->getViewFile());

      ob_start();
      ob_implicit_flush(false);
      include $file;
      $content = ob_get_clean();
      $this->afterRender();
      return $content;
    }

    protected function beforeRender() {

    }

    protected function afterRender() {

    }

    public static function show($data = array(), $options = array()) {
      $class = get_called_class();
      /** @var $widget \Uc\Widget */
      $widget = new $class();
      $widget->setData($data);
      $widget->setOptions($options);
      return $widget->render($data, $options);
    }

    public function getFullViewPath($widgetViewFile) {
      $controllerViewFile = 'view' . DIRECTORY_SEPARATOR . $widgetViewFile;
      $object = new \ReflectionObject($this);
      $file = dirname($object->getFilename()) . DIRECTORY_SEPARATOR . $controllerViewFile . '.php';
      return $file;
    }

  }