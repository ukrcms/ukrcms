<div class="full-post">

  <h2 class="full-post-title">
    <?= $model->title ?>
  </h2>

  <div class="meta-full-post">
    Дата публікації: <span><?php echo strftime("%Y-%m-%d %H:%I", $model->date) ?></span><br/>
  </div>
  <!--meta-->

  <div class="full-post-content"><p>
      <?php if (!empty($model->image) and $image = $model->image->main()) { ?>
        <a href="<?= $image->getUrl($model->sef) ?>" target="_blank" title="<?= $model->title ?>" class="alignnone size-full wp-image-37">
          <img src="<?= $image->getUrl($model->sef) ?>" width="<?= $image->getWidth() ?>" height="<?= $image->getHeight() ?>" alt="<?= $model->sef ?>" title="<?= $model->title ?>"/>
        </a>
      <?php } ?>
    </p>

    <?= $model->shorttext ?>

    <?= $model->text ?>
  </div>

  <div class="full-post-pages"></div>


  <div class="clearfix"></div>


  <div id="comments-wrap">
    <?php $comments = $model->comments(); ?>
    <?php if ($commentsNum = count($comments) and $commentsNum > 0) { ?>

      <h3 id="comments-number">Коментарів: (<?= $commentsNum ?>)</h3>


      <ol class="commentlist">
        <?php foreach ($comments as $commentItem) { ?>

          <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1">
            <div class="comment-body" id="div-comment-6">
              <div class="comment-author vcard">
                <img class="avatar" alt="<?= $commentItem->name ?>" src="http://www.gravatar.com/avatar/<?= md5(strtolower(trim($commentItem->email))) ?>?s=50&d=wavatar" width="50" height="50"/>
                <cite class="fn"><?php echo $commentItem->name ?></cite>
              </div>

              <div class="comment-meta commentmetadata">
                <a href="http://azmind.com/wp-themes-demo3/2012/03/04/a-post-with-headings/#comment-6">
                  <?php echo strftime('%Y-%m-%d %H:%I', $commentItem->time) ?></a></div>
              <p><?= $commentItem->getCommentHtml(); ?></p>

              <div class="reply">
                <a href="#comment" class="comment-reply-link">Відповісти</a>
              </div>
            </div>
          </li>


        <?php } ?>
      </ol>

    <?php } ?>



    <div id="comment">

      <h3 class="postcomment">Коментувати</h3>

      <form id="commentform" method="post" action="?addcomment">

        <p>
          <input type="text" tabindex="1" size="28" value="" class="textarea" id="author" name="comment[name]">
          * <label for="author">Імя</label></p>

        <p>
          <input type="text" class="textarea" tabindex="2" size="28" value="" id="email" name="comment[email]">
          * <label for="email">E-mail</label></p>

        <p>
          <input type="text" class="textarea" tabindex="3" size="28" value="" id="url" name="comment[url]">
          <label for="url"><acronym title="Uniform Resource Identifier">URL</acronym></label>
        </p>

        <p>
          <textarea class="textarea" tabindex="4" rows="10" cols="60" id="comment" name="comment[comment]"></textarea>
        </p>

        <p>
          <input type="submit" class="cbutton" value="Додати коментар" tabindex="5" id="submit" name="submit">
        </p>

      </form>
    </div>
  </div>

</div>