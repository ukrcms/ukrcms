<?php
  namespace Test\Install;

  use Behat\MinkExtension\Context\MinkContext;

  class Main extends MinkContext {


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
        $this->initDirectoryOptions();
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

    /**
     * @When /^I fill form with test data and admin url "([^"]+)"$/
     */
    public function iFillFormWithTestData($adminUrl) {
      $fieldsData = array(
        'INSTALL_DB_ADDRESS' => TEST_DB_HOST,
        'INSTALL_DB_NAME' => TEST_DB_NAME,
        'INSTALL_DB_USER' => TEST_DB_USER,
        'INSTALL_DB_PASS' => TEST_DB_PASS,
        'INSTALL_DB_PREFIX' => 'uc_',
        'INSTALL_ADMIN_PATH' => $adminUrl,
        'INSTALL_SITE_PATH' => null,
      );

      $url = $this->getMinkParameter('base_url');

      $urlData = parse_url($url);
      $path = !empty($urlData['path']) ? $urlData['path'] : '/';

      $fieldsData['INSTALL_SITE_PATH'] = $path;

      foreach ($fieldsData as $name => $value) {
        $this->fillField($name, $value);
      }

    }

    /**
     * @Given /^I test page( .+|)$/
     */
    public function iTestPage($pageUrl = false) {
      if (!empty($pageUrl)) {
        $this->visit(trim($pageUrl));
      }

      $this->assertPageNotContainsText('Error:');
    }

  }
