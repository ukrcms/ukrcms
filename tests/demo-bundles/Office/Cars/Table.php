<?php
  namespace TestApp\Office\Cars;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   *
   */
  class Table extends \TestApp\Table {

    const N = __CLASS__;

    protected $modelClass = Model::N;

    protected $selectClass = Select::N;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'office_cars';
    }

    public function relations() {
      return array(
        'user' => array(
          'type' => static::RELATION_ONE_TO_ONE,
          'table' => \TestApp\Office\users\Table::N,
          'myField' => 'user_id'
        ),
      );
    }

    protected function getFields() {
      return array(
        '`name` varchar(255) NOT NULL',
        '`user_id` int(255) NOT NULL', // Вказує кому належить автомобіль.
      );
    }

  }