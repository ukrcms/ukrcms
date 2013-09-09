<?php
  namespace Uc\Db;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Select extends \Uc\Component {

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


    public function __construct(Table $table) {

      $this->table = $table;

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
     * $postSelect->joinWithUsers()->where('name = ? ', 'funivan');
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
      } elseif (strpos($name, 'joinWith') === 0) {
        $relationName = lcfirst(substr($name, 8));
        if (isset($this->joinWithSelect[$relationName])) {
          return $this->joinWithSelect[$relationName];
        }

        $relation = $this->table->getRelation($relationName);
        if (empty($relation)) {
          throw new \Exception('Not valid relation name: ' . $relationName . ' in table ' . get_class($this->table));
        }

        $joinedSelect = $relation['table']::instance()->select();
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
    protected function createWhere($field, $operation, $values) {

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

    public function getAdapter() {
      return $this->table->getAdapter();
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
        $this->where[] = $whereData;
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
        $this->order['_def'] = \Uc::app()->db->quoteIdentifier($field) . " " . $exp;
      } else {
        $this->order['_def'] = $field;
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
     * Return sql query
     *
     * @param bool $prepared
     * @return string
     */
    public function getQuery($prepared = false) {

      $query = 'SELECT ';

      if ($this->limitStart !== false and $this->limitItems !== false) {
        $query .= 'SQL_CALC_FOUND_ROWS ';
      }

      if (!empty($this->selectCols)) {
        $query .= implode(', ', $this->selectCols) . ' ';
      }
      $query .= 'FROM ' . $this->tableName . ' ';

      $joins = $this->getJoins();
      if (!empty($joins)) {
        $query .= implode(' ', $joins) . ' ';
      }

      $where = $this->getWhereConditions($prepared);
      if (!empty($where)) {
        $query .= 'WHERE (' . implode(') AND (', $where) . ') ';
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

    protected function getJoins() {
      /** @var $table \Uc\Db\Table */
      $table = $this->table;
      $db = $table->getAdapter();
      $relations = $table->relations();

      $joins = $this->joins;
      foreach ($this->joinWithSelect as $name => $select) {

        $relation = $relations[$name];

        if ($relation['type'] == $table::RELATION_MANY_TO_MANY) {
          $relatedTableReference = $relation['reference'];
          $joins[] = 'LEFT JOIN ' . $db->quoteIdentifier($relatedTableReference['tableName'])
            . ' on ' . $this->tableName . '.' . $table->pk() . ' = ' . $relatedTableReference['tableName'] . '.' . $relatedTableReference['myField'];
          $joins[] = 'LEFT JOIN ' . $db->quoteIdentifier($select->tableName) . ' on ' . $select->tableName . '.' . $select->table->pk() . ' = ' . $relatedTableReference['tableName'] . '.' . $relatedTableReference['foreignField'];

        } elseif ($relation['type'] == $table::RELATION_ONE_TO_MANY) {
          if (!empty($relation['foreignField'])) {
            $joins[] = 'LEFT JOIN ' . $db->quoteIdentifier($select->getTableName()) . ' on ' . $this->tableName . '.' . $table->pk() . ' = ' . $select->getTableName() . '.' . $relation['foreignField'];
          } else {
            $joins[] = 'LEFT JOIN ' . $db->quoteIdentifier($select->getTableName()) . ' on ' . $this->tableName . '.' . $table->pk() . ' = ' . $select->getTableName() . '.' . $relation['myField'];
          }

        } elseif ($relation['type'] == $table::RELATION_ONE_TO_ONE) {
          if (!empty($relation['myField'])) {
            $joins[] = 'LEFT JOIN ' . $db->quoteIdentifier($select->getTableName()) . ' on ' . $this->tableName . '.' . $relation['myField'] . ' = ' . $select->getTableName() . '.' . $table->pk();
          } else {
            $joins[] = 'LEFT JOIN ' . $db->quoteIdentifier($select->getTableName()) . ' on ' . $this->tableName . '.' . $table->pk() . ' = ' . $select->getTableName() . '.' . $relation['foreignField'];
          }
        } else {
          throw new \Exception('Not valid relation type');
        }

      }

      return $joins;
    }

    public function getBinds() {
      $binds = array();
      $where = array_values($this->where);
      foreach ($this->joinWithSelect as $select) {
        foreach ($select->getWhere() as $whereData) {
          $where[] = $whereData;
        }
      }
      foreach ($where as $whereInfo) {
        foreach ($whereInfo['binds'] as $bindValue) {
          if ($bindValue !== null) {
            $binds[] = $bindValue;
          }
        }
      }

      return $binds;
    }

    public function fetchOne() {
      return $this->getTable()->fetchOne($this);
    }

    public function fetchAll() {
      return $this->getTable()->fetchAll($this);
    }

    protected function getWhereConditions($prepared = false) {
      $whereConditions = array();

      $where = array_values($this->where);
      foreach ($this->joinWithSelect as $select) {
        foreach ($select->getWhere() as $whereData) {
          $where[] = $whereData;
        }
      }

      if (!$prepared) {
        foreach ($where as $whereData) {
          $whereConditions[] = $whereData['condition'];
        }
      } else {
        foreach ($where as $whereData) {

          $condition = $whereData['condition'];
          foreach ($whereData['binds'] as $bindValue) {
            if ($bindValue !== null) {
              $pos = strpos($condition, '?');
              if ($pos !== false) {
                $condition = substr_replace($condition, $this->table->getAdapter()->quote($bindValue), $pos, 1);
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
     * @return Table
     */
    public function getTable() {
      return $this->table;
    }

    /**
     * @return string
     */
    public function getTableName() {
      return $this->tableName;
    }

  }

