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
        'category' => array(self::RELATION_ONE_TO_ONE, \Ub\Simpleblog\Categories\Table::N, 'category_id'),
        'comments' => array(self::RELATION_ONE_TO_MANY, \Ub\Simpleblog\Comments\Table::N, 'post_id'),
      );
    }

  }

