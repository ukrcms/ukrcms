<?php

  namespace Uc;

  class Db extends \PDO {

    const QUOTE_IDENTIFIER = '`';

    /**
     *
     * @var type
     */
    public $dsn = '';

    /**
     *
     * @var type
     */
    public $username = '';

    /**
     *
     * @var type
     */
    public $password = '';

    /**
     *
     * @var type
     */
    public $options = '';

    /**
     * @author  Ivan Scherbak <dev@funivan.com> 07/20/12
     * @var array
     */
    private $tablesCached = array();

    /**
     *
     * @var string
     */
    protected $transactionKey = '';

    /**
     *
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array  $options
     */
    public function __construct($dsn = '', $username = '', $password = '', $options = array(\PDO::ATTR_PERSISTENT => true)) {
      $this->dsn = $dsn;
      $this->username = $username;
      $this->password = $password;
      $this->options = $options;
      return $this;
    }

    /**
     * Alias of connect
     *
     * @return $this
     */
    public function init() {
      return $this->connect();
    }

    /**
     * Connect to database
     *
     * @return $this
     */
    public function connect() {
      parent::__construct($this->dsn, $this->username, $this->password, $this->options);
      $this->execute('SET NAMES UTF8');
      $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      return $this;
    }

    /**
     * Prepare query and execute
     *
     * @param string $query
     * @param array  $params
     * @return type
     */
    public function execute($query, $params = array()) {
      $stmt = $this->prepare($query);
      $stmt->execute($params);
      return $stmt;
    }

    public function fetchOne($sql, $params = array()) {
      $result = (array)$this->execute($sql, $params)->fetchAll(\PDO::FETCH_COLUMN, 0);
      return reset($result);
    }

    public function fetchRow($sql, $params = array()) {
      $result = (array)$this->execute($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
      return reset($result);
    }

    public function fetchCol($sql, $params = array()) {
      return $this->execute($sql, $params)->fetchAll(\PDO::FETCH_COLUMN, 0);
    }

    public function fetchAll($sql, $params = array()) {
      return $this->execute($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertOrUpdate($tableName, $data) {
      $set = $binds = array();

      foreach ($data as $field => $value) {
        $fieldBindName = ':' . $field;
        $set[] = "`$field` = " . $fieldBindName;
        $binds[$fieldBindName] = $value;
      }

      $dataSet = implode(', ', $set);

      $query = "INSERT INTO `" . $tableName . "` SET " . $dataSet . " ON DUPLICATE KEY UPDATE " . $dataSet;
      return $this->execute($query, $binds);
    }

    public function quoteIdentifier($value) {
      $q = self::QUOTE_IDENTIFIER;
      return ($q . str_replace("$q", "$q$q", $value) . $q);
    }

    /**
     * Smart method for transaction begin.
     * If transaction was starter early
     * it will not start at this time.
     * It is easy to understand in examples
     *
     * @param bool|string $key
     * @return boolean
     */
    public function startTransaction($key = false) {
      if ($key == false or $this->transactionKey == false) {
        $this->transactionKey = $key;
        return parent::beginTransaction();
      } else {
        return false;
      }
    }

    /**
     * Smart method to commit transaction
     *
     * @param boolean|string $key
     * @return boolean
     */
    public function endTransaction($key = false) {
      if ($key == false or $this->transactionKey == $key) {
        $this->transactionKey = false;
        return parent::commit();
      } else {
        return false;
      }
    }

    /**
     * Smart method for rollback transaction.
     * Look into examples
     *
     * @param boolean|string $key
     * @return boolean
     */
    public function rollBackTransaction($key = false) {
      if ($key == false or $this->transactionKey == $key) {
        $this->transactionKey = false;
        return parent::rollBack();
      } else {
        return false;
      }
    }

  }