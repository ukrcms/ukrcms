<?php
  namespace TestApp\Office\Users;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   *
   * @method removeHousesConnections()
   *
   */
  class Table extends \TestApp\Table {

    const N = __CLASS__;

    protected $modelClass = Model::N;

    protected $selectClass = Select::N;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'office_users';
    }

    public function relations() {
      return array(
        'passport' => array(
          'type' => static::RELATION_ONE_TO_ONE,
          'table' => \TestApp\Office\Passports\Table::N,
          'foreignField' => 'passport_id' # field passport_id located in Users table NOT IN Users tab;e
        ),
        'cars' => array(
          'type' => static::RELATION_ONE_TO_MANY,
          'table' => \TestApp\Office\Cars\Table::N,
          'myField' => 'user_id' # field user_id located in Cars
        ),
        'houses' => array(
          'type' => static::RELATION_MANY_TO_MANY,
          'table' => \TestApp\Office\Houses\Table::N,
          'reference' => array(
            'tableName' => \Uc::app()->db->tablePrefix . 'office_users_houses',
            'myField' => 'user_id',
            'foreignField' => 'house_id',
          )
        ),
      );
    }

    protected function getFields() {
      return array(
        '`name` varchar(255) NOT NULL',
        '`age` tinyint(2) NOT NULL DEFAULT "0"',
        '`passport_id` int(11) NOT NULL',
      );
    }

    public function __construct() {

      $q[] = 'DROP TABLE IF EXISTS uc_office_users_houses';
      $q[] = '
      CREATE TABLE `uc_office_users_houses`
      (
        `id` int(12) NOT NULL AUTO_INCREMENT,
        `user_id` int(12) NOT NULL,
        `house_id` int(12) NOT NULL,

        PRIMARY KEY (`id`)
      )
      ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
      ';

      foreach ($q as $query) {
        \Uc::app()->db->execute($query);
      }
      parent::__construct();
    }

  }