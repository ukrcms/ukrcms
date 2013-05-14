<div class="full_w">
  <div class="h_title">
    <?php if (!empty($item->id)) { ?>
      Відредагувати
    <?php } else { ?>
      Додати
    <?php } ?>

    категорію
  </div>
  <form action="" method="post">

    <div class="element">
      <label for="title">Заголовок <span class="red">(обов'язково)</span></label>
      <input id="title" name="data[title]" class="text" value="<?= $model->title ?>" required/>
    </div>

    <div class="element">
      <label for="sef">Посилання <span class="red">(обов'язково)</span></label>
      <input id="sef" name="data[sef]" class="text" value="<?= $model->sef ?>" required/>
    </div>

    <div class="element">
      <label for="description">Опис категорії</label>
      <textarea id="description" name="data[description]" class="textarea" rows="10"><?= $model->description ?></textarea>
    </div>

    <div class="entry"></div>

    <div class="element">
      <label for="meta_description">SEO опис</label>
      <textarea id="meta_description" name="data[meta_description]" class="textarea" rows="10"><?= $model->meta_description ?></textarea>
    </div>

    <div class="element">
      <label for="meta_keywords">SEO Ключові слова</label>
      <textarea id="meta_keywords" name="data[meta_keywords]" class="textarea" rows="10"><?= $model->meta_keywords ?></textarea>
    </div>


    <div class="element">
      <label for="published">Показувати на сайті</label>
      <label>
        <input type="radio" name="data[status]" value="<?= \Ub\Simpleblog\Categories\Model::STATUS_ENABLED ?>" <?= $model->status == \Ub\Simpleblog\Categories\Model::STATUS_ENABLED ? 'checked="checked"' : '' ?> />
        Так
      </label>
      <label>
        <input type="radio" name="data[status]" value="<?= \Ub\Simpleblog\Categories\Model::STATUS_DISABLED ?>" <?= $model->status == \Ub\Simpleblog\Categories\Model::STATUS_DISABLED ? 'checked="checked"' : '' ?> />
        Ні
      </label>
    </div>


    <div class="entry">
      <button type="submit" name="save_and_list" class="add">Зберегти</button>
      <button type="submit" name="save_and_stay" class="add">Зберегти і продовжити</button>
    </div>
  </form>
</div>