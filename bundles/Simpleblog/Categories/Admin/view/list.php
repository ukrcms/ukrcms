<?php
  $widget = new \Ub\Admin\WidgetCrudList();
  $widget->setData($data);
  $widget->setOptions(array(
    'showFields' => array(
      'title' => 'title',
    ),
    'controllerRoute' => \Uc::app()->url->getControllerName()
  ));
  echo $widget->render();