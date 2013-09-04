<?php
  namespace Test\Uc\Db;

  use Test\MainContext;

  class Table extends MainContext {

    const N = __CLASS__;

    protected function getTableClassName($bundleName) {
      $bundleInfo = explode(' ', $bundleName);
      if (count($bundleInfo) !== 2) {
        throw new \Exception('now valid bundle name');
      }
      return '\TestApp\\' . trim($bundleInfo[0]) . '\\' . $this->plural($bundleInfo[1]) . '\Table';
    }

    /**
     * @Given /^i clean ([a-zA-Z]+ [a-zA-Z]+)$/
     */
    public function iCleanTable($tableName) {
      $tableClassName = $this->getTableClassName($tableName);
      /** @var $table \Uc\Db\Table */
      $table = $tableClassName::instance();
      foreach ($table->fetchAll() as $item) {
        $item->delete();
      }

    }

    /**
     * @Given /^i create ([a-zA-Z]+ [a-zA-Z]+) (\d+)$/
     */
    public function iCreateUser($tableName, $id) {
      $tableClassName = $this->getTableClassName($tableName);
      /** @var $table \Uc\Db\Table */
      $table = $tableClassName::instance();
      $model = $table->createModel();
      $model->id = $id;
      $model->save();
    }

    /**
     * @Then /^i expect number of ([a-z]+ [a-z]+) (equal|not equal) (\d+)$/
     */
    public function iExpectNumberOfItems($tableName, $operatorAsText, $num) {

      $tableClassName = $this->getTableClassName($tableName);

      /** @var $table \Uc\Db\Table */
      $table = $tableClassName::instance();

      $itemsNum = count($table->fetchAll());

      switch ($operatorAsText) {
        case 'equal':
          if ($itemsNum != $num) {
            throw new \Exception('Expect ' . $num . ' current ' . $itemsNum);
          }
          break;

        case 'not equal':
          if ($itemsNum == $num) {
            throw new \Exception('Do not expect ' . $num . ' current ' . $itemsNum);
          }
          break;

        default:
          throw new \Exception('Operator not realized');
          break;
      }

    }

  }
