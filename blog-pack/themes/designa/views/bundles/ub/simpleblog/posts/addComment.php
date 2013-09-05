<header class="grid col-full">
  <hr>
<!--  <p class="fleft">Blog post</p>-->
</header>

<section class="grid col-three-quarters mq2-col-two-thirds mq3-col-full">

  <div class="entry">
    <p>
      <?php echo $message ?>
    </p>

    <p>
      Перейти назад:
      <a href="<?php echo $post->getViewUrl() ?>" rel="bookmark" title="<?php echo $post->title ?>">
        <?php echo $post->title ?>
      </a>
    </p>

  </div>
</section>

