<header class="grid col-full"><hr></hr><p class="fleft">
<!--    Blog post-->
  </p></header>
<section class="grid col-three-quarters mq2-col-two-thirds mq3-col-full">
<article class="post post-single">

  <h2 class="post-title">
    <a><?php echo $model->title ?></a>
  </h2>

  <div class="meta">
    Дата публікації: <span><?php echo strftime("%Y-%m-%d %H:%I", $model->date) ?></span><br/>
  </div>

  <div class="entry">
    <p>
      <?php if (!empty($model->image) and $image = $model->image->main()) { ?>
        <a href="<?php echo $image->getUrl($model->sef) ?>" target="_blank" title="<?php echo $model->title ?>" class="alignnone size-full wp-image-37">
          <img src="<?php echo $image->getUrl($model->sef) ?>" width="<?php echo $image->getWidth() ?>" height="<?php echo $image->getHeight() ?>" alt="<?php echo $model->sef ?>" title="<?php echo $model->title ?>"/>
        </a>
      <?php } ?>
    </p>

    <p><?php echo $model->shorttext ?>
      <?php echo $model->text ?></p>
  </div>

  <?php $comments = $model->comments(); ?>
  <?php if ($commentsNum = count($comments) and $commentsNum > 0) { ?>

  <section class="section-comment">
    <header>
      <hr>
      <h5 class="fleft">Коментарів: <?php echo $commentsNum ?> </h5>
      <p class="fright"><a href="#leavecomment" class="arrow">Залиште свій коментар</a></p>
    </header>
    <ol class="comments">
      <?php foreach ($comments as $commentItem) { ?>
      <li class="comment">
        <img class="avatar" alt="<?php echo $commentItem->name ?>" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($commentItem->email))) ?>?s=50&d=wavatar" width="50" height="50"/>
        <h6><?php echo $commentItem->name ?> <span class="meta"><?php echo strftime('%Y-%m-%d %H:%I', $commentItem->time) ?></span></h6>
        <p><?php echo $commentItem->getCommentHtml(); ?></p>
      </li>
      <?php } ?>
    </ol>
  </section>
  <?php } ?>

    <div class="leavecomment" id="leavecomment">

      <h3>Коментувати</h3>

      <form id="commentform" method="post" action="?addcomment">
        <ul>
          <li>
            <label for="author">Ім'я: </label>
            <input type="text" tabindex="1" size="28" value="" name="name"  required placeholder="Ваше ім'я" class="required" id="author" name="comment[name]">
          </li>

          <li>
            <label for="email">E-mail: </label>
            <input type="email" tabindex="2" size="28" value="" required placeholder="user@gmail.com" class="required email" id="email" name="comment[email]">
          </li>

          <li>
            <label for="url"><acronym title="Uniform Resource Identifier">URL</acronym></label>
            <input type="text" tabindex="3" size="28" value="" name="text" id="url" placeholder="www.site.com" name="comment[url]">
          </li>

          <li>
            <label for="message">Повідомлення:</label>
            <textarea tabindex="4" id="comment" cols="5" rows="3" required  class="required" name="comment[comment]"></textarea>
          </li>
          <li>
            <button type="submit" id="submit" class="button fright">Відіслати</button>
          </li>
        </ul>

      </form>
    </div>


</article>
</section>