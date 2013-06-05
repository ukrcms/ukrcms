<?php
  namespace Test\Install;

  use Behat\Behat\Context\BehatContext;

  class Main extends BehatContext {

    /**
     * @Given /^i download and unzip package "([^"]*)"$/
     */
    public function iDownloadAndUnzipPack($pack) {
      shell_exec('rm -rf ' . TEST_INSTALLER_DIR);
      shell_exec('mkdir -p ' . TEST_INSTALLER_DIR);
      $packageFilePath = PACKAGES_DIR . '/' . $pack;
      shell_exec('unzip ' . $packageFilePath . ' -d ' . TEST_INSTALLER_DIR);
    }

  }
