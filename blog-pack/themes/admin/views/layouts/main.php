<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Pawe? 'kilab' Balicki - kilab.pl"/>
    <title>SimpleAdmin</title>
    <link rel="stylesheet" type="text/css" href="<?php echo \Uc::app()->theme->getUrl() ?>/css/style.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?php echo \Uc::app()->theme->getUrl() ?>/css/navi.css" media="screen"/>
    <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl() ?>/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl() ?>/js/jquery.cookie.js"></script>

    <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl() ?>/js/cleditor-1.3.0/jquery.cleditor.js"></script>
    <script src="<?php echo \Uc::app()->theme->getUrl() ?>/js/cleditor-1.3.0/plugins/uploader-1.0/jquery.cleditor.uploader-1.0.js"></script>
    <script src="<?php echo \Uc::app()->theme->getUrl() ?>/js/cleditor-1.3.0/plugins/replacer-1.0/jquery.cleditor.replacer-1.0.js"></script>
    <script src="<?php echo \Uc::app()->theme->getUrl() ?>/js/ukrTranslit-1.0/jquery.ukrTranslit.js"></script>
    <link rel="stylesheet" href="<?php echo \Uc::app()->theme->getUrl() ?>/js/cleditor-1.3.0/jquery.cleditor.css"/>


    <script type="text/javascript" src="<?php echo \Uc::app()->theme->getUrl() ?>/js/user.js"></script>
  </head>
  <body>
    <div class="wrap">
      <div id="header">
        <div id="top" style="">

          <?php if (\Uc::app()->userIdentity->isLogin()) { ?>
            <div class="left">
              <p>Привіт,
                <strong><?php echo(\Uc::app()->userIdentity->getUser()->name); ?></strong>
                [<a href=" <?php echo \Uc::app()->url->create(\Uc::app()->userIdentity->getLogoutRoute()); ?>">вихід</a>]
              </p>

            </div>
          <?php } ?>
           Мова сайту:
          <?php foreach(\Uc::app()->url->getAvailableLanguages() as $lang){?>
            [<a href="<?echo \Uc::app()->url->getAbsoluteRequestUrlByLang($lang);  ?>"><?echo $lang;?></a>]
          <?}?>

          <div class="right">
            <div class="align-right">
              <p>
                <a href="<?php echo \Uc::app()->url->create('/'); ?>" target="_blank">Перейти на сайт</a>
                &nbsp;&nbsp;&nbsp;
                <strong><?php echo strftime('%Y-%m-%d %H:%M:%S') ?></strong>
              </p>
            </div>
          </div>

        </div>
        <div id="nav">
          <ul>

            <?php if (!empty($this->topMenu)) { ?>
              <?php foreach ($this->topMenu as $sectionName => $items) { ?>
                <li class="upp"><a href="#">&#8250; <?php echo $sectionName ?></a>
                  <ul>
                    <?php foreach ($items as $href => $info) { ?>
                      <?php
                      if (is_string($info)) {
                        $text = $info;
                      } else {
                        $href = !empty($info['href']) ? $info['href'] : $href;
                        $text = $info['text'];
                      }
                      ?>
                      <li class="<?php echo !empty($info['current']) ? 'current' : '' ?>">
                        <a href="<?php echo $href ?>"> &#8250; <?php echo $text ?></a>
                      </li>
                    <?php } ?>
                  </ul>
                </li>
              <?php } ?>
            <?php } ?>
          </ul>
        </div>
      </div>

      <div id="content">
        <div id="sidebar">
          <?php if (!empty($this->leftMenu)) { ?>
            <?php foreach ($this->leftMenu as $sectionName => $items) { ?>
              <div class="box">
                <div class="h_title">&#8250; <?php echo $sectionName ?></div>
                <ul>
                  <?php foreach ($items as $href => $info) { ?>
                    <?php
                    if (is_string($info)) {
                      $text = $info;
                      $icon = '';
                    } else {
                      $href = !empty($info['href']) ? $info['href'] : $href;
                      $text = $info['text'];
                      $icon = $info['icon'];
                    }
                    ?>
                    <li class="b <?php echo !empty($info['current']) ? 'current' : '' ?>">
                      <a class="icon <?php echo $icon ?>" href="<?php echo $href ?>"><?php echo $text ?></a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
          <?php } ?>
        </div>

        <div id="main">

          <?php echo $content ?>

          <div class="clear"></div>

        </div>
        <div class="clear"></div>
      </div>

      <div id="footer">
        <div class="left">
          <p>Сайт працює на <a href="http://ukrcms.com" target="_blank" style="color:white">UkrCMS</a>
          </p>
        </div>
        <div class="right">
          Дизайн: kilab.pl
        </div>
      </div>
    </div>

  </body>
</html>
