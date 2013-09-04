<?php
  namespace TestApp;

  abstract class Table extends \Uc\Db\Table {

    /**
     *  `name` varchar(255) NOT NULL,
     *  `status` tinyint(1) NOT NULL DEFAULT "0",
     * @return mixed
     */
    protected abstract function getFields();

    /**
     * Create table
     *
     */
    public function __construct() {
      $db = \Uc::app()->db;

      $fields = implode(', ', $this->getFields());
      if (!empty($fields)) {
        $fields .= ',';
      }

      $q[] = 'DROP TABLE IF EXISTS ' . $this->getTableName();
      $q[] = '
      CREATE TABLE `' . $this->getTableName() . '`
      (
        `id` int(12) NOT NULL AUTO_INCREMENT,
        ' . $fields . '
        PRIMARY KEY (`id`)
      )
      ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
      ';

      foreach ($q as $query) {
        $db->execute($query);
      }

      parent::__construct();
    }
  }