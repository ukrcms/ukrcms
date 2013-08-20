<?php if (!empty($items)) { ?>
  <?php foreach ($items as $post) { ?>
    <div class="single-post">

      <div class="single-post-image">
        <a href="<?php echo $post->getViewUrl() ?>" rel="bookmark" title="<?php echo $post->title ?>">
          <?php if (!empty($post->image) and $image = $post->image->main()) { ?>
            <img src="<?php echo $image->getUrl($post->sef) ?>" width="<?php echo $image->getWidth() ?>" height="<?php echo $image->getHeight() ?>" alt="" title=""/>
          <?php } ?>

        </a>
      </div>
      <div class="single-post-text">

        <h2>
          <a href="<?php echo $post->getViewUrl() ?>" rel="bookmark" title="<?php echo $post->title ?>">
            <?php echo $post->title ?>
          </a>
        </h2>

        <div class="single-post-content">
          <?php echo $post->shorttext ?>
        </div>

        <div class="meta">
          Дата публікації: <span><?php echo strftime("%Y-%m-%d %H:%I", $post->date) ?></span><br/>
          <a href="<?php echo $post->getViewUrl() ?>#comment" title="Коментувати статтю <?php echo $post->title ?>">

          </a>
        </div>

      </div>
      <div class="clearfix"></div>

    </div>
  <?php } ?>
  <?php if (!empty($pages) and $pages > 1) { ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
      <?php } ?>
    </div>
  <?php } ?>

<?php } ?>