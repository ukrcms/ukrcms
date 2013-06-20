<?php
  namespace Uc\Db;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Select {

    const N = __CLASS__;

    protected $table = null;

    protected $tableName = false;

    protected $limitStart = false;

    protected $limitItems = false;

    protected $selectCols = array();

    protected $where = array();

    protected $binds = array();

    protected $joins = array();

    protected $group = array();

    protected $having = array();

    protected $order = array();

    public function __construct($table, $adapter = null) {

      if (is_string($table)) {

        if (empty($adapter)) {
          $adapter = $this->getAdapter();
        }

        $this->table = $adapter->getTable($table);
      } else {
        $this->table = $table;
      }

      $this->tableName = $this->table->getTableName();
      $this->selectCols = array($this->tableName . '.*');

      $this->init();
    }


    protected function init() {

    }

    public function getAdapter() {
      return \Uc::app()->db;
    }


    /**
     *
     * @param mixed (array | string) $cols
     * @return $this
     */
    public function cols($cols) {
      if (is_array($cols)) {
        $this->selectCols = $cols;
      } else {
        $this->selectCols = array($cols);
      }
      return $this;
    }

    /**
     *
     * @param int $page
     * @param int $onPage
     * @return $this
     */
    public function pageLimit($page, $onPage) {
      $this->limitStart = ($page - 1) * $onPage;
      $this->limitItems = $onPage;
      return $this;
    }

    public function getPage() {
      return $this->limitStart / $this->limitItems + 1;
    }

    public function limit($start, $items) {
      $this->limitStart = $start;
      $this->limitItems = $items;
      return $this;
    }

    public function getLimitStart() {
      return $this->limitStart;
    }

    public function getLimitItems() {
      return $this->limitItems;
    }

    /**
     * @todo add where IN function
     *
     * @param string $cond
     * @param mixed  $value
     * @return $this
     */
    public function where($cond, $value = null) {
      $this->where[] = $cond;
      if ($value !== null) {
        $this->binds[] = $value;
      }
      return $this;
    }

    /**
     *
     * @param string $field
     * @return $this
     */
    public function group($field) {
      $this->group = $field;
      return $this;
    }

    /**
     *
     * @param type $joinCondition
     * @return $this
     */
    public function join($joinCondition) {
      $this->joins[] = $joinCondition;
      return $this;
    }

    /**
     *
     * @param string $field
     * @param type   $exp
     * @return $this
     */
    public function having($field, $exp) {
      $this->having[$field] = $field . $exp;
      return $this;
    }

    /**
     * Set default order
     *
     * @param type             $field
     * @param bool|\Uc\Db\type $exp
     * @return $this
     */
    public function order($field, $exp = false) {
      if (!empty($exp)) {
        $this->order['def'] = \Uc::app()->db->quoteIdentifier($field) . " " . $exp;
      } else {
        $this->order['def'] = $field;
      }
      return $this;
    }

    /**
     * Add order by field
     *
     * @param string $field
     * @param string $exp
     * @return $this
     */
    public function addOrder($field, $exp) {
      $this->order[$field] = $field . " " . $exp;
      return $this;
    }

    /**
     *
     * @return string
     */
    public function getQuery() {

      $query = 'SELECT ';

      if ($this->limitStart !== false and $this->limitItems !== false) {
        $query .= 'SQL_CALC_FOUND_ROWS ';
      }

      if (!empty($this->selectCols)) {
        $query .= implode(', ', $this->selectCols) . ' ';
      }
      $query .= 'FROM ' . $this->tableName . ' ';

      if (!empty($this->joins)) {
        $query .= implode(' ', $this->joins) . ' ';
      }

      if (!empty($this->where)) {
        $query .= 'WHERE (' . implode(') AND (', $this->where) . ') ';
      }

      if (!empty($this->group)) {
        $query .= 'GROUP BY ' . $this->group . ' ';
      }

      if (!empty($this->having)) {
        $query .= 'HAVING ' . implode(' AND ', $this->having) . ' ';
      }

      if (!empty($this->order)) {
        $query .= 'ORDER BY ' . implode(', ', $this->order) . ' ';
      }

      if ($this->limitStart !== false and $this->limitItems !== false) {
        $query .= 'LIMIT ' . $this->limitStart . ', ' . $this->limitItems;
      }

      return $query;
    }

    public function getBinds() {
      return $this->binds;
    }

  }

