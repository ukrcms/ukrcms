<?php

  error_reporting(E_ALL);
  ini_set('display_errors', true);

  require_once __DIR__ . '/../core/Uc.php';

  $classMap = array(
    'Uc' => __DIR__ . '/../core',
    'Ub' => __DIR__ . '/../bundles',
    'TestApp' => __DIR__ . '/demo-bundles',
  );

  Uc::registerAutoloader($classMap);

  # load application configuration
  $config = include __DIR__ . '/config.php';

  session_start();

  # init application
  $app = Uc::initApp('\Uc\App', $config);

  return $app;