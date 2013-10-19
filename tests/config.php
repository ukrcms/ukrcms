<?php
  include_once __DIR__ . '/../dev-data/config.php';

  return array(
    'components' => array(
      'db' => array(
        'dsn' => 'mysql:host=' . TEST_DB_HOST . ';dbname=' . TEST_DB_NAME,
        'username' => TEST_DB_USER,
        'password' => TEST_DB_PASS,
        'tablePrefix' => 'uc_',
      ),
      'theme' => array(
        'themeName' => 'themeTestName',
        'layout' => 'main',
        'basePath' => dirname(__FILE__) . '/../../themes',
        'baseUrl' => '/themes',
      ),
    )
  );