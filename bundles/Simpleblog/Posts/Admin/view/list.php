<?php

$widget = new \Ub\Admin\WidgetCrudList();
$widget->setData($data);
$widget->setOptions(array(
  'hideTitle' => true,
  'showFields' => array(
    'name' => 'title',
  ),
  'controllerRoute' => \Uc::app()->url->getControllerName()
));

echo $widget->render();

?>
<div class="entry" style="text-align: center;">
  <?php foreach (array(30, 50, 100, 500) as $onPage) { ?>
    <a
      href="<?= \Uc::app()->url->create(\Uc::app()->url->getRoute(), array('onPage' => $onPage, 'page' => 1)) ?>"
      class="<?php echo (!empty($_GET['onPage']) and $onPage == $_GET['onPage']) ? 'current' : '' ?>"
      ><?php echo $onPage  ?></a>&nbsp;
  <?php } ?>
</div>