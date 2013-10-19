<div class="full_w">
  <form action="" method="post">

    <div class="element">
      <label for="name">Логін <span class="red">(обов'язково)</span></label>
      <input id="name" name="data[login]" class="text" value="<?php echo $model->login ?>" required/>
    </div>
    <div class="element">
      <label for="name">Імя </label>
      <input id="name" name="data[name]" class="text" value="<?php echo $model->name ?>"/>
    </div>


    <div class="element">
      <label for="name">Новий пароль</label>
      <input id="name" name="newPassword" class="text" type="password" value=""/>
    </div>


    <div class="entry">
      <button type="submit" name="save_and_list" class="add">Зберегти</button>
      <button type="submit" name="save_and_stay" class="add">Зберегти і продовжити</button>
    </div>
  </form>
</div>