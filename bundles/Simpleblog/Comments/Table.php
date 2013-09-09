<?php
  namespace Ub\Simpleblog\Comments;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Table extends \Uc\Db\Table {

    const N = __CLASS__;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'comments';
    }

    public function getModelClass() {
      return Model::N;
    }

    public function relations() {
      return array(
        'post' => array(
          'type' => self::RELATION_ONE_TO_ONE,
          'table' => \Ub\Simpleblog\Posts\Table::N,
          'myField' => 'post_id'
        )
      );
    }

  }