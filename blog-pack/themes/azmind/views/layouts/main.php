<!DOCTYPE html>
<html dir="ltr" lang="en-US">
  <head>
    <title><?php echo \Uc::app()->theme->getValue('seo_meta_title') ?></title>

    <meta name="description" content="<?php echo \Uc::app()->theme->getValue('seo_meta_description') ?>"/>
    <meta name="keywords" content="<?php echo \Uc::app()->theme->getValue('seo_meta_keywords') ?>"/>

    <meta name="author" content="Ivan Scherbak"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" type="text/css" media="all" href="<?php echo \Uc::app()->theme->getUrl(); ?>/css/style.css"/>
  </head>
  <body>
    <div id="header">
      <div class="header-bottom">
        <div class="logo">
          <h1>
            <a href="<?php echo \Uc::app()->url->create('/') ?>"><?php echo \Ub\Site\Settings\Table::instance()->get('blogTitle') ?></a>
          </h1>
        </div>
      </div>
    </div>


    <div class="clearfix"></div>

    <div id="content">
      <div id="posts">
        <?php echo $content ?>
      </div>
      <div id="sidebar">

        <ul class="sidebar-content">

          <li class="widget widget_text"><h2 class="widgettitle">Віджет</h2>

            <div class="textwidget">
              <?php echo  \Ub\Site\Settings\Table::get('slogan') ?>
            </div>
          </li>



          <?php if ($categories = \Ub\Simpleblog\Categories\Table::instance()->getAllFromCache() and !empty($categories)) { ?>
            <li class="widget widget_categories"><h2 class="widgettitle">Категорії</h2>
              <ul>
                <?php foreach ($categories as $category) { ?>
                  <li class="cat-item">
                    <a href="<?php echo $category->getViewUrl() ?>">
                      <?php echo $category->title ?>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <?php if ($pages = \Ub\Site\Pages\Table::instance()->getAllFromCache() and !empty($pages)) { ?>
            <li class="widget widget_categories"><h2 class="widgettitle">Сторінки</h2>
              <ul>
                <?php foreach ($pages as $page) { ?>
                  <li class="cat-item">
                    <a href="<?php echo $page->getViewUrl() ?>">
                      <?php echo $page->title ?>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
        </ul>
      </div>


    </div>

    <div id="footer-credits">
      <div class="footer-credits-inside">
        <div class="footer-credits-right">
          <?php list($time, $memory) = \Uc\App::getDebugInfo() ?>
          <span>
             <?php echo $time ?> с. / <?php echo $memory ?> мб.
           </span>

          Сайт працює на системі <a href="http://ukrcms.com" title="Безкоштовна українська cms">UkrCms</a>

          Автор теми: azmind
        </div>
      </div>
    </div>
    <img src="http://ukrcms.com/app/stat/image" alt="Система управління сайтом UkrCms"/>
  </body>
</html>