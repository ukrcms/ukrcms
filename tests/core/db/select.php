<?php
  namespace Test\Uc\Db;

  use Test\MainContext;

  class Select extends MainContext {

    const N = __CLASS__;

    /**
     * @Then /^I (add|set) ([a-z]+) (\d+) to ([a-z]+) (\d+)$/
     */
    public function iAdd(
      $methodPrefix,
      $relationFirstName,
      $relationFirstId,
      $relationSecondName,
      $relationSecondId
    ) {

      $table1 = '\TestApp\Office\\' . $this->plural($relationFirstName) . '\Table';
      $table2 = '\TestApp\Office\\' . $this->plural($relationSecondName) . '\Table';

      $item1 = $table1::instance()->fetchOne($relationFirstId);
      $item2 = $table2::instance()->fetchOne($relationSecondId);

      if ($methodPrefix == 'set') {
        $methodName = $methodPrefix . ucfirst($relationFirstName);
      } else {
        $methodName = $methodPrefix . ucfirst($this->plural($relationFirstName));
      }

      $item2->$methodName($item1);

      if ($methodPrefix == 'set') {
        $item2->save();
      }
    }

    /**
     * @Then /^I select with ([A-Za-z]+) (\d+)$/
     */
    public function iSelectWithTags($name, $id) {
      $methodName = 'joinWith' . ucfirst($name);
      $this->select->idIs(44);
      $this->select->$methodName()->idIs($id)->statusIs(1);
    }

    /**
     * @Then /^I expect same select on build twice$/
     */
    public function iExpectSameSelectOnBuildTwice() {

      $this->select->where('a = 44');
      $this->select->where('d = ?', 12);
      $this->select->where('other = ?', 44);

      $q1 = $this->select->getQuery(true);
      $q2 = $this->select->getQuery(true);

      if ($q1 != $q2) {
        throw new \Exception('Different select');
      }

    }


    /**
     * @Then /^I expect (\d+) item[s]* of ([a-z]+) in ([a-z]+) (\d+)$/
     */
    public function iExpectItems($num, $selectWith, $maiItem, $mainId) {

      $tableName = '\TestApp\Office\\' . ucfirst($this->plural($maiItem)) . '\Table';
      $table = $tableName::instance();

      $select = $table->select();
      $select->idIs((int)$mainId);

      $withMethodName = 'joinWith' . ucfirst($selectWith);
      $relatedSelect = $select->$withMethodName();
      $relatedSelect->idNot('');

      $items = $table->fetchAll($select);

      if (count($items) != $num) {
        throw new \Exception('Not valid items num. Expect ' . $num . ' current ' . count($items));
      }
    }

    /**
     * @Then /^I expect (\d+) office ([a-z]+) with ([a-z]+)$/
     */
    public function iExpectItemsWithItems($num, $mainTableName, $selectWith) {

      $tableName = '\TestApp\Office\\' . ucfirst($mainTableName) . '\Table';
      $table = $tableName::instance();

      $withMethodName = 'joinWith' . ucfirst($selectWith);
      $select = $table->select();
      $relatedSelect = $select->$withMethodName();
      $relatedSelect->idNot('');

      $items = $table->fetchAll($select);

      if (count($items) != $num) {
        throw new \Exception('Not valid items num. Expect ' . $num . ' current ' . count($items));
      }

    }

    /**
     * @Given /^I create test data$/
     */
    public function createTestData() {

      $users = \TestApp\Office\Users\Table::instance();

      foreach ($users->fetchAll() as $model) {
        $model->removeHousesConnections();
        $model->delete();
      }

      $cars = \TestApp\Office\Cars\Table::instance();
      foreach ($cars->fetchAll() as $model) {
        $model->delete();
      }

      $houses = \TestApp\Office\Houses\Table::instance();
      foreach ($houses->fetchAll() as $model) {
        $model->delete();
      }

      $passports = \TestApp\Office\Passports\Table::instance();
      foreach ($passports->fetchAll() as $model) {
        $model->delete();
      }

      for ($i = 1; $i <= 5; $i++) {

        $item = $users->createModel();
        $item->id = $i;
        $item->name = 'User ' . $i;
        $item->age = rand(25, 30);
        $item->save();

        $item = $cars->createModel();
        $item->id = $i;
        $item->name = 'Car  ' . $i;
        $item->save();

        $item = $houses->createModel();
        $item->id = $i;
        $item->city = 'City for house  ' . $i;
        $item->save();

        $item = $passports->createModel(array(
          'id' => $i,
          'title' => 'Passport ' . $i,
          'date' => time() + rand(-10000, 10000),
        ));
        $item->save();

      }
    }

    /**
     * @Given /^I init select$/
     */
    public function iInitSelect() {
      $this->select = \TestApp\Office\Users\Table::instance()->select();
    }

    /**
     * @Given /^I expect (\d+) rows$/
     */
    public function iExpectNumberOfRows($rows) {
      $select = $this->select;
      /** @var $select \TestApp\Office\Users\Select */
      $select->pageLimit(1, 1);

      $items = $select->fetchAll();
      $currentRowsNum = $select->getFoundRows();

      if ($rows != $currentRowsNum) {
        throw new \Exception('Expect ' . $rows . ' rows. Current rows num is ' . $currentRowsNum);
      }
    }

    /**
     * @When /^I call ([a-z_0-9]+) ([a-zA-Z]+) (.*)$/
     */
    public function iCall($field, $operator, $value) {
      $methodName = $field . ucfirst($operator);
      $values = explode(', ', $value);
      foreach ($values as $index => $val) {
        if (preg_match('!^\d+$!', $val)) {
          $values[$index] = (int)$val;
        }
      }

      if (count($values) == 1) {
        $arguments = $values[0];
      } else {
        $arguments = $values;
      }
      $this->select->$methodName($arguments);
    }

    /**
     * @Then /^I expect: (.*)$/
     */
    public function iExpect($string) {
      $selectString = $this->select->getQuery(true);
      if (strpos($selectString, $string) === false) {
        throw new \Exception('Expect ' . $string . ' in string ' . $selectString);
      }
    }

    /**
     * @Then /^I don't expect: (.*)$/
     */
    public function iDoNotExpect($string) {
      $selectString = $this->select->getQuery(true);
      if (strpos($selectString, $string) !== false) {
        throw new \Exception('Do not Expect ' . $string . ' in string ' . $selectString);
      }
    }
  }
