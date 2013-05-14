<?php
  error_reporting(E_ALL);

  $showReports = ($_SERVER['HTTP_HOST'] == 'localhost');
  ini_set('display_errors', $showReports);


  define('UC_START_MEMORY', memory_get_usage());
  define('UC_START_TIME', microtime(true));

  require_once __DIR__ . '/../core/Uc.php';

  $classMap = array(
    'Uc' => __DIR__ . '/../core',
    'Ub' => __DIR__ . '/../bundles',
    'App' => __DIR__ . '/protected/bundles',
  );

  Uc::registerAutoloader($classMap);

  # load application configuration
  $config = include 'protected/config/main.php';

  # Configuration on development server
  // if ($_SERVER['HTTP_HOST'] == 'localhost') {
  //  $localConfig = include 'protected/config/local.php';
  //  $config = \Ub\Helper\Arrays::mergeRecursive($config, $localConfig);
  // }

  session_start();

  # init application
  $app = Uc::initApp('\Uc\App', $config);

  $app->run();