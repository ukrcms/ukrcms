<div class="full_w">
  <div class="entry ">

    <?php if (!empty($items)) { ?>
      <table>
        <thead>
        <tr>
          <?php
            $editRoute = $this->getEditRoute();
            $deleteRoute = $this->getDeleteRoute();
          ?>
          <?php foreach ($this->options['showFields'] as $fieldName => $property) { ?>
            <th scope="col"><?php echo $fieldName ?></th>
          <?php } ?>
          <?php if (!empty($editRoute) or !empty($deleteRoute)) { ?>
            <th scope="col" style="width: 45px;">Редагувати</th>
          <?php } ?>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($items as $item) { ?>
          <tr>
            <?php foreach ($this->options['showFields'] as $fieldName => $property) { ?>
              <td>
                <?php echo $item->$property ?>
              </td>
            <?php } ?>
            <td>
              <a href="<?= \Uc::app()->url->create($editRoute, array('pk' => $item->pk())) ?>" class="table-icon edit" title="Редагувати"></a>
              <a href="<?= \Uc::app()->url->create($deleteRoute, array('pk' => $item->pk())) ?>" class="table-icon delete confirm" title="Видалити"></a>
            </td>
          </tr>
        <? } ?>

        </tbody>
      </table>
      <div class="entry">
        <?php
          echo \Ub\Admin\WidgetPaginator::show(array(
            'page' => $page,
            'pages' => $pages,
          ));
        ?>
        <div class="sep"></div>
      </div>

    <?php } else { ?>
      <div class="entry">
        Немає даних.
      </div>
    <?php } ?>
    <?php if ($addRoute = $this->getAddRoute() and !empty($addRoute)) { ?>
      <div class="entry">
        <a class="button add" href="<?= \Uc::app()->url->create($addRoute) ?>">Додати</a>
      </div>
    <?php } ?>
  </div>