<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Pawe? 'kilab' Balicki - kilab.pl"/>
    <title>SimpleAdmin</title>
    <link rel="stylesheet" type="text/css" href="<?= \Uc::app()->theme->getUrl() ?>/css/style.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= \Uc::app()->theme->getUrl() ?>/css/navi.css" media="screen"/>
    <script type="text/javascript" src="<?= \Uc::app()->theme->getUrl() ?>/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript">
      $(function () {
        $(".box .h_title").each(function () {
          var box = $(this);
          var ul = box.next("ul");

          if (ul.find('.current').size() == 0) {
            ul.hide("normal");
          }

          box.click(function () {
            ul.slideToggle();
          });
        })
        $('.confirm').click(function () {
          var txt = $(this).attr('data-confirm');
          if (typeof txt == "undefined" || txt == '') {
            txt = 'Confirm action?';
          }
          return confirm(txt);
        })
      });
    </script>
  </head>
  <body>
    <div class="wrap">
      <div id="header">
        <div id="top" style="">

          <? if (\Uc::app()->userIdentity->isLogin()) { ?>
            <div class="left">
              <p>Привіт, <strong><? echo(\Uc::app()->userIdentity->getUser()->name); ?></strong> [
                <a href=" <?= \Uc::app()->url->create(\Uc::app()->userIdentity->getLogoutRoute()); ?>">вихід</a> ]</p>
            </div>
          <? } ?>
          <div class="right">
            <div class="align-right">
              <p>Time: <strong><?= strftime('%Y-%m-%d %H:%M:%S') ?></strong></p>
            </div>
          </div>

        </div>
        <div id="nav">
          <ul style="display: none ">
            <li class="upp"><a href="#">Main control</a>
              <ul>
                <li>&#8250; <a href="">Visit site</a></li>
                <li>&#8250; <a href="">Reports</a></li>
                <li>&#8250; <a href="">Add new page</a></li>
                <li>&#8250; <a href="">Site config</a></li>
              </ul>
            </li>
            <li class="upp"><a href="#">Manage content</a>
              <ul>
                <li>&#8250; <a href="">Show all pages</a></li>
                <li>&#8250; <a href="">Add new page</a></li>
                <li>&#8250; <a href="">Add new gallery</a></li>
                <li>&#8250; <a href="">Categories</a></li>
              </ul>
            </li>
            <li class="upp"><a href="#">Users</a>
              <ul>
                <li>&#8250; <a href="">Show all uses</a></li>
                <li>&#8250; <a href="">Add new user</a></li>
                <li>&#8250; <a href="">Lock users</a></li>
              </ul>
            </li>
            <li class="upp"><a href="#">Settings</a>
              <ul>
                <li>&#8250; <a href="">Site configuration</a></li>
                <li>&#8250; <a href="">Contact Form</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>

      <div id="content">
        <div id="sidebar">
          <?php if (!empty($this->leftMenu)) { ?>
            <?php foreach ($this->leftMenu as $sectionName => $items) { ?>
              <div class="box">
                <div class="h_title">&#8250; <?= $sectionName ?></div>

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
                    <li class="b <?= !empty($info['current']) ? 'current' : '' ?>"><a class="icon <?= $icon ?>"
                                                                                      href="<?= $href ?>"><?= $text ?></a>
                    </li>
                  <? } ?>
                </ul>
              </div>
            <?php } ?>
          <?php } ?>
        </div>

        <div id="main">

          <?= $content ?>

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

    <script type="text/javascript" src="<?= \Uc::app()->theme->getUrl() ?>/js/cleditor-1.3.0/jquery.cleditor.js"></script>
    <script src="<?= \Uc::app()->theme->getUrl() ?>/js/cleditor-1.3.0/plugins/uploader-1.0/jquery.cleditor.uploader-1.0.js"></script>
    <script src="<?= \Uc::app()->theme->getUrl() ?>/js/cleditor-1.3.0/plugins/replacer-1.0/jquery.cleditor.replacer-1.0.js"></script>
    <script src="<?= \Uc::app()->theme->getUrl() ?>/js/ukrTranslit-1.0/jquery.ukrTranslit.js"></script>
    <link rel="stylesheet" href="<?= \Uc::app()->theme->getUrl() ?>/js/cleditor-1.3.0/jquery.cleditor.css"/>
    <script type="text/javascript">
      $(document).ready(function () {
        $('#title').ukrTranslit('#sef');
        $(".cleditor").cleditor();
      });
    </script>

  </body>
</html>
