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

    protected static $whereOperations = array(
      'Is' => '=',
      'Not' => '!=',
      'Gt' => '>',
      'GtEq' => '>=',
      'Lt' => '<',
      'LtEq' => '<=',
      'Like' => 'like',
    );


    protected $joinWithSelect = array();


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

    public function __toString() {
      return $this->getQuery();
    }


    /**
     * Great method for better joins
     * You can join one select with other following this syntax
     *
     * <code>
     * $postSelect->withUser()->where('name = ? ', 'funivan');
     * </code>
     *
     * This code select all posts that has user with name funivan
     * withUser is magic method.
     * Word User represent relation name from posts table;
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments) {
      if (preg_match('!^(.*)(Not|Is|Gt|GtEq|Lt|LtEq|Like)$!', $name, $params)) {
        if (count($arguments) == 0) {
          $args[0] = null;
        }
        return $this->createWhere($params[1], $params[2], $arguments[0]);
      } elseif (strpos($name, 'with') === 0) {
        $relationName = substr($name, 4);
        if (isset($this->joinWithSelect[$relationName])) {
          return $this->joinWithSelect[$relationName];
        }
        $relations = $this->table->relations();
        if (!isset($relations[$relationName])) {
          throw new \Exception('Not valid relation name: ' . $relationName);
        }

        $joinedSelect = $relations[$relationName][1]::instance()->select();
        $this->joinWithSelect[$relationName] = $joinedSelect;

        return $this->joinWithSelect[$relationName];
      }
    }

    /**
     *
     * How it works
     *
     * Use Is|Not|Gt| and other keywords in the end of the method
     *
     *
     * <code>
     * # Is: = or IN if array
     * $select->user_idIs(1); // (user_id = 1)
     * $select->user_idIs(array(1, 4, 5)); // (user_id in (1, 4, 5))
     *
     * #Not: != or NOT IN if array
     * $select->user_idNot(1); // (user_id != 1)
     * $select->user_idNot(array(1, 4, 5)); // (user_id NOT IN (1, 4, 5))
     *
     * #Gt: >
     * $select->user_idGt(1); // (user_id > 1)
     * $select->user_idGt(array(1, 4)); // (user_id > 1 OR user_id > 4 )
     * </code>
     *
     * @param $field
     * @param $operation
     * @param $values
     * @throws \Exception
     * @return $this
     */
    private function createWhere($field, $operation, $values) {

      $whereName = $field . '-' . strtolower($operation);

      if ($values === null) {
        unset($this->where[$whereName]);
        return $this;
      }
      $values = (array)$values;

      $fullFieldName = $this->tableName . '.' . $field;

      if (empty(static::$whereOperations[$operation])) {
        throw new \Exception("Unknown operation '" . $operation);
      }

      $operator = static::$whereOperations[$operation];

      $whereItems = array();

      $binds = $values;
      $valuesNum = count($values);
      if ($valuesNum > 1 and ($operator == '=' or $operator == '!=')) {
        # IN condition and NOT condition build here
        $quotesInCondition = rtrim(str_repeat('?, ', $valuesNum), ', ');
        if ($operator == '=') {
          $newOperator = 'IN';
        } else {
          $newOperator = 'NOT IN';
        }
        $whereItems[] = $fullFieldName . ' ' . $newOperator . ' (' . $quotesInCondition . ')';
      } else {

        foreach ($values as $value) {
          $whereItems[] = $fullFieldName . ' ' . $operator . ' ?';
        }

      }

      $glue = $operation == 'Not' ? 'AND' : 'OR';

      return $this->where(
        implode(' ' . $glue . ' ', $whereItems),
        $binds,
        $whereName
      );
      return $this;
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
     * @param string                $condition
     * @param array|string|int|null $value
     * @param null|string|int       $name
     * @return $this
     */
    public function where($condition, $value = null, $name = null) {
      $bindValues = is_array($value) ? $value : array($value);
      $whereData = array(
        'condition' => $condition,
        'binds' => $bindValues
      );
      if ($name !== null) {
        $this->where[$name] = $whereData;
      } else {
        $this->where[$name] = $whereData;
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
     * @param string           $field
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

    public function getQuery($prepared = false) {
      $relations = $this->table->relations();
      /** @var $table \Uc\Db\Table */
      $table = $this->table;

      foreach ($this->joinWithSelect as $name => $select) {
        # todo. make tableName alias
        $where = $select->getWhere();
        foreach ($where as $whereData) {
          $this->where($whereData['condition'], $whereData['binds']);
        }

        $relation = $relations[$name];
        if ($relation[0] == $table::RELATION_MANY_TO_MANY) {
          list($relatedTable, $relField, $currentField) = explode(', ', $relation[2]);
          $this->join('LEFT JOIN ' . $relatedTable . ' on ' . $this->tableName . '.' . $table->pk() . ' = ' . $relatedTable . '.' . $relField);
          $this->join('LEFT JOIN ' . $select->tableName . ' on ' . $select->tableName . '.' . $select->table->pk() . ' = ' . $relatedTable . '.' . $currentField);
        } else {
          throw new \Exception('@todo. implement relation join');
        }

      }

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
        $query .= 'WHERE (' . implode(') AND (', $this->getWhereConditions($prepared)) . ') ';
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
      $binds = array();

      foreach ($this->where as $whereInfo) {
        foreach ($whereInfo['binds'] as $bindValue) {
          if ($bindValue !== null) {
            $binds[] = $bindValue;
          }
        }
      }

      return $binds;
    }

    protected function getWhereConditions($prepared = false) {
      $whereConditions = array();

      if (!$prepared) {
        foreach ($this->where as $whereData) {
          $whereConditions[] = $whereData['condition'];
        }
      } else {
        foreach ($this->where as $whereData) {

          $condition = $whereData['condition'];
          foreach ($whereData['binds'] as $bindValue) {
            if ($bindValue !== null) {
              $pos = strpos($condition, '?');
              if ($pos !== false) {
                $condition = substr_replace($condition, $this->getTable()->getAdapter()->quote($bindValue), $pos, 1);
              }
            }
          }

          $whereConditions[] = $condition;
        }
      }

      return $whereConditions;
    }

    public function getWhere() {
      return $this->where;
    }

    /**
     * @return null
     */
    public function getTable() {
      return $this->table;
    }

  }

