<?php

  require '../../../composer/vendor/autoload.php';


  class Page {

    const URL = '/ukrcms/docs/wiki';

    public static function getHtmlFromFile($filePartialPath) {
      $filePartialPath = 'src/' . $filePartialPath . '.rst';
      if (!is_file($filePartialPath)) {
        return 'ERROR::: no file ' . $filePartialPath;
      }
      $data = file_get_contents($filePartialPath);
      $html = \Michelf\MarkdownExtra::defaultTransform($data);
      $html = preg_replace('!(<a.*href\s*=["\'])/!uU', '$1' . self::URL . '/', $html);
      return $html;
    }

    public static function getHtmlFromMainFile() {
      if (!empty($_GET['q'])) {
        $file = $_GET['q'];
      } else {
        $file = 'index';
      }
      return self::getHtmlFromFile($file);
    }
  }

?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">
    <title>Документація - UrkCms </title>
    <link rel="stylesheet" href="<?php echo Page::URL ?>/theme/general.css">
  </head>
  <body>
    <div class="mother">
      <header class="mast-head stack-fixed clearfix">


        <nav class="main-nav">

          <ul>
            <li class="first">
              <a href="http://ukrcms.com/" target="_blank">Ukrcms.com</a>
            </li>

          </ul>

        </nav>
      </header>
      <article class="main" role="main">
        <section class="stack-fixed entry-text footer clearfix">


          <ul class="slat-3">
            <?php echo Page::getHtmlFromFile('menu') ?>
            <li><i class=""></i> <a href="#">dev-team@ukrcms.com</a></li>

          </ul>


          <div class="slat-9 first">
            <?php echo Page::getHtmlFromMainFile() ?>
          </div>
        </section>


      </article>


    </div>

  </body>
</html>
