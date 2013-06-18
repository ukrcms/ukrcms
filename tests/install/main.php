<?php
  namespace Test\Install;

  use Behat\MinkExtension\Context\MinkContext;

  class Main extends MinkContext {

    /**
     * @BeforeScenario
     */
    public function before($event) {
//      $this->setMinkParameter('base_url', TEST_SUBDIR_INSTALLER_URL);
    }

    public function initDirectoryOptions() {
      $this->setMinkParameter('base_url', TEST_SUBDIR_INSTALLER_URL);
      $this->setMinkParameter('local_dir', TEST_SUBDIR_INSTALLER_DIR);
    }

    protected function initDomainOptions() {
      $this->setMinkParameter('base_url', TEST_DOMAIN_INSTALLER_URL);
      $this->setMinkParameter('local_dir', TEST_DOMAIN_INSTALLER_DIR);
    }


    /**
     * @Given /^I check (.*) installation of package "([^"]*)"$/
     */
    public function iDownloadAndUnzipPack($type, $pack) {
      if ($type == 'domain') {
        $this->initDomainOptions();
      } elseif ($type == 'directory') {
        $this->initDomainOptions();
      } else {
        throw new \Exception('Not valid type check');
      }

      $dir = $this->getMinkParameter('local_dir');

      shell_exec('rm -rf ' . $dir);
      shell_exec('mkdir -p ' . $dir);
      if (!is_dir($dir)) {
        throw new \Exception('Can not create directory ' . $dir);
      }

      $packageFilePath = PACKAGES_DIR . '/' . $pack;
      shell_exec('unzip ' . $packageFilePath . ' -d ' . $dir);
    }

  }
