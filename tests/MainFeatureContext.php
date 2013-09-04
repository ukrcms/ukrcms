<?php

  require_once __DIR__ . '/../core/Uc.php';
  require_once __DIR__ . '/../dev-data/config.php';
  require_once __DIR__ . '/app.php';

  /**
   * Features context.
   */
  class MainFeatureContext extends Behat\Behat\Context\BehatContext {

    public function __construct() {
      $this->useContext('Ub\Helper\Arrays', new \Test\Ub\Helper\Arrays());
      $this->useContext('Install\Main', new \Test\Install\Main());
      $this->useContext(\Test\Uc\Db\Select::N, new \Test\Uc\Db\Select());
      $this->useContext(\Test\Uc\Db\Table::N, new \Test\Uc\Db\Table());
      $this->useContext(\Test\Uc\Db\Model::N, new \Test\Uc\Db\Model());
    }
  }
