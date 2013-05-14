<div class="full-post">


  <div class="full-post-content">
    <p>
      <?= $message ?>
    </p>

    <p>
      Перейти наза:
      <a href="<?= $post->getViewUrl() ?>" rel="bookmark" title="<?php echo $post->title ?>">
        <?php echo $post->title ?>
      </a>
    </p>
  </div>


</div>