<div class="hentry hentry-post group blog-big">
  <div class="thumbnail">
    <?php if (!empty($model->image) and $image = $model->image->main()) { ?>
      <img width="640" height="295" class="aligncenter wp-post-image" title="glasses" alt="glasses" src="<?php echo $image->getUrl($model->sef) ?>">
    <?php } ?>
    <h2>
      <a><?php echo $model->title ?></a>
    </h2>

    <p class="date">
      <span class="month"><?php echo strftime("%b", $model->date) ?></span>
      <span class="day"><?php echo strftime("%d", $model->date) ?></span>
    </p>
  </div>


  <div class="meta group">
    <?php $comments = $model->comments(); ?>
    <p class="categories">
      <span>Категорія - <?php echo $model->category->title; ?></span>
    </p>

    <p class="comments">
      <?php if ($commentsNum = count($comments) and $commentsNum > 0) { ?>
        <span> Коментарів - <?php echo $commentsNum; ?></span>
      <?php } else { ?>
        <span> Без коментарів</span>
      <?php } ?>
    </p>
  </div>

  <div class="the-content">
    <?php echo $model->shorttext; ?>
    <?php echo $model->text; ?>
  </div>

  <div id="comments">

    <h3 id="comments-title">
      <?php if ($commentsNum = count($comments) and $commentsNum > 0) { ?>
        <span><?php echo $commentsNum; ?> Коментар(ів)</span>
      <?php } else { ?>
        <span>Без коментарів</span>
      <?php } ?>
    </h3>


  <ol class="commentlist group">
    <?php foreach ($comments as $commentItem) { ?>

      <li id="li-comment-<?php echo $commentItem->id;?>" class="comment even thread-even depth-1">
        <div id="comment-<?php echo $commentItem->id;?>" class="comment-container">

          <div class="comment-author vcard">
            <div class="sphere">
              <img class="avatar avatar-75 photo" width="75" height="75" alt="<?php echo $commentItem->name ?>" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($commentItem->email))) ?>">
            </div>
            <cite class="fn">
              <a class="url"><?php echo $commentItem->name ?></a>
              </cite>
          </div>
          <div class="comment-meta commentmetadata">
            <div class="intro">
              <div class="commentdate">
                <a href="<?php echo $model->getViewUrl()."#comment-".$commentItem->id;?>"><?php echo strftime("%e/%m/%Y, %k:%M", $commentItem->time)?></a>
              </div>
              <div class="commentNumber">#<?php echo $commentItem->id;?></div>

            </div>
            <div class="comment-body">
              <p><?php echo $commentItem->getCommentHtml(); ?></p>
            </div>
            <div class="reply group">
              <a class="comment-reply-link" href="<?php echo $model->getViewUrl()."#respond"?>">Відповісти</a>
            </div>
          </div>
        </div>
      </li>
    <?php } ?>
  </ol>
   <div id="respond">
     <h3 id="reply-title">Залишити
        <span>коментар</span>
       <small>
         <a id="cancel-comment-reply-link" style="display:none;" href="<?php echo $model->getViewUrl()."#respond"?>" rel="nofollow">Скасувати коментар</a>
       </small>
     </h3>


     <form id="commentform" method="post" action="?addcomment">
       <p class="comment-form-author">
         <label for="author">Ім'я</label>
         <input id="author" type="text" aria-required="true" size="30" value="" required  name="comment[name]">
       </p>
       <p class="comment-form-email">
         <label for="email">E-mail</label>
         <input id="email-form" class="required email-validate error icon" type="text" size="30" value="" required  name="comment[email]">
       </p>
       <p class="comment-form-url">
         <label for="url">Url</label>
         <input id="url" type="text" size="30" value="" name="comment[url]">
       </p>
       <p class="comment-form-comment">
         <label for="comment">Коментар</label>
         <textarea id="comment" rows="8" cols="45" required  class="required" name="comment[comment]"></textarea>
       </p>
       <div class="clear"></div>
       <p class="form-submit">
         <input id="submit" type="submit" value="Надіслати" name="submit">
       </p>
     </form>
   </div>
  </div>
</div>
