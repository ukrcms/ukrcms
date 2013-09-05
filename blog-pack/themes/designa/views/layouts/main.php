<!DOCTYPE html>

<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en"> <![endif]-->

<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->

  <head>
    <meta charset="UTF-8">

    <!-- Remove this line if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="viewport" content="width=device-width">

    <meta name="description" content="<?php echo \Uc::app()->theme->getValue('seo_meta_description') ?>">
    <meta name="keywords" content="<?php echo \Uc::app()->theme->getValue('seo_meta_keywords') ?>"/>

    <meta name="author" content="Mykhaylo Tarchan">

    <title><?php echo \Uc::app()->theme->getValue('seo_meta_title') ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="shortcut icon" type="image/png" href="favicon.png">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/style.css">

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
    <!-- Prompt IE 7 users to install Chrome Frame -->
    <!--[if lt IE 8]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to
      a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome
      Frame</a> to experience this site.</p><![endif]-->

    <div class="container">

      <header id="navtop">
        <a href="<?php echo \Uc::app()->url->create('/') ?>" class="logo fleft">
          <img src="<?php echo \Uc::app()->theme->getUrl(); ?>/img/logo.png" alt="<?php echo \Ub\Site\Settings\Table::instance()->get('blogTitle') ?>">
        </a>

        <nav class="fright">
          <?php if ($pages = \Ub\Site\Pages\Table::instance()->getAllFromCache() and !empty($pages)) { ?>
            <ul>
              <?php foreach ($pages as $page) { ?>
                <li><a href="<?php echo $page->getViewUrl() ?>"><?php echo $page->title ?></a></li>
              <?php } ?>
            </ul>
          <?php } ?>
        </nav>
      </header>

      <div class="blog-page main grid-wrap">


        <?php echo $content; ?>

        <aside class="grid col-one-quarter mq2-col-one-third mq3-col-full blog-sidebar">

          <div class="widget">
            <h2>Віджет</h2>

            <p> <?php echo \Ub\Site\Settings\Table::get('slogan') ?> </p>
          </div>
          <div class="widget">
            <h2>Категорії</h2>

            <?php if ($categories = \Ub\Simpleblog\Categories\Table::instance()->getAllFromCache() and !empty($categories)) { ?>
              <ul>
                <?php foreach ($categories as $category) { ?>
                  <li>
                    <a href="<?php echo $category->getViewUrl() ?>">
                      <?php echo $category->title ?>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            <?php } ?>

          </div>

        </aside>
      </div>


      <div class="divide-top">
        <footer class="grid-wrap">
          <ul class="grid col-one-third social">
            <li><a href="#">RSS</a></li>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Google+</a></li>
            <li><a href="#">Flickr</a></li>
          </ul>

          <div class="up grid col-one-third ">
            <a href="#navtop" title="Вверх">&uarr;</a>
          </div>

          <nav class="grid col-one-third ">
            <?php if ($pages = \Ub\Site\Pages\Table::instance()->getAllFromCache() and !empty($pages)) { ?>
              <ul>
                <?php foreach ($pages as $page) { ?>
                  <li><a href="<?php echo $page->getViewUrl() ?>"><?php echo $page->title ?></a></li>
                <?php } ?>
                <?php if ($categories = \Ub\Simpleblog\Categories\Table::instance()->getAllFromCache() and !empty($categories)) { ?>
                  <?php foreach ($categories as $category) { ?>
                    <li><a href="<?php echo $category->getViewUrl() ?>"><?php echo $category->title ?></a></li>
                  <?php } ?>
                <?php } ?>
              </ul>
            <?php } ?>
          </nav>
        </footer>
      </div>

    </div>

    <!-- Javascript - jQuery -->
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery-1.7.2.min.js"><\/script>')</script>

    <!--[if (gte IE 6)&(lte IE 8)]>
    <script src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/selectivizr.js"></script>
    <![endif]-->

    <script src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.flexslider-min.js"></script>
    <script src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/scripts.js"></script>

    <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID. -->
    <script>
      //   var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
      //   (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      //   g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
      //   s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
  </body>
</html>