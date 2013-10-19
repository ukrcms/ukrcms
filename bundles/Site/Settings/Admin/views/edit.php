<div class="full_w">

  <form action="" method="post">

    <div class="element">
      <label for="name">Ключ<span class="red">(обов'язково)</span></label>
      <input id="name" name="data[key]" class="text" value="<?php echo $model->key ?>" required/>
    </div>

    <div class="element">
      <label for="sef">Значення <span class="red">(обов'язково)</span></label>
      <input id="sef" name="data[value]" class="text" value="<?php echo $model->value ?>" required/>
    </div>


    <div class="entry">
      <button type="submit" name="save_and_list" class="add">Зберегти</button>
      <button type="submit" name="save_and_stay" class="add">Зберегти і продовжити</button>
    </div>
  </form>
</div>