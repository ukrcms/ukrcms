<div class="full_w">
  <div class="h_title">Редагування</div>
  <?php if ($model->stored()) { ?>
    <div class="entry" style="text-align: center;">
      <a href="<?php echo $model->getViewUrl() ?>" target="_blank">Переглянути на сайті</a>
    </div>
  <?php } ?>
  <form action="" method="post" enctype="multipart/form-data">

    <div class="element">
      <label for="title">Заголовок <span class="red">(обов'язково)</span></label>
      <input id="title" name="data[title]" class="text" value="<?php echo $model->title ?>" required/>
    </div>

    <div class="element">
      <label for="sef">sef <span class="red">(обов'язково)</span></label>
      <input id="sef" name="data[sef]" class="text" value="<?php echo $model->sef ?>" required/>
    </div>

    <div class="element">
      <label for="category">Категорія<span class="red">(обов'язково)</span></label>
      <?php $categories = \Ub\Simpleblog\Categories\Table::instance()->fetchAll(); ?>
      <select id="category" name="data[category_id]">
        <?php foreach ($categories as $category) { ?>
          <option value="<?php echo $category->pk() ?>" <?php echo $category->pk() == $model->category_id ? 'selected="selected"' : '' ?>><?php echo $category->title ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="element">
      <label for="shorttext">Короткий опис</label>
      <textarea id="shorttext" name="data[shorttext]" class="textarea cleditor" rows="10"><?php echo $model->shorttext ?></textarea>
    </div>

    <div class="element">
      <label for="description">Текст</label>
      <textarea id="description" name="data[text]" class="textarea cleditor" rows="10"><?php echo $model->text ?></textarea>
    </div>

    <div class="element">
      <label for="file">Картинка</label>
      <?php if (!empty($model->image)) { ?>
        <label><input type="checkbox" name="flushImage" value="1">Delete</label><br><br>
        <img src="<?php echo $model->image->small()->getUrl() ?>"><br>
      <?php } ?>
      <input type="file" id="file" name="image">
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
      <label for="published">Публікація</label>
      <label><input type="radio" name="data[published]" value="1" <?php echo $model->published == 1 ? 'checked = "checked"' : '' ?> />
        Yes</label>
      <label><input type="radio" name="data[published]" value="0" <?php echo $model->published == 0 ? 'checked = "checked"' : '' ?>/>
        No</label>
    </div>

    <div class="element">
      <label for="published">Коментарів #<?php echo count($model->Comments) ?></label>
      <?php foreach ($model->comments as $comment) { ?>
        <a href="<?php echo \Uc::app()->url->create('ub/simpleblog/comments/admin/edit', array('pk' => $comment->pk())) ?>" target="_blank">{<?php echo $comment->status ?>
          } <?php echo $comment->name ?></a>
        <br>
      <?php } ?>
    </div>

    <div class="entry">
      <button type="submit" name="save_and_list" class="add">Зберегти</button>
      <button type="submit" name="save_and_stay" class="add">Зберегти і продовжити</button>
    </div>
  </form>
</div>