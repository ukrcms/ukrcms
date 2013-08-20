<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);


  class InstallUkrCms {

    protected $errors = array();

    protected $data = array();

    protected $startInstall = false;

    public function getData() {
      return $this->data;
    }

    public function get($name) {
      if (isset($this->data[$name])) {
        return $this->data[$name];
      } else {
        return null;
      }
    }

    public function install() {
      $this->startInstall = true;

      $fieldsCheck = array(
        'INSTALL_DB_ADDRESS' => 'Не вказано шлях до сервера бази даних',
        'INSTALL_DB_NAME' => 'Не вказано назву бази даних',
        'INSTALL_DB_USER' => 'Не вказано ім\'я користувача',
        'INSTALL_DB_PASS' => 'Не вказано пароль користувача',
        'INSTALL_DB_PREFIX' => 'Префікс таблиць не може бути пустий',
        'INSTALL_ADMIN_PATH' => 'Не вказано шлях до панелі адміністрування',
        'INSTALL_SITE_PATH' => 'Префікс сайту не може бути пустий',
      );

      $data = $this->data = $_POST;

      foreach ($fieldsCheck as $field => $error) {
        if (empty($data[$field])) {
          $this->errors[] = $error;
        }
      }

      $configFilePartialPath = 'protected/config/main.php';
      $fileConfig = __DIR__ . '/../' . $configFilePartialPath;

      if (!file_exists($fileConfig)) {
        $this->errors[] = 'Неможливо знайти файл конфігурації ' . $configFilePartialPath;
      } elseif (!is_writable($fileConfig)) {
        $this->errors[] = 'Файл конфігурації має бути доступний для запису (chmod 0777 ' . $configFilePartialPath . ')';
      }

      if (!empty($this->errors)) {
        return false;
      }

      $data['INSTALL_ADMIN_PATH'] = trim($data['INSTALL_ADMIN_PATH'], '/');
      $data['INSTALL_SITE_PATH'] = '/' . trim($data['INSTALL_SITE_PATH'], '/');

      $this->data = $data;

      try {
        $conn = new PDO('mysql:host=' . $data['INSTALL_DB_ADDRESS'] . ';dbname=' . $data['INSTALL_DB_NAME'], $data['INSTALL_DB_USER'], $data['INSTALL_DB_PASS']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      } catch (PDOException $e) {
        $this->errors[] = 'Неможливо зєднатись з базою даних';
        $this->errors[] = 'ERROR: ' . $e->getMessage();
        return false;

      }

      $importData = __DIR__ . '/uc.sql';
      if (!file_exists($importData)) {
        $this->errors[] = "Неможливо знайти файл-дамп для бази даних" . $importData;
        return false;
      }

      try {
        foreach (file($importData) as $line) {
          $line = trim($line);
          if (!empty($line)) {
            $line = str_replace(' `uc_', ' `' . $this->get('INSTALL_DB_PREFIX'), $line);
            $conn->exec($line);
          }
        }
      } catch (PDOException $e) {
        $this->errors[] = 'Неможливо виконати імпорт бази даних';
        $this->errors[] = 'ERROR: ' . $e->getMessage();
        return false;
      }

      $fileContent = file_get_contents($fileConfig);
      if ($fileContent === false) {
        $this->errors[] = 'Неможливо прочитати файл конфігурації';
        return false;
      }

      foreach ($data as $from => $value) {
        $fileContent = str_replace($from, $value, $fileContent);
      }

      if (!file_put_contents($fileConfig, $fileContent)) {
        $this->errors[] = 'Неможливо зберегти файл конфігурації';
        return false;
      }

      return true;
    }

    public function getErrors() {
      return $this->errors;
    }

    /**
     * @return array
     */
    public function hasErrors() {
      if ($this->startInstall == false) {
        return null;
      }
      return (count($this->errors) > 0);
    }

    public function getAdminPath() {
      if ($this->get('INSTALL_ADMIN_PATH') != null) {
        return $this->get('INSTALL_ADMIN_PATH');
      }

      $defaultAdminPanels = array(
        'admin',
        'manager',
        'manage',
        'panel',
        'office',
        'adm-panel',
        'adm',
      );

      shuffle($defaultAdminPanels);

      $randomName = current($defaultAdminPanels);

      return '/' . ($randomName . rand(11, 999));
    }

  }

  $progress = new InstallUkrCms();
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<title>Встановлення UkrCms</title>

<meta name="author" content="Ivan Scherbak">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!--  <link rel="stylesheet" type="text/css" media="all" href="install_files/style.css">-->
<style type="text/css">
@import url("http://fonts.googleapis.com/css?family=Quando");

  /*! Hint.css - v1.2.1 - 2013-03-24
 * http://kushagragour.in/lab/hint/
 * Copyright (c) 2013 Kushagra Gour; Licensed MIT */

.hint, [data-hint] { position: relative; display: inline-block }
.hint:before, .hint:after, [data-hint]:before, [data-hint]:after { position: absolute; visibility: hidden; opacity: 0; z-index: 1000000; pointer-events: none; -webkit-transition: .3s ease; -moz-transition: .3s ease; transition: .3s ease }
.hint:hover:before, .hint:hover:after, [data-hint]:hover:before, [data-hint]:hover:after { visibility: visible; opacity: 1 }
.hint:before, [data-hint]:before { content: ''; position: absolute; background: transparent; border: 6px solid transparent; z-index: 1000001 }
.hint:after, [data-hint]:after { content: attr(data-hint); background: #383838; color: #fff; text-shadow: 0 -1px 0 black; padding: 8px 10px; font-size: 12px; line-height: 12px; white-space: nowrap; box-shadow: 4px 4px 8px rgba(0, 0, 0, .3) }
.hint--top:before { border-top-color: #383838 }
.hint--bottom:before { border-bottom-color: #383838 }
.hint--left:before { border-left-color: #383838 }
.hint--right:before { border-right-color: #383838 }
.hint--top:before { margin-bottom: -12px }
.hint--top:after { margin-left: -18px }
.hint--top:before, .hint--top:after { bottom: 100%; left: 50% }
.hint--top:hover:before, .hint--top:hover:after { -webkit-transform: translateY(-8px); -moz-transform: translateY(-8px); transform: translateY(-8px) }
.hint--bottom:before { margin-top: -12px }
.hint--bottom:after { margin-left: -18px }
.hint--bottom:before, .hint--bottom:after { top: 100%; left: 50% }
.hint--bottom:hover:before, .hint--bottom:hover:after { -webkit-transform: translateY(8px); -moz-transform: translateY(8px); transform: translateY(8px) }
.hint--right:before { margin-left: -12px; margin-bottom: -6px }
.hint--right:after { margin-bottom: -14px }
.hint--right:before, .hint--right:after { left: 100%; bottom: 50% }
.hint--right:hover:before, .hint--right:hover:after { -webkit-transform: translateX(8px); -moz-transform: translateX(8px); transform: translateX(8px) }
.hint--left:before { margin-right: -12px; margin-bottom: -6px }
.hint--left:after { margin-bottom: -14px }
.hint--left:before, .hint--left:after { right: 100%; bottom: 50% }
.hint--left:hover:before, .hint--left:hover:after { -webkit-transform: translateX(-8px); -moz-transform: translateX(-8px); transform: translateX(-8px) }
.hint--error:after { background-color: #b34e4d; text-shadow: 0 -1px 0 #5a2626 }
.hint--error.hint--top:before { border-top-color: #b34e4d }
.hint--error.hint--bottom:before { border-bottom-color: #b34e4d }
.hint--error.hint--left:before { border-left-color: #b34e4d }
.hint--error.hint--right:before { border-right-color: #b34e4d }
.hint--warning:after { background-color: #c09854; text-shadow: 0 -1px 0 #6d5228 }
.hint--warning.hint--top:before { border-top-color: #c09854 }
.hint--warning.hint--bottom:before { border-bottom-color: #c09854 }
.hint--warning.hint--left:before { border-left-color: #c09854 }
.hint--warning.hint--right:before { border-right-color: #c09854 }
.hint--info:after { background-color: #3986ac; text-shadow: 0 -1px 0 #193c4c }
.hint--info.hint--top:before { border-top-color: #3986ac }
.hint--info.hint--bottom:before { border-bottom-color: #3986ac }
.hint--info.hint--left:before { border-left-color: #3986ac }
.hint--info.hint--right:before { border-right-color: #3986ac }
.hint--success:after { background-color: #458746; text-shadow: 0 -1px 0 #1a331a }
.hint--success.hint--top:before { border-top-color: #458746 }
.hint--success.hint--bottom:before { border-bottom-color: #458746 }
.hint--success.hint--left:before { border-left-color: #458746 }
.hint--success.hint--right:before { border-right-color: #458746 }
.hint--always:after, .hint--always:before { opacity: 1; visibility: visible }
.hint--always.hint--top:after, .hint--always.hint--top:before { -webkit-transform: translateY(-8px); -moz-transform: translateY(-8px); transform: translateY(-8px) }
.hint--always.hint--bottom:after, .hint--always.hint--bottom:before { -webkit-transform: translateY(8px); -moz-transform: translateY(8px); transform: translateY(8px) }
.hint--always.hint--left:after, .hint--always.hint--left:before { -webkit-transform: translateX(-8px); -moz-transform: translateX(-8px); transform: translateX(-8px) }
.hint--always.hint--right:after, .hint--always.hint--right:before { -webkit-transform: translateX(8px); -moz-transform: translateX(8px); transform: translateX(8px) }
.hint--rounded:after { border-radius: 4px }

article, aside, details, figcaption, figure, footer, header, hgroup, nav, section { display: block; }
audio, canvas, video { display: inline-block; *display: inline; *zoom: 1; }
audio:not([controls]) { display: none; }
[hidden] { display: none; }

html { font-size: 100%; overflow-y: scroll; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
body { margin: 0; font-size: 13px; line-height: 1.231; }
body, button, input, select, textarea { font-family: sans-serif; color: #222222; }

::-moz-selection { background: #373737; color: #fafafa; text-shadow: none; }
::selection { background: #373737; color: #fafafa; text-shadow: none; }

a:visited { color: #551a8b; }
a:hover { color: #0066ee; }
a:focus { outline: thin dotted; }
a:hover, a:active { outline: 0; }

abbr[title] { border-bottom: 1px dotted; }
b, strong { font-weight: bold; }
blockquote { margin: 1em 40px; }
dfn { font-style: italic; }
hr { display: block; height: 1px; border: 0; border-top: 1px solid #cccccc; margin: 1em 0; padding: 0; }
ins { background: #ffff99; color: #000000; text-decoration: none; }
mark { background: #ffff00; color: #000000; font-style: italic; font-weight: bold; }
pre, code, kbd, samp { font-family: monospace, monospace; _font-family: 'courier new', monospace; font-size: 1em; }
pre { white-space: pre; white-space: pre-wrap; word-wrap: break-word; }
q { quotes: none; }
q:before, q:after { content: ""; content: none; }
small { font-size: 85%; }
sub, sup { font-size: 75%; line-height: 0; position: relative; vertical-align: baseline; }
sup { top: -0.5em; }
sub { bottom: -0.25em; }
ul, ol { margin: 1em 0; padding: 0 0 0 40px; }
dd { margin: 0 0 0 40px; }
nav ul, nav ol { list-style: none; list-style-image: none; margin: 0; padding: 0; }
img { border: 0; -ms-interpolation-mode: bicubic; vertical-align: middle; }
svg:not(:root) { overflow: hidden; }
figure { margin: 0; }

form { margin: 0; }
fieldset { border: 0; margin: 0; padding: 0; }
label { cursor: pointer; }
legend { border: 0; *margin-left: -7px; padding: 0; }
button, input, select, textarea { font-size: 100%; margin: 0; vertical-align: baseline; *vertical-align: middle; }
button, input { line-height: normal; *overflow: visible; }
table button, table input { *overflow: auto; }
button, input[type="button"], input[type="reset"], input[type="submit"] { cursor: pointer; -webkit-appearance: button; }
input[type="checkbox"], input[type="radio"] { box-sizing: border-box; }
input[type="search"] { -webkit-appearance: textfield; -moz-box-sizing: content-box; -webkit-box-sizing: content-box; box-sizing: content-box; }
input[type="search"]::-webkit-search-decoration { -webkit-appearance: none; }
button::-moz-focus-inner, input::-moz-focus-inner { border: 0; padding: 0; }
textarea { overflow: auto; vertical-align: top; resize: vertical; }
input:valid, textarea:valid { }
input:invalid, textarea:invalid { background-color: #f0dddd; }

table { border-collapse: collapse; border-spacing: 0; }
td { vertical-align: top; }

h1, h2, h3, h4, h5, p {
  margin: 0;
}

.ir br { display: none; }
.clearfix:before, .clearfix:after { content: ""; display: table; }
.clearfix:after { clear: both; }
.clearfix { zoom: 1; }

.work-grid ul {
  overflow: auto;
  list-style: none;
  margin: 0;
  padding: 0;
}

.work .grid li {
  margin: 0;
  padding: 0;
}
.punch-grid p { font-size: 0.9em; }
  /*
    Based on 960 Grid System - http://960.gs/ & 960 Fluid - http://www.designinfluences.com/
  */

  /* Stacks & Slats */

.stack-fixed {
  max-width: 920px;
  width: 92%;
  margin-left: auto;
  margin-right: auto;
}

.slat-2,
.slat-3,
.slat-4,
.slat-7,
.slat-12 {
  display: inline;
  float: left;
  position: relative;
  margin-left: 1%;
  margin-right: 1%;
}

  /* Grid >> Children (Alpha ~ First, Omega ~ Last)
  ----------------------------------------------------------------------------------------------------*/

.first {
  margin-left: 0;
}

  /* Grid >> 12 Columns
----------------------------------------------------------------------------------------------------*/

.slat-2 {
  width: 14.667%;
}

.slat-3 {
  width: 23.0%;
}

.slat-4 {
  width: 31.333%;
}

.slat-7 {
  width: 56.333%;
}

.slat-12 {
  width: 98.0%;
}

.push_2 {
  left: 16.667%;
}
.clearfix:after {
  clear: both;
  content: ' ';
  display: block;
  font-size: 0;
  line-height: 0;
  visibility: hidden;
  width: 0;
  height: 0;
}

.clearfix {
  display: inline-block;
}

* html .clearfix {
  height: 1%;
}

.clearfix {
  display: block;
}

body {
  background: #ffffff;
  font-family: sans-serif;
  font-size: 15px;
  line-height: 24px;
  color: #464646;
  font-family: Helvetica, Arial, sans-serif, serif;
}

html.fontface body {
  font-family: Helvetica, Arial, sans-serif, serif;
  -moz-font-feature-settings: "calt=0";
  font-weight: normal;
}

h1 {
  font-size: 76px;
  line-height: 84px;
  letter-spacing: -1px;
}

h2 {
  font-family: serif;
  font-size: 2.4em;
  line-height: 1.2em;
  text-align: left;
}

html.fontface h2 {
  font-weight: normal;
  font-family: Helvetica, Arial, sans-serif, serif;
}

h3 {
  font-family: Helvetica, Arial, sans-serif, serif;
  font-size: 20px;
  line-height: 28px;
  font-weight: normal;
}

html.fontface h3 {
  font-family: Helvetica, Arial, sans-serif;
  font-weight: normal;
  font-size: 1.866em;
}

h4 {
  font-size: 17px;
  line-height: 22px;
}

html.fontface h4 {
  font-family: Helvetica, Arial, sans-serif;
  font-weight: normal;
  font-size: 1.13em;
}

small {
  font-size: 13px;
  line-height: 18px;
}

  /* General Elements */

ul, ol {
  margin: 0;
  padding: 0;
  list-style: none;
}

img, embed, iframe {
  max-width: 100%;
}

  /* Links */

a:visited {
  color: #79b429;
  text-decoration: none;
}

a, a:hover {
  color: #79b429;
  text-decoration: none;
  border: none;
}

a:focus {
  outline: none;
}

button::-moz-focus-inner {
  border: 0;
}

header {
  border-bottom: 1px solid #e7e7e7;
  margin-top: 50px;
  padding-bottom: 50px;
}

.logo a {
  display: inline-block;
  float: left;
  position: relative;
  font-family: 'Quando', serif;
  font-size: 76px;
  /*background: url('../images/logo.png') no-repeat;*/
  width: 276px;
  height: 42px;

  /* IE7 inline-block fix */
  zoom: 1;
  *display: inline;
  _height: 19px;
}

.main-nav {
  width: auto;
  float: right;
  margin-top: 6px;
}

.main-nav ul {
  margin: 0;
  padding: 0;
}

.main-nav li {
  display: inline;
  text-align: right;
  margin-left: 20px;
}

.main-nav a {
  color: #464646;
  font-weight: bold;
  font-size: 1.2em;
  background: white;
  padding: 10px;
}

html.fontface .main-nav a {
  font-weight: normal;
  font-family: Helvetica, Arial, sans-serif;
}

.main-nav a:hover, .main-nav a.selected {
  color: #ffffff;
  text-decoration: none;
  background: #79b429;
}

footer {
  min-height: 75px;
  display: block;
}

.home-hero h3 {
  font-size: 1.20em !important;
  margin-top: 20px;
  padding: 0 0 20px 0;
  line-height: 0;
}

.work-grid ul {
  position: relative;
}

.slat-3 {
  width: 23.5%;
  margin-bottom: 2%;
}

html.fontface {
  font-family: Helvetica, Arial, sans-serif;
  font-weight: normal;
}

.project a {
  color: #464646;
}

.project a:hover {
  text-decoration: none
}

.project p {
  margin-bottom: 15px;
  text-align: justify;
}

.project a {
  text-decoration: underline;
}

body.work {
  list-style-type: circle;
}
body.work .services li {
  margin-left: 15px;
}

body.work .services h4 {
  margin: 0;
}
.project-meta a,
.project-meta li {
  color: #666666;
}

body.work .project-meta a {
  margin-bottom: 10px;
  display: block;
}

body.work a[href^="http://"] {
  position: relative;
  padding-left: 16px;
}
body.work a[href^="http://"]:before {
  content: "";
  display: block;
  width: 9px; height: 9px;
  padding-right: 16px;
  position: absolute;
  top: 6px;
  left: -7px;
}

html.fontface {
  font-family: Helvetica, Arial, sans-serif;
  font-weight: normal;
  letter-spacing: 0.09em;
}

.office-img img {
  display: block;
  margin: 0 auto;
  padding-bottom: 30px;
}

.top-mast h1 {
  font-weight: normal;
  font-family: Helvetica, Arial, sans-serif, serif;
  font-size: 2em;
  line-height: 1.5em;
  text-align: left;
  letter-spacing: 0;
}
.contact-top-mast { margin-bottom: 60px; }

.entry-content h1.project-title {
  font-family: Helvetica, Arial, sans-serif;
  font-weight: normal;
  font-size: 1.866em;
  letter-spacing: 0;
  line-height: 28px;
}

.entry-text {
  padding-top: 30px;
  padding-bottom: 40px;
  font-family: Helvetica, Arial, sans-serif;
}

.entry-text select {
  font-size: 15px;
  position: relative;
  padding: 3px;
  top: -4px;
  right: -5px;
}

.green h2 { color: #ffffff !important; }

  /* ! iPad Portrait */

  /*-----------------------------------------------------------------------*/
  /* ! IE Old */
  /*----------------------------------------------------------------------*/

html.oldie .slat-3 {
  margin-right: 0.5%;
}
  /* Icons */
.features-list i { margin-right: 10px; }

.footer { border-top: 1px solid #e7e7e7;
  padding: 40px 0; }

.block h5 { font-size: 0.8em !important; }

  /* Tighten up spacing */
.well hr {
  margin: 18px 0;
}
input,
textarea,
select {
  display: inline-block;
  width: 210px;
  height: 18px;
  padding: 4px;
  margin-bottom: 9px;
  font-size: 13px;
  line-height: 18px;
  color: #555555;
  border: 1px solid #cccccc;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
input,
textarea {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
  -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
  -ms-transition: border linear 0.2s, box-shadow linear 0.2s;
  -o-transition: border linear 0.2s, box-shadow linear 0.2s;
  transition: border linear 0.2s, box-shadow linear 0.2s;
}
input:focus,
textarea:focus {
  border-color: rgba(82, 168, 236, 0.8);
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
  outline: 0;
  /* IE6-9 */
}

input.slat-4, textarea.slat-4, .uneditable-input.slat-4 {
  width: 265px; }

.btn {
  display: inline-block;
  *display: inline;
  /* IE7 inline-block hack */
  *zoom: 1;
  padding: 4px 10px 4px;
  margin-bottom: 0;
  font-size: 13px;
  line-height: 18px;
  color: #ffffff;
  text-align: center;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  vertical-align: middle;
  background-color: #f5f5f5;
  background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: linear-gradient(top, #ffffff, #e6e6e6);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#e6e6e6', GradientType=0);
  border-color: #e6e6e6 #e6e6e6 #bfbfbf;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:dximagetransform.microsoft.gradient(enabled=false);
  border: 1px solid #cccccc;
  border-bottom-color: #b3b3b3;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  cursor: pointer;
  *margin-left: .3em;
}
.btn:hover,
.btn:active,
.btn[disabled] {
  background-color: #e6e6e6;
}
.btn:active {
  background-color: #cccccc                                                                                                                        \9;
}
.btn:first-child {
  *margin-left: 0;
}
.btn:hover {
  color: #ffffff;
  text-decoration: none;
  background-color: #e6e6e6;
  background-position: 0 -15px;
  -webkit-transition: background-position 0.1s linear;
  -moz-transition: background-position 0.1s linear;
  -ms-transition: background-position 0.1s linear;
  -o-transition: background-position 0.1s linear;
  transition: background-position 0.1s linear;
}
.btn:focus {
  outline: 0;
}

.btn:active {
  background-image: none;
  -webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
  background-color: #e6e6e6;
  background-color: #d9d9d9                                                                                                                        \9;
  outline: 0;
}
.btn[disabled] {
  cursor: default;
  background-image: none;
  background-color: #e6e6e6;
  opacity: 0.65;
  filter: alpha(opacity=65);
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
}
.btn-success {
  background-color: #659a22;
  background-image: -moz-linear-gradient(top, #9ac92c, #659a22);
  background-image: -ms-linear-gradient(top, #9ac92c, #659a22);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#9ac92c), to(#659a22));
  background-image: -webkit-linear-gradient(top, #9ac92c, #659a22);
  background-image: -o-linear-gradient(top, #9ac92c, #659a22);
  background-image: linear-gradient(top, #9ac92c, #659a22);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#9ac92c', endColorstr='#659a22', GradientType=0);
  border-color: #51a351 #51a351 #387038;
  border-color: rgba(255, 255, 255, 0.15) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:dximagetransform.microsoft.gradient(enabled=false);
  text-shadow: 1px 1px #659a22 !important;
}
.btn-success:hover,
.btn-success:active,
.btn-success[disabled] {
  background-color: #659a22;
}
.btn-success:active,
.ML6 { margin-left: 6px; }

.logo a { color: #464646; }
.install-form { margin-top: 10px; }
</style>
</head>
<body>

  <header class="mast-head stack-fixed clearfix">
    <article class="logo">
      <a href="http://ukrcms.com/" title="UkrCms">UkrCms</a>
    </article>
    <nav class="main-nav">
      <ul>
        <li>
          <a href="http://ukrcms.com/forum/" target="_blank">Допомога</a>
        </li>
      </ul>
    </nav>
  </header>

  <article class="main" role="main">
    <section class="stack-fixed clearfix entry-text">
      <div class="top-mast contact-top-mast">
        <h1>Встановлення UkrCms</h1>
        <?php
          if ($progress->get('INSTALL_SITE_PATH') != null) {
            $sitePath = $progress->get('INSTALL_SITE_PATH');
          } elseif (!empty($_SERVER['REQUEST_URI'])) {
            $sitePath = preg_replace('!install/' . basename(__FILE__) . '[\?.]*$!', '$1', $_SERVER['REQUEST_URI']);
            $sitePath = rtrim($sitePath, "/");
          }

          if (empty($sitePath)) {
            $sitePath = '/';
          }


          if (!empty($_POST)) {
            if ($progress->install()) {
              ?>
              Вітаю, Ваш сайт успішно встановлено<br>
              Ось дані для адміністрування вашого сайту:<br><br>

              Сайт:
              <a href="<?php echo $sitePath ?>">переглянути</a>
              <br>
              Панель адміністрування:
              <a href="<?php echo $sitePath ?><?php echo $progress->get('INSTALL_ADMIN_PATH') ?>/">перейти</a>
              <br>
              login: admin<br>

              пароль: 1111<br>
            <?php } else { ?>
              <ul>
                <?php foreach ($progress->getErrors() as $error) { ?>
                  <li style="color: #ca5427"><?php echo $error ?></li>
                <?php } ?>
              </ul>
            <?php
            }
          }
        ?>

        <div class="row install-form" style="<?php echo ($progress->hasErrors() === null or $progress->hasErrors() === true) ? '' : 'display:none' ?>">

          <p>Для встановлення системи вам необхідно всього навсього заповнити невелику форму нижче</p>

          <form class="form " method="post">
            <div class="slat-12">
              <div class="slat-4">
                Сервер бази даних:
              </div>
              <div class="slat-2 hint--right" data-hint="Шлях до сервера бази даних. Для прикладу, на локальному комп'ютері це буде localhost або 127.0.0.1">
                <?php $dbAddress = $progress->get('INSTALL_DB_ADDRESS') != null ? $progress->get('INSTALL_DB_ADDRESS') : '127.0.0.1'; ?>
                <input name="INSTALL_DB_ADDRESS" class="slat-12" type="text" value="<?php echo $dbAddress ?>">
              </div>
            </div>
            <div class="slat-12">
              <div class="slat-4">
                Імя бази даних:
              </div>
              <div class="slat-2 hint--right" data-hint="База повинна бути створена на хостингу. Для прикладу назва бази: db_uc, blogdb, site">
                <input name="INSTALL_DB_NAME" class="slat-12" type="text" value="<?php echo $progress->get('INSTALL_DB_NAME') ?>">
              </div>
            </div>

            <div class="slat-12">
              <div class="slat-4">
                Користувач бази даних:
              </div>
              <div class="slat-2 hint--right" data-hint="Для прикладу: root, db_admin, test_user">
                <input name="INSTALL_DB_USER" class="slat-12" type="text" value="<?php echo $progress->get('INSTALL_DB_USER') ?>">
              </div>
            </div>

            <div class="slat-12">
              <div class="slat-4">
                Пароль бази даних:
              </div>
              <div class="slat-2 hint--right" data-hint="Пароль доступу до бази даних.  ">
                <input name="INSTALL_DB_PASS" class="slat-12" type="text" value="<?php echo $progress->get('INSTALL_DB_PASS') ?>">
              </div>
            </div>

            <div class="slat-12">
              <div class="slat-4">
                Префікс таблиць:
              </div>
              <div class="slat-2 hint--right" data-hint="Для досвідчених користувачів. Залиште стандатрним якщо не знаєте що це таке.">
                <?php $dbPrefix = $progress->get('INSTALL_DB_PREFIX') != null ? $progress->get('INSTALL_DB_PREFIX') : 'uc_'; ?>
                <input name="INSTALL_DB_PREFIX" class="slat-12" type="text" value="<?php echo $dbPrefix ?>">
              </div>
            </div>

            <div class="slat-12">
              <div class="slat-4">
                Шлях до панелі адміністрування:
              </div>
              <div class="slat-2 hint--right" data-hint="В цілях безпеки вашого сайту задайте шлях по якому буде доступна панель адміністрування. ">
                <input name="INSTALL_ADMIN_PATH" class="slat-12" type="text" value="<?php echo $progress->getAdminPath() ?>">
              </div>
            </div>


            <div class="slat-12">
              <div class="slat-4">
                Розсташування сайту:
              </div>
              <div class="slat-2 hint--right" data-hint="Якщо сайт розміщується не в кореневому каталозі веб-сервера">

                <input name="INSTALL_SITE_PATH" class="slat-12" type="text" value="<?php echo $sitePath ?>">
              </div>
            </div>
            <div class="slat-12">
              <div class="slat-4">&nbsp;</div>
              <button class="btn btn-success ML6" type="submit">Встановити</button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <section class="stack-fixed entry-text footer clearfix">

      <div class="slat-7 first">

        Якщо у Вас виникли запитання можете звернутись на
        <a href="http://ukrcms.com/forum/" target="_blank">форум</a>&nbsp;або написати у форму зворотнього звязку.
        Ми обовязково Вам допоможемо.<br></p>
      </div>


      <ul class="slat-3 push_2">
        <li>
          dev@ukrcms.com
        </li>
        <li>
          <a href="https://twitter.com/ukrcms" target="_blank"> Пишіть нам у Twitter</a>
        </li>
      </ul>
    </section>

  </article>

</body>
</html>