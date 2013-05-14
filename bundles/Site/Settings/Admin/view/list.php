<?php

  $widget = new \Ub\Admin\WidgetCrudList();
  $widget->setData($data);
  $widget->setOptions(array(
    'showFields' => array(
      'key' => 'key',
      'value' => 'value',
    ),
    'controllerRoute' => \Uc::app()->url->getControllerName()
  ));
  echo $widget->render();