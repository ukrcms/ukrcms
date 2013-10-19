<?php

  $allCommentsStatuses = \Ub\Simpleblog\Comments\Model::getStatusDescription();
  $listRoute = \Uc::app()->url->getControllerName() . '/list';
  $statusRequest = (isset($_GET['-w-status']) and array_key_exists($_GET['-w-status'], $allCommentsStatuses)) ? $_GET['-w-status'] : null;

?>

  <div class="full_w">
    <div class="entry filter-link">
      <a href="<?php echo \Uc::app()->url->create($listRoute) ?>" class="<?php echo $statusRequest === null ? 'current' : '' ?>">Усі</a>
      <?php foreach (\Ub\Simpleblog\Comments\Model::getStatusDescription() as $status => $statusName) { ?>
        <a href="<?php echo \Uc::app()->url->create($listRoute, array('-w-status' => $status)) ?>" class="<?php echo $statusRequest === $status ? 'current' : '' ?>"><?php echo $statusName ?></a>
      <?php } ?>
      <div class="sep"></div>
    </div>
  </div>

<?php


  $widget = new \Ub\Admin\WidgetCrudList();
  $widget->setData($data);
  $widget->setOptions(array(
    'hideTitle' => true,
    'addRoute' => null,
    'showFields' => array(
      'name' => 'name',
      'comment' => 'comment',
    ),
    'controllerRoute' => \Uc::app()->url->getControllerName()
  ));
  echo $widget->show();