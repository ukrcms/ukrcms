<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" dir="ltr" lang="en-US">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html dir="ltr" lang="en-US">
<!--<![endif]-->
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width"/>

  <meta name="description" content="<?php echo \Uc::app()->theme->getValue('seo_meta_description') ?>">
  <meta name="keywords" content="<?php echo \Uc::app()->theme->getValue('seo_meta_keywords') ?>"/>
  <meta name="author" content="Mykhaylo Tarchan">

  <title><?php echo \Uc::app()->theme->getValue('seo_meta_title') ?></title>

  <link rel="stylesheet" type="text/css" media="all" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/style.css"/>
  <link rel="stylesheet" type="text/css" media="screen and (max-width: 960px)" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/lessthen800.css"/>
  <link rel="stylesheet" type="text/css" media="screen and (max-width: 600px)" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/lessthen600.css"/>
  <link rel="stylesheet" type="text/css" media="screen and (max-width: 480px)" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/lessthen480.css"/>

  <!-- CUSTOM STYLE -->
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/custom-style.css"/>

  <!-- [favicon] begin -->
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
  <link rel="icon" type="image/x-icon" href="favicon.ico"/>
  <!-- [favicon] end -->

  <!-- MAIN FONT STYLE -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz%3A400&amp;subset=latin%2Ccyrillic%2Cgreek" type="text/css" media="all"/>
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans" type="text/css" media="all"/>
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald" type="text/css" media="all"/>
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz%3A200%2C400" type="text/css" media="all"/>
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed%3A300%7CPlayfair+Display%3A400italic" type="text/css" media="all"/>
  <!-- END MAIN FONT STYLE -->

  <link rel="stylesheet" id="prettyPhoto-css" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/prettyPhoto.css" type="text/css" media="all"/>
  <link rel="stylesheet" id="jquery-tipsy-css" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/tipsy.css" type="text/css" media="all"/>

  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.prettyPhoto.js"></script>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.tipsy.js"></script>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.tweetable.js"></script>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.nivo.slider.pack.js"></script>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.flexslider.min.js"></script>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.cycle.min.js"></script>

  <!-- for accordion slider in staff page -->
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.hrzAccordion.js"></script>

  <!-- for filterable effect in gallery and portfolio filterable page -->
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.quicksand.js"></script>

  <!-- for portfolio slider -->
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.jcarousel.min.js"></script>

  <!-- for the contact page -->
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/contact.js"></script>

  <!-- SLIDER ELASTIC -->
  <link rel="stylesheet" id="slider-elastic-css" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/slider-elastic.css" type="text/css" media="all"/>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.eislideshow.js"></script>

  <!-- SLIDER CYCLE -->
  <link rel="stylesheet" id="slider-cycle-css" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/slider-cycle.css" type="text/css" media="all"/>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.slides.min.js"></script>

  <!-- SLIDER THUMBNAILS -->
  <link rel="stylesheet" id="slider-thumbnails-css" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/slider-thumbnails.css" type="text/css" media="all"/>
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.aw-showcase.js"></script>

  <!-- SLIDER FLASH -->
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/swfobject.js"></script>

  <!-- SLIDER ELEGANT -->
  <link rel="stylesheet" id="slider-elegant-css" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/slider-elegant.css" type="text/css" media="all"/>

  <!-- SLIDER NIVO -->
  <link rel="stylesheet" id="slider-nivo-css" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/slider-nivo.css" type="text/css" media="all"/>

  <!-- CUSTOM JAVASCRIPT -->
  <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl(); ?>/js/jquery.custom.js"></script>
</head>

<body class="home image-sphere-style responsive">

  <!-- START SHADOW WRAPPER -->
  <div class="shadowBg group">

    <!-- START WRAPPER -->
    <div class="wrapper group">

      <!-- START TOPBAR-->
      <div id="topbar">
        <div class="inner">
          <ul class="topbar_links">
            <?php foreach (\Uc::app()->url->getAvailableLanguages() as $lang) { ?>
              <li>
                <a href="<? echo \Uc::app()->url->getAbsoluteRequestUrlByLang($lang); ?>" ><? echo $lang; ?></a>
              </li>
            <? } ?>
          </ul>
          <div class="clear"></div>
        </div>
        <!-- end.inner -->
      </div>
      <!-- END TOPBAR -->

      <!-- START HEADER -->
      <div id="header" class="group">

        <!-- START LOGO -->
        <div id="logo" class="group">
          <a href="<?php echo \Uc::app()->url->create('/') ?>"" title="Diverso">
          <img src="<?php echo \Uc::app()->theme->getUrl(); ?>/images/logo.png" alt="Logo Diverso"/>
          </a>
        </div>
        <!-- END LOGO -->

        <!-- START NAV -->
        <div id="nav" class="group">
          <ul class="level-1 white">
            <li class="home">
              <a href="<?php echo \Uc::app()->url->create('/') ?>"><?php echo \Ub\Site\Settings\Table::get('mainPageName') ?></a>
            </li>
            <li class="folder">
              <a><?php echo \Ub\Site\Settings\Table::get('pagesName') ?></a>
              <?php if ($pages = \Ub\Site\Pages\Table::instance()->getAllFromCache() and !empty($pages)) { ?>
                <ul class="sub-menu">
                  <?php foreach ($pages as $page) { ?>
                    <li><a href="<?php echo $page->getViewUrl() ?>"><?php echo $page->title ?></a></li>
                  <?php } ?>
                </ul>
              <?php } ?>
            </li>
            <li class="bookmark">
              <a><?php echo \Ub\Site\Settings\Table::get('categoryName') ?></a>
              <?php if ($categories = \Ub\Simpleblog\Categories\Table::instance()->getAllFromCache() and !empty($categories)) { ?>
                <ul class="sub-menu">
                  <?php foreach ($categories as $category) { ?>
                    <li><a href="<?php echo $category->getViewUrl() ?>"><?php echo $category->title ?></a></li>
                  <?php } ?>
                </ul>
              <?php } ?>
            </li>
          </ul>
        </div>
        <!-- END NAV -->
      </div>
      <!-- END HEADER -->

      <div id="content" class="layout-sidebar-right group">

        <!-- SLOGAN -->
        <div id="slogan" class="inner">
          <h1><?php echo \Ub\Site\Settings\Table::get('widgetName') ?></h1>

          <h3><?php echo \Ub\Site\Settings\Table::get('slogan') ?></h3>
        </div>
        <!-- END SLOGAN -->
        <div id="primary" class="group">
              <?php echo $content;?>
          </div>

        <div id="sidebar" class="group">
          <div class="widget-last widget almost-all-categories">
            <h3><?php echo \Ub\Site\Settings\Table::get('categoryName') ?></h3>
            <?php if ($pages = \Ub\Site\Pages\Table::instance()->getAllFromCache() and !empty($pages)) { ?>
              <ul>
                <?php if ($categories = \Ub\Simpleblog\Categories\Table::instance()->getAllFromCache() and !empty($categories)) { ?>
                  <?php foreach ($categories as $category) { ?>
                    <li><a href="<?php echo $category->getViewUrl() ?>"><?php echo $category->title ?></a></li>
                  <?php } ?>
                <?php } ?>
              </ul>
            <?php } ?>
          </div>
        </div>

      </div>

      <!--        <!-- START TWITTER -->
      <!--        <div id="twitter-slider" class="group">-->
      <!--          <div class="tweets-list"></div>-->
      <!--          <div class="bird"></div>-->
      <!--        </div>-->
      <!--        <!-- END TWITTER -->

      <!-- START COPYRIGHT -->
      <div id="copyright" class="group two-columns">
        <div class="inner group">
          <p class="left">Copyright <a><strong>Diverso</strong></a> 2013 - Сайт працює на системі
            <a href="http://ukrcms.com" target="_blank"><strong>UkrCMS</strong></a>
          </p>


          <p class="right">
            <a href="#" class="socials facebook" title="Facebook">facebook</a>
            <a href="#" class="socials rss" title="Rss">rss</a>
            <a href="#" class="socials flickr" title="Flickr">flickr</a>
            <a href="#" class="socials youtube" title="Youtube">youtube</a>
            <a href="#" class="socials twitter" title="Twitter">twitter</a>
            <a href="#" class="socials linkedin" title="Linkedin">linkedin</a>
            <a href="#" class="socials mail" title="Mail">mail</a>
            <a href="#" class="socials skype" title="Skype">skype</a>
          </p>
        </div>

      </div>
      <!-- END COPYRIGHT -->

    </div>
    <!-- END WRAPPER -->

  </div>
  <!-- END SHADOW -->

</body>
</html>