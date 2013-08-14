<?php
  namespace Uc\Db;

  /**
   *
   *
   * @todo   make transactions on delete
   *
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Model {

    /**
     * For better support of the code
     */
    const N = __CLASS__;


    /**
     * Data that is stored in row
     *
     * @var array
     */
    private $data = array();

    /**
     * Changed columns
     *
     * @var array
     */
    private $columnChanged = array();

    /**
     * Indicate if entity is stored in db or not
     *
     * @var boolean
     */
    private $stored = false;

    /**
     * Array of entities that will be saved and
     */
    private $addedRelatedEntities = array();

    /**
     * @var \Uc\Db\Table
     */
    protected $table = null;

    /**
     *
     * @var array
     */
    private $relationsCache = array();

    /**
     *
     * @param array $config
     * @param null  $table
     */
    public function __construct($config = array(), $table = null) {

      if (!empty($table)) {
        $this->setTable($table);
      }

      if (isset($config['stored'])) {
        $this->stored = $config['stored'];
      }
      if (!empty($config['data'])) {
        $this->setFromArray($config['data']);
      }

      $this->relationsCache = $this->table->relations();
      $this->init();
    }

    public function __set($name, $value) {
      if ($this->table->hasColumn($name)) {
        $this->data[$name] = $value;
        $this->columnChanged[$name] = $this->$name;
      } else {
        $this->$name = $value;
      }
    }

    public function __isset($name) {
      if ($this->table->hasColumn($name)) {
        return true;
      }
      $relations = $this->table->relations();
      if (isset($relations[$name])) {
        return true;
      }
      return false;
    }

    public function __get($name) {
      if ($this->table->hasColumn($name)) {
        return isset($this->data[$name]) ? $this->data[$name] : false;
      } elseif (isset($this->relationsCache[$name])) {
        $this->{$name} = $this->getRelatedObject($this->relationsCache[$name]);
        return $this->{$name};
      }
      throw new \Exception('Can not get property ' . $name);
    }


    /**
     * New call
     * You can add/flush/set model relations
     *
     * @param $name
     * @param $arguments
     * @return bool
     * @throws \Exception
     */
    public function __call($name, $arguments) {

      if (preg_match('!^(set|add|flush)(.*)$!', $name, $info)) {

        //@todo rewrite relation getter

        # detect relation inf
        $relationName = $info[2];
        $relations = $this->getTable()->relations();
        if (!isset($relations[$relationName])) {
          throw new \Exception('Not valid relation name');
        }
        $relation = $relations[$relationName];
        /** @var $table Table */
        $table = $relation[1]::instance();
        $relationType = $relation[0];
        switch ($info[1]) {
          case 'flush':
            if ($relationType != $table::RELATION_MANY_TO_MANY) {
              throw new \Exception('You can flush connections only in many_to_many relations ');
            }

            $relationTablesInfo = explode(', ', $relation[2]);

            $id = $this->pk();
            if (!empty($id)) {
              $db = $table->getAdapter();

              $q = 'DELETE FROM' . $db->quoteIdentifier($relationTablesInfo[0]) . ' where ' . $db->quoteIdentifier($relationTablesInfo[1]) . ' = ? ';
              $db->execute($q, array($id));
              return true;
            }

            return true;

            break;
          case "add":

            if ($relationType != $table::RELATION_MANY_TO_MANY) {
              throw new \Exception('You can add connections only to many_to_many');
            }

            if ($this->stored() !== true) {
              throw new \Exception('You can add/delete connections only for stored models');
            }

            $models = !empty($arguments[0]) ? $arguments[0] : null;
            if ($models === null) {
              throw new \Exception('You need related models');
            }

            if (!is_array($models)) {
              $models = array($models);
            }

            foreach ($models as $model) {
              if ($model->stored() == false) {
                throw new \Exception('Related model not stored');
              }
              $relationTablesInfo = explode(', ', $relation[2]);

              $params = array(
                $this->pk(),
                $model->pk(),
              );
              # delete relation with this model
              $q = 'DELETE FROM `' . $relationTablesInfo[0] . '` WHERE ' . trim($relationTablesInfo[1]) . ' = ? and ' . trim($relationTablesInfo[2]) . ' = ? ';
              $table->getAdapter()->execute($q, $params);

              # insert id`s of two entities in many_many table
              $q = 'INSERT INTO `' . $relationTablesInfo[0] . '` SET ' . trim($relationTablesInfo[1]) . ' = ? , `' . trim($relationTablesInfo[2]) . '` = ? ';
              $table->getAdapter()->execute($q, $params);

            }

            return true;
            break;

          case "set":
            if ($relationType != $table::RELATION_ONE_TO_MANY and $relationType != $table::RELATION_ONE_TO_ONE) {
              throw new \Exception('You can set relations only one_to_one or one_to_many relations');
            }

            $model = !empty($arguments[0]) ? $arguments[0] : null;

            if ($model === null) {
              throw new \Exception('You need related models');
            }
            if ($model->stored() == false) {
              throw new \Exception('Related model not stored. Save it first');
            }

            /** @var $model Model */
            if (get_class($model->getTable()) !== $relation[1]) {
              throw new \Exception('You can set only model created by table ' . $relation[1]);
            }

            $field = $relation[2];
            $this->$field = $model->pk();
            return $this;
            break;
        }

      }

      throw new \Exception('Method name not valid ' . $name);
    }


    protected function init() {

    }

    /**
     * @return \Uc\Db\Table
     */
    public function getTable() {
      return $this->table;
    }

    public function setTable($table) {
      $this->table = $table;
    }

    /**
     * @param $relationParams
     * @return mixed
     */
    private function getRelatedObject($relationParams) {
      $tableClassName = $relationParams[1];

      /** @var $table \Uc\Db\Table */
      $table = $tableClassName::instance();

      if ($relationParams[0] == $table::RELATION_ONE_TO_ONE) {
        $pkField = $this->{$relationParams[2]};
        $item = $table->fetchOne($pkField);
        return $item;
      } elseif ($relationParams[0] == $table::RELATION_ONE_TO_MANY) {
        $items = $table->fetchAll(array($relationParams[2] => $this->pk()));
        return $items;
      } elseif ($relationParams[0] == $table::RELATION_MANY_TO_MANY) {
        $select = $table->select();
        $relatedTableInfo = explode(',', $relationParams[2]);
        $select->join('left join ' . trim($relatedTableInfo[0]) . ' on ' . $relatedTableInfo[0] . '.' . trim($relatedTableInfo[2]) . '=' . $table->getTableName() . '.id');
        $select->where($relatedTableInfo[0] . '.' . trim($relatedTableInfo[1]) . ' = ? ', $this->pk());
        $items = $table->fetchAll($select);
        return $items;
      }
      return false;
    }

    /**
     * Set data from array.
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     * @param array $data
     */
    public function setFromArray($data) {
      foreach ($data as $key => $value) {
        if ($this->table->hasColumn($key)) {
          if (isset($this->data[$key]) and $this->data[$key] != $value) {
            $this->columnChanged[$key] = $this->$key;
          }
          $this->data[$key] = $value;
        } else {
          $this->$key = $value;
        }
      }
    }

    /**
     * @param $key
     * @return null
     */
    public function getInitialValue($key) {
      if ($this->stored() == false) {
        return null;
      }
      if (isset($this->columnChanged[$key])) {
        return $this->columnChanged[$key];
      } else {
        return null;
      }
    }


    public function save() {

      if (!$this->beforeSave()) {
        return false;
      }

      # begin transaction
      $transactionKey = md5(microtime() . rand(0, 10)) . get_class($this);
      try {

        \Uc::app()->db->startTransaction($transactionKey);

        if (!empty($this->columnChanged) or $this->stored == false) {

          $table = $this->table;

          # insert or update

          if ($this->stored) {
            # do Update of entity
            $pk = $this->pk();
            $fields = array_intersect_key($this->data, $this->columnChanged);
            $result = $this->table->update($fields, $pk);
          } else {
            # do Insert of entity
            $result = $this->table->insert($this->data);

            if ($result != false) {
              # set primary key for entity
              /*
               * @todo update full data for Entity.
               * For example we have fields id, name, title, date
               * date is set automatically with database engine
               * if we make insert in future we want to get date
               * for this entity.
               * So we need to set date for this model
               * Look up to zend db
               */

              # Primary key can be set from modules.
              $pk = $table->pk();
              if (empty($this->$pk)) {
                $this->$pk = $result; # last insert id
              }
            }
          }

          if ($result) {
            # make entity new state
            $this->stored = true;
            $this->columnChanged = array();
          } else {
            throw new \Exception('Can not save entity ' . get_class($this));
          }
        }

        # end transaction
        // @todo make rollback
        \Uc::app()->db->endTransaction($transactionKey);
      } catch (\Exception $exc) {
        echo $exc->getMessage() . "\n";
        echo $exc->getTraceAsString();
      }
      $this->afterSave();
      return true;
    }

    public function delete() {
      try {

        # begin transaction
        $transactionKey = md5(microtime() . rand(0, 10)) . get_class($this);
        $adapter = $this->table->getAdapter();
        $adapter->startTransaction($transactionKey);

        if ($this->stored != true) {
          throw new \Exception('Can not delete ' . get_class($this) . 'because it is not stored in database');
        }

        if (!$this->beforeDelete()) {
          $adapter->endTransaction($transactionKey);
          return false;
        }

        $result = $this->table->delete($this->pk());

        $this->afterDelete();

        # done. all is ok. item is saved
        $adapter->endTransaction($transactionKey);
        return $result;
      } catch (\Exception $exc) {
        echo $exc->getMessage() . "\n";
        echo $exc->getTraceAsString();
        die();
      }
    }

    protected function afterSave() {

    }

    /**
     * Called before save
     * If return true save method invoke
     *
     * @return boolean
     */
    protected function beforeSave() {
      return true;
    }

    /**
     * Called before delete
     * If return true delete method invoke
     *
     * @return boolean
     */
    protected function beforeDelete() {
      return true;
    }

    /**
     * Called after delete
     */
    protected function afterDelete() {

    }


    /**
     * Method used out from entity
     * to indicate if entity is stored in database
     *
     * @return boolean
     */
    public function stored() {
      return $this->stored;
    }

    /**
     * Return primary key value of entity
     *
     * @return mixed (integer | string | boolean)
     */
    public function pk() {
      return isset($this->data[$this->table->pk()]) ? $this->data[$this->table->pk()] : false;
    }

  }