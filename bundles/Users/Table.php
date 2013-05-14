<?php
  namespace Ub\Users;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Table extends \Uc\Db\Table {

    const N = __CLASS__;

    protected $modelClass = Model::N;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'user';
    }

  }