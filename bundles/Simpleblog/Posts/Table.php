<?php
  namespace Ub\Simpleblog\Posts;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Table extends \Uc\Db\Table {

    const N = __CLASS__;

    protected $modelClass = Model::N;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'posts';
    }

    public function relations() {
      return array(
        'category' => array(
          'type' => self::RELATION_ONE_TO_ONE,
          'table' => \Ub\Simpleblog\Categories\Table::N,
          'foreignField' => 'category_id'
        ),
        'comments' => array(
          'type' => self::RELATION_ONE_TO_MANY,
          'table' => \Ub\Simpleblog\Comments\Table::N,
          'myField' => 'post_id'
        ),
      );
    }

  }

