<?php
  namespace Ub\Site\Settings;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Table extends \Uc\Db\Table {

    const N = __CLASS__;

    protected $modelClass = \Ub\Site\Settings\Model::N;

    protected static $settings = null;

    protected $hasMultiLangTable = true;

    public function getTableName() {
      return \Uc::app()->db->tablePrefix . 'settings';
    }

    /**
     *
     * @param string $key
     * @return mixed string|null
     */
    public static function get($key) {
      if (static::$settings === null) {
        $table = static::instance();
        $query = $table->fetchAll();
        foreach($query as $data){
          static::$settings[$data->key] = $data->value;
        }

      }

      return isset(static::$settings[$key]) ? static::$settings[$key] : null;
    }

  }