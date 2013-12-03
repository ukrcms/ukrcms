<?php

  namespace Ub\Site\Metatags;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Table extends \Uc\Db\Table {

    const N = __CLASS__;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'metatags';
    }

    protected $modelClass = \Ub\Site\Metatags\Model::N;

    public function fetchForMainPage() {
      return $this->select()->fetchOne('mainpage');
    }
  }