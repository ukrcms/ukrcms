<?php
  $widget = new \Ub\Admin\WidgetCrudList();
  $widget->setData($data);
  $widget->setOptions(array(
    'showFields' => array(
      'meta_title' => 'meta_title',
      'meta_description' => 'meta_description',
    ),
    'controllerRoute' => \Uc::app()->url->getControllerName()
  ));
  echo $widget->show();