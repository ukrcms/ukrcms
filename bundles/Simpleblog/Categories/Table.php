<?php
  namespace Ub\Simpleblog\Categories;

  use Ub\Simpleblog\Posts\Entity;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Table extends \Uc\Db\Table {

    const N = __CLASS__;

    protected static $categories = null;


    protected $modelClass = Model::N;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'categories';
    }

    public function getAll() {
      $select = $this->select();
      $select->statusIs(Model::STATUS_ENABLED);
      return $this->fetchAll($select);
    }

    public function getAllFromCache() {
      if (static::$categories === null) {
        $categoriesData = self::instance()->getAll();
        foreach ($categoriesData as $i => $category) {
          static::$categories[$category->pk()] = $category;
          unset($categoriesData[$i]);
        }
      }
      return static::$categories;
    }
  }