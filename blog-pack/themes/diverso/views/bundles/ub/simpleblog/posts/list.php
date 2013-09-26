<?php if (!empty($items)) { ?>
  <?php foreach ($items as $post) { ?>
    <div class="hentry hentry-post group blog-big">


      <div class="thumbnail">
        <?php if (!empty($post->image) and $image = $post->image->main()) { ?>
          <img width="640" height="295" class="aligncenter wp-post-image" title="glasses" alt="glasses" src="<?php echo $image->getUrl($post->sef) ?>">
        <?php } ?>
        <h2>
          <a href="<?php echo $post->getViewUrl() ?>"><?php echo $post->title ?></a>
        </h2>

        <p class="date">
          <span class="month"><?php echo strftime("%b", $post->date) ?></span>
          <span class="day"><?php echo strftime("%d", $post->date) ?></span>
        </p>
      </div>
      <div class="meta group">

        <?php $comments = $post->comments(); ?>
        <p class="categories">
          <span>Категорія - <?php echo $post->category->title; ?></span>
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
        <?php echo $post->shorttext; ?>
        <p><a class="more-link" href="<?php echo $post->getViewUrl() ?>">Читати далі...</a></p>
      </div>
    </div>
  <?php } ?>

  <?php if (!empty($pages) and $pages > 1) { ?>
    <div class="general-pagination group">
      <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
      <?php } ?>
    </div>
  <?php } ?>

<?php } ?>