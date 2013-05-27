<?php
  if (empty($pages)) {
    return false;
  }

?>
<div class="pagination">
  <?php for ($i = 1; $i <= $pages; $i++) { ?>
    <?php if ((!empty($page) and $page == $i)) { ?>
      <a href="#<?php echo $i ?>" class="active"><?php echo $i ?></a>
    <?php } else { ?>
      <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
    <?php } ?>
  <?php } ?>
</div>