<?php
  namespace Ub\Site\Pages;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Table extends \Uc\Db\Table {

    const N = __CLASS__;


    protected $modelClass = \Ub\Site\Pages\Model::N;

    protected static $pages = null;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'pages';
    }

    /**
     * @return \Ub\Site\Pages\Model
     */
    public function getAllFromCache() {
      if (static::$pages === null) {
        $select = static::instance()->select();
        $select->where('published = ? ', \Ub\Site\Pages\Model::STATUS_PUBLISHED);
        $data = static::instance()->fetchAll($select);
        foreach ($data as $page) {
          static::$pages[$page->pk()] = $page;
        }
      }
      return static::$pages;
    }
  }