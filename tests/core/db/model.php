<?php
  namespace Test\Uc\Db;

  use Test\MainContext;

  class Model extends MainContext {

    const N = __CLASS__;

    /**
     * @Then /^I expect ([a-z]+) (\d+) has (\d+) ([A-Za-z]+)$/
     */
    public function iExpectObjectHas($name, $id, $number, $relation) {
      $table = '\TestApp\Office\\' . $this->plural($name) . '\Table';
      $item = $table::instance()->fetchOne($id);
      $related = $item->$relation;

      $number = intval($number);

      if ($number == 0) {
        if (!empty($related)) {
          throw new \Exception('Expect zero ' . $relation);
        }
        return true;
      }

      if ($number == 1) {
        if (!is_object($related)) {
          throw new \Exception('Expect related object ' . $relation);
        }
        return true;
      }

      if (!is_array($related)) {
        throw new \Exception('Expect several related object');
      }

      if (count($related) != $number) {
        throw new \Exception('Expect ' . $number . ' of ' . $relation . '. Current is ' . count($related));
      }

    }

  }
