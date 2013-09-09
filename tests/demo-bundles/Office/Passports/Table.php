<?php
  namespace TestApp\Office\Passports;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   *
   */
  class Table extends \TestApp\Table {

    const N = __CLASS__;

    protected $modelClass = Model::N;

    protected $selectClass = Select::N;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'office_passports';
    }

    public function relations() {
      return array(
        'user' => array(
          'type' => static::RELATION_ONE_TO_MANY,
          'table' => \TestApp\Office\Users\Table::N,
          'foreignField' => 'passport_id'
        ),
      );
    }

    protected function getFields() {
      return array(
        '`title` varchar(255) NOT NULL',
        '`date` int(11) NOT NULL DEFAULT "0"'
      );
    }

  }