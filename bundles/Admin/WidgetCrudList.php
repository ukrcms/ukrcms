<?php
  namespace Ub\Admin;

  /**
   * Class WidgetCrudList
   * You can use callback in showFields
   * <code>
   * 'title' => function ($model) {
   *   return 'custom-text - ' . $model->title;
   * },
   * </code>
   * @package Ub\Admin
   */
  class WidgetCrudList extends \Uc\Widget {

    protected $options = array(
      'controllerRoute' => null,
      'editRoute' => null,
      'addRoute' => null,
      'deleteRoute' => null,
      'showFields' => array(),
    );

    public function getClassViewFile() {
      return 'widgetCrudList';
    }

    protected function beforeShow() {
      if (empty($this->options['showFields'])) {
        throw new \Exception('Please set ->options[showFields]');
      }
      parent::beforeShow();
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