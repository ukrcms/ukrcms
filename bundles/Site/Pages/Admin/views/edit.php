<div class="full_w">

  <?php if ($model->stored()) { ?>
    <div class="entry" style="text-align: center;">
      <a href="<?php echo $model->getViewUrl() ?>" target="_blank">Переглянути на сайті</a>
    </div>
  <?php } ?>

  <form action="" method="post">

    <div class="element">
      <label for="title">Заголовок<span class="red">(обов'язково)</span></label>
      <input id="title" name="data[title]" class="text" value="<?php echo $model->title ?>" required/>
    </div>

    <div class="element">
      <label for="sef">sef <span class="red">(обов'язково)</span></label>
      <input id="sef" name="data[sef]" class="text" value="<?php echo $model->sef ?>" required/>
    </div>

    <div class="element">
      <label for="description">Текст</label>
      <textarea id="description" name="data[text]" class="textarea cleditor" rows="10"><?php echo $model->text ?></textarea>
    </div>


    <div class="entry"></div>

    <div class="element">
      <label for="meta_description">Meta Desctiption</label>
      <textarea id="meta_description" name="data[meta_description]" class="textarea" rows="10"><?php echo $model->meta_description ?></textarea>
    </div>

    <div class="element">
      <label for="meta_keywords">Meta Keywords</label>
      <textarea id="meta_keywords" name="data[meta_keywords]" class="textarea" rows="10"><?php echo $model->meta_keywords ?></textarea>
    </div>

    <div class="element">
      <label for="sef">Дизайн </label>
      <input id="sef" name="data[template]" class="text" value="<?php echo $model->template ?>"/>
    </div>


    <div class="element">
      <label for="published">Опублікована</label>
      <label>
        <input type="radio" name="data[published]" value="1" <?php echo \Ub\Site\Pages\Model::STATUS_PUBLISHED == $model->published ? 'checked = "checked"' : '' ?> />
        Так
      </label>
      <label>
        <input type="radio" name="data[published]" value="0" <?php echo \Ub\Site\Pages\Model::STATUS_DRAFT == $model->published ? 'checked = "checked"' : '' ?>/>
        Ні
      </label>
    </div>

    <div class="entry">
      <button type="submit" name="save_and_list" class="add">Зберегти</button>
      <button type="submit" name="save_and_stay" class="add">Зберегти і продовжити</button>
    </div>
  </form>
</div>