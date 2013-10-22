<?php
  namespace Ub\Site\Pages;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Table extends \Uc\Db\Table {

    const N = __CLASS__;


    protected $modelClass = \Ub\Site\Pages\Model::N;

    protected static $pages = null;

    protected $tableName = 'pages';

    /**
     * @return \Ub\Site\Pages\Model
     */
    public function getAllFromCache() {
      if (static::$pages === null) {
        $select = static::instance()->select();
        $select->publishedIs(\Ub\Site\Pages\Model::STATUS_PUBLISHED);
        $data = $select->fetchAll();
        foreach ($data as $page) {
          static::$pages[$page->pk()] = $page;
        }
      }
      return static::$pages;
    }
  }