<?php

  $allCommentsStatuses = \Ub\Simpleblog\Comments\Model::getStatusDescription();
  $listRoute = \Uc::app()->url->getControllerName() . '/list';
  $statusRequest = (isset($_GET['-w-status']) and array_key_exists($_GET['-w-status'], $allCommentsStatuses)) ? $_GET['-w-status'] : null;

?>

  <div class="full_w">
    <div class="entry filter-link">
      <a href="<?= \Uc::app()->url->create($listRoute) ?>" class="<?= $statusRequest === null ? 'current' : '' ?>">Усі</a>
      <?php foreach (\Ub\Simpleblog\Comments\Model::getStatusDescription() as $status => $statusName) { ?>
        <a href="<?= \Uc::app()->url->create($listRoute, array('-w-status' => $status)) ?>" class="<?= $statusRequest === $status ? 'current' : '' ?>"><?= $statusName ?></a>
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
  echo $widget->render();