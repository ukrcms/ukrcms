<?php
  namespace Ub\Admin;

  /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
  class WidgetCrudList extends \Uc\Widget {

    protected $options = array(
      'controllerRoute' => null,
      'editRoute' => null,
      'addRoute' => null,
      'deleteRoute' => null,
      'showFields' => array(),
    );

    public function getViewFile() {
      return 'widgetCrudList';
    }

    protected function beforeRender() {
      if (empty($this->options['showFields'])) {
        throw new \Exception('Please set ->options[showFields]');
      }
      parent::beforeRender();
    }


    public function getEditRoute() {
      if (!empty($this->options['editRoute'])) {
        return $this->options['editRoute'];
      } else {
        return $this->options['controllerRoute'] . '/edit';
      }
    }

    public function getAddRoute() {
      if (array_key_exists('addRoute', $this->options) and $this->options['addRoute'] === false) {
        return false;
      } elseif (!empty($this->options['addRoute'])) {
        return $this->options['addRoute'];
      } else {
        return $this->getEditRoute();
      }
    }

    public function getDeleteRoute() {
      if (!empty($this->options['deleteRoute'])) {
        return $this->options['deleteRoute'];
      } else {
        return $this->options['controllerRoute'] . '/delete';
      }
    }

  }