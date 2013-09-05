<header class="grid col-full" xmlns="http://www.w3.org/1999/html">
    <hr>
<!--    <p class="fleft">Блог</p>-->
  </header>
<section class="grid col-three-quarters mq2-col-two-thirds mq3-col-full">
<?php if (!empty($items)) { ?>
  <?php foreach ($items as $post) { ?>
    <article class="post-title">
      <h2><a href="<?php echo $post->getViewUrl() ?>" class="post-title"><?php echo $post->title ?></a></h2>

      <div class="meta">
        Дата публікації: <span class="time"><?php echo strftime("%Y-%m-%d %H:%I", $post->date) ?></span><br/>
      </div>

          <?php if (!empty($post->image) and $image = $post->image->main()) { ?>
            <img src="<?php echo $image->getUrl($post->sef) ?>" width="<?php echo $image->getWidth() ?>" height="<?php echo $image->getHeight() ?>" alt="" title=""/>
          <?php } ?>

        <div class="entry">
          <p><?php echo $post->shorttext ?></p>
        </div>

      <footer>
        <a href="<?php echo $post->getViewUrl() ?>" class="more-link">Читати.…</a>
      </footer>

    </article>

  <?php } ?>

  <?php if (!empty($pages) and $pages > 1) { ?>
  <ul class="page-numbers">

      <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <li >
<!--          <a href="--><?php //echo $i ?><!--" class="current" >--><?php //echo $i ?><!--</a>-->
        <a href="<?php echo $i ?>" class="current" ><?php echo $i ?></a>
        </li>
      <?php } ?>
  </ul>
  <?php } ?>
<?php } ?>
</section>
