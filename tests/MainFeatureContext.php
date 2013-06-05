<?php

  require_once __DIR__ . '/../core/Uc.php';
  require_once __DIR__ . '/../dev-data/config.php';

  Uc::registerAutoloader(array(
    'Uc' => __DIR__ . '/../core',
    'Ub' => __DIR__ . '/../bundles',
  ));
  /**
   * Features context.
   */
  class MainFeatureContext extends Behat\Behat\Context\BehatContext {

    public function __construct() {
      $this->useContext('Ub\Helper\Arrays', new \Test\Ub\Helper\Arrays());
      $this->useContext('Install\Main', new \Test\Install\Main());
    }
  }
