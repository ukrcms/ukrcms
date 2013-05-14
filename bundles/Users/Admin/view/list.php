<?php
  $widget = new \Ub\Admin\WidgetCrudList();
  $widget->setData($data);
  $widget->setOptions(array(
    'showFields' => array(
      'Логін' => 'login',
      'Ім\'я' => 'name',
    ),
    'controllerRoute' => \Uc::app()->url->getControllerName()
  ));
  echo $widget->render();