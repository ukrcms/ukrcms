<?php
  namespace Uc\Db;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  abstract class Table extends \Uc\Component {

    /**
     * Class name of table
     * Used for easy support. better refactoring etc
     */
    const N = __CLASS__;

    /**
     * Relation constant One to One
     */
    const RELATION_ONE_TO_ONE = 1;

    /**
     * Relation constant One to Many
     */
    const RELATION_ONE_TO_MANY = 2;

    /**
     * Relation constant Many to Many
     */
    const RELATION_MANY_TO_MANY = 3;

    /**
     * @var array
     */
    private $columns = array();

    /**
     * Primary key of the table
     */
    private $pk = false;

    protected $tableName = '';

    protected $modelClass = '';

    protected $selectClass = \Uc\Db\Select::N;

    protected static $tableInstances = array();

    public function setModelClass($modelClass) {
      $this->modelClass = $modelClass;
    }

    public function getModelClass() {
      return $this->modelClass;
    }

    public function setTableName($tableName) {
      $this->tableName = $tableName;
    }

    public function getTableName() {
      return $this->tableName;
    }

    /**
     *
     * @return array
     */
    public function relations() {

    }

    /**
     * Return relation info as array or null if relation with this name doe not exist
     * @param $name
     * @return array|null
     */
    public function getRelation($name) {
      $relations = $this->relations();
      $name = lcfirst($name);
      return isset($relations[$name]) ? $relations[$name] : null;
    }

    public function __construct() {

      $stmt = $this->getAdapter()->prepare('SHOW COLUMNS FROM ' . $this->getAdapter()->quoteIdentifier($this->getTableName()));
      $stmt->execute();
      $rawColumnData = $stmt->fetchAll();

      foreach ($rawColumnData as $columnInfo) {

        if (isset($columnInfo['Field'])) {
          $this->columns[$columnInfo['Field']] = true;
        }

        if (isset($columnInfo['Key']) and $columnInfo['Key'] == 'PRI') {
          $this->pk = $columnInfo['Field'];
        }
      }

      $this->init();
    }

    public function getAdapter() {
      return \Uc::app()->db;
    }

    /**
     * @static
     * @return $this
     */
    public static function instance() {
      $tableClass = get_called_class();
      if (empty(self::$tableInstances[$tableClass])) {
        self::$tableInstances[$tableClass] = new $tableClass();
      }
      return self::$tableInstances[$tableClass];
    }


    /**
     *
     * @return \Uc\Db\Select
     */
    public function select() {
      $selectClassName = $this->selectClass;
      return new $selectClassName($this);
    }

    /**
     *
     * @param string $columnName
     * @return boolean
     */
    public function hasColumn($columnName) {
      return isset($this->columns[$columnName]);
    }

    /**
     *
     * @return string
     */
    public function pk() {
      return $this->pk;
    }

    protected function getWhereAndParams($attributes = false) {
      if ($attributes === false) {
        return array(
          '1', array()
        );
      }

      $params = array();
      if (!is_array($attributes)) {
        $params[$this->pk . ' = '] = $attributes;
      } else {
        $params = $attributes;
      }
      $keys = array_keys($params);

      foreach ($keys as $k => $val) {
        if (strpos($val, '=') === false and strpos($val, '<') === false and strpos($val, '>') === false) {
          $val .= ' = ';
        }
        $keys[$k] = $val . ' ? ';
      }

      $where = implode('AND ', $keys);
      $bind = array_values($params);

      return array(
        $where, $bind
      );
    }

    /**
     *
     * @param $select
     * @internal param mixed $attributes
     * @return \Uc\Db\Model|null
     */
    public function fetchOne($select) {
      if ($select instanceof \Uc\Db\Select) {
        $sql = $select->getQuery();
        $params = $select->getBinds();
      } else {
        list($where, $params) = $this->getWhereAndParams($select);
        $sql = 'Select * from `' . $this->getTableName() . '` where ' . $where . ' Limit 1';
      }
      # fetch data
      $smt = $this->getAdapter()->execute($sql, $params);
      $data = $smt->fetch(\PDO::FETCH_ASSOC);

      if (empty($data)) {
        return null;
      }

      # generate config
      $config = array(
        'data' => $data,
        'stored' => true
      );

      return $this->createModel($config);
    }

    public function fetchPage($where, $currentPage = false, $onPage = false) {
      if ($where instanceof \Uc\Db\Select) {
        $query = $where->getQuery();
        $params = $where->getBinds();
        $onPage = $where->getLimitItems();
        $smt = $this->getAdapter()->execute($query, $params);
      } else {
        list($where, $params) = $this->getWhereAndParams($where);
        $smt = $this->getAdapter()->execute('Select SQL_CALC_FOUND_ROWS  * from `' . $this->getTableName() . '` where ' . $where . ' Limit ' . (($currentPage - 1) * $onPage) . ', ' . $onPage, $params);
      }

      $itemsData = $smt->fetchAll(\PDO::FETCH_ASSOC);
      $items = array();

      if (!empty($itemsData)) {
        # generate config
        foreach ($itemsData as $key => $data) {
          $config = array(
            'data' => $data,
            'stored' => true
          );

          $items[$key] = $this->createModel($config);
          unset($config, $itemsData[$key]);
        }
      }

      $rowsNum = $this->getAdapter()->query('SELECT FOUND_ROWS()')->fetchColumn();

      return array(
        'items' => $items,
        'pages' => ceil($rowsNum / $onPage),
        'rows' => $rowsNum
      );
    }

    /**
     *
     * @param mixed (string | array  | \Uc\Db\Select ) $select
     * @return \Uc\Db\Model[]
     */
    public function fetchAll($select = false) {
      if ($select instanceof \Uc\Db\Select) {
        $sql = $select->getQuery();
        $params = $select->getBinds();
      } else {
        list($where, $params) = $this->getWhereAndParams($select);
        $sql = 'Select * from `' . $this->getTableName() . '` where ' . $where;
      }

      $smt = $this->getAdapter()->execute($sql, $params);

      $entitiesRawData = $smt->fetchAll(\PDO::FETCH_ASSOC);
      $items = $this->createModels($entitiesRawData);
      unset($entitiesRawData);

      return $items;
    }

    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com> 7/20/12 9:37 PM
     * @param array $fields
     * @return mixed (boolean | integer)
     */
    public function insert($fields) {
      $set = $params = array();
      foreach ($fields as $key => $value) {
        $params[] = $value;
        $set[] = '`' . $key . '` = ? ';
      }

      $sql = 'Insert into ' . $this->getTableName() . ' Set ' . implode(', ', $set);
      $smt = $this->getAdapter()->execute($sql, $params);
      $pk = $this->getAdapter()->lastInsertId();
      $error = $smt->errorCode();

      if ($error == '00000' and empty($pk)) {
        # pk is not auto increment and record was creaded
        return true;
      } else {
        #
        return $pk;
      }
    }

    /**
     *
     * @param type $fields
     * @param type $where
     * @return type
     */
    public function update($fields, $where) {

      list($whereString, $params) = $this->getWhereAndParams($where);

      $set = array();
      foreach ($fields as $key => $value) {
        $binds[] = $value;
        $set[] = '`' . $key . '` = ? ';
      }

      $params = array_merge($binds, $params);
      $sql = 'Update `' . $this->getTableName() . '` Set ' . implode(', ', $set) . ' Where ' . $whereString . '';
      $smt = $this->getAdapter()->execute($sql, $params);
      return $smt->rowCount();
    }

    public function delete($where) {
      list($whereString, $params) = $this->getWhereAndParams($where);
      $sql = 'Delete from `' . $this->getTableName() . '`  Where ' . $whereString . '';
      $smt = $this->getAdapter()->execute($sql, $params);
      return $smt->rowCount();
    }

    /**
     * @author  Ivan Scherbak <dev@funivan.com> 7/20/12
     * @param array|\type $entitiesRawData
     * @return type
     */
    protected function createModels($entitiesRawData = array()) {
      $items = array();
      if (!empty($entitiesRawData)) {
        # generate config and init items
        foreach ($entitiesRawData as $key => $data) {
          $config = array(
            'data' => $data,
            'stored' => true
          );

          $items[$key] = $this->createModel($config);
          unset($config, $entitiesRawData[$key]);
        }
      }
      return $items;
    }

    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com> 7/20/12
     * @param array $config
     * @return \Uc\Db\Model
     */
    public function createModel($config = array()) {
      $className = $this->getModelClass();
      $object = new $className($config, $this);
      return $object;
    }

  }