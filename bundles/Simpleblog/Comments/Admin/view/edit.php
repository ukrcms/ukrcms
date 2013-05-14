<div class="full_w">
  <div class="h_title">Редагувати</div>
  <form action="" method="post">

    <div class="element">
      Коментар до статті:
      <?php $post = $model->post(); ?>
      <a href="<?= $post->getViewUrl() ?>" target="_blank"><?= $post->title ?></a>
    </div>
    <div class="element">
      <label for="name">Імя</label>
      <input id="name" name="data[name]" class="text" value="<?= $model->name ?>"/>
    </div>
    <div class="element">
      <label for="name">E-mail</label>
      <input id="name" name="data[email]" class="text" value="<?= $model->email ?>"/>
    </div>

    <div class="element">
      <label for="name">Посилання на сайт</label>
      <input id="name" name="data[url]" class="text" value="<?= $model->url ?>"/>
    </div>

    <div class="element">
      <label for="comment">Коментар</label>
      <textarea id="comment" name="data[comment]" class="textarea" rows="10"><?= $model->comment ?></textarea>
    </div>

    <div class="element">
      <label for="published">Статус</label>
      <?php foreach ($model->getStatusDescription() as $status => $statusName) { ?>
        <label><input type="radio" name="data[status]" value="<?= $status ?>" <?= $model->status == $status ? 'checked="checked"' : '' ?> /> <?= $statusName ?>
        </label>
      <?php } ?>
    </div>

    <div class="entry">
      <button type="submit" name="save_and_list" class="add">Зберегти</button>
      <button type="submit" name="save_and_stay" class="add">Зберегти і продовжити</button>
    </div>
  </form>
</div>