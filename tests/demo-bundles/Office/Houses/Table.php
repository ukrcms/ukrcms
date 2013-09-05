<?php
  namespace TestApp\Office\Houses;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Table extends \TestApp\Table {

    const N = __CLASS__;

    protected $modelClass = Model::N;

    protected $selectClass = Select::N;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'office_houses';
    }

    public function relations() {
      return array(
        'users' => array(
          'type' => static::RELATION_MANY_TO_MANY,
          'table' => \TestApp\Office\Users\Table::N,
          'reference' => array(
            'tableName' => 'uc_office_users_houses',
            'myField' => 'house_id',
            'foreignField' => 'user_id',
          )
        ),
      );
    }

    protected function getFields() {
      return array(
        '`city` varchar(255) NOT NULL',
      );
    }

  }