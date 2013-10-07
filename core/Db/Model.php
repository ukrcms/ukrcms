<?php
  namespace Uc\Db;

  /**
   *
   *
   * @todo   make transactions on delete
   *
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Model extends \Uc\Component {

    /**
     * For better support of the code
     */
    const N = __CLASS__;


    /**
     * Data that is stored in row
     *
     * @var array
     */
    protected $data = array();

    /**
     * Changed columns
     *
     * @var array
     */
    protected $columnChanged = array();

    /**
     * Indicate if entity is stored in db or not
     *
     * @var boolean
     */
    protected $stored = false;


    /**
     * @var \Uc\Db\Table
     */
    protected $table = null;


    /**
     *
     * @param array $data
     * @param array $config
     * @param null  $table
     */
    public function __construct(array $data = array(), $config = array(), $table = null) {

      if (!empty($table)) {
        $this->setTable($table);
      }

      if (isset($config['stored'])) {
        $this->stored = $config['stored'];
      }
      if (!empty($data)) {
        $this->setFromArray($data);
      }

      $this->init();
    }

    public function __set($name, $value) {
      if ($this->table->hasColumn($name)) {
        if (!isset($this->data[$name]) or $this->data[$name] != $value) {
          $this->columnChanged[$name] = $this->$name;
        }
        $this->data[$name] = $value;
      } else {
        $this->$name = $value;
      }
    }

    public function __isset($name) {
      if ($this->table->hasColumn($name)) {
        return true;
      }

      return ($this->table->getRelation($name) !== null);
    }

    public function __get($name) {
      if ($this->table->hasColumn($name)) {
        return isset($this->data[$name]) ? $this->data[$name] : false;
      } elseif ($this->table->getRelation($name)) {
        $this->{$name} = $this->getRelatedObject($name);
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

      if (preg_match('!^(?J)((?P<actionName>(add|set))(?P<relationName>.*))|((?P<actionName>remove)(?P<relationName>.*)Connections)$!i', $name, $info)) {

        # detect relation inf
        $relationName = $info['relationName'];
        $relation = $this->table->getRelation($relationName);
        if (empty($relation)) {
          throw new \Exception('Not valid relation name: ' . $relationName);
        }
        /** @var $table Table */
        $table = $relation['table']::instance();
        $relationType = $relation['type'];
        switch ($info['actionName']) {
          case 'remove':
            if ($relationType != $table::RELATION_MANY_TO_MANY) {
              throw new \Exception('You can flush connections only in many_to_many relations ');
            }

            $relationTableReference = $relation['reference'];

            $id = $this->pk();
            if (!empty($id)) {
              $db = $table->getAdapter();
              $q = 'DELETE FROM ' . $db->quoteIdentifier($relationTableReference['tableName']) . ' where ' . $db->quoteIdentifier($relationTableReference['myField']) . ' = ? ';
              $db->execute($q, array($id));
              return true;
            }

            return true;

            break;
          case "add":

            if ($relationType != $table::RELATION_MANY_TO_MANY) {
              throw new \Exception('You can add connections only in many_to_many relation');
            }

            if ($this->stored() !== true) {
              throw new \Exception('You can add connections only for stored models');
            }

            $models = !empty($arguments[0]) ? $arguments[0] : null;
            if ($models === null) {
              throw new \Exception('You need related models when you add connections');
            }

            if (!is_array($models)) {
              $models = array($models);
            }

            foreach ($models as $model) {
              if ($model->stored() == false) {
                throw new \Exception('Related model not stored. Save it and try again to add connections');
              }
              $relationTableReference = $relation['reference'];

              $params = array(
                $this->pk(),
                $model->pk(),
              );

              # delete relation with this model
              $q = 'DELETE FROM ' . $table->getAdapter()->quoteIdentifier($relationTableReference['tableName']) . ' WHERE ' . $table->getAdapter()->quoteIdentifier($relationTableReference['myField']) . ' = ? and ' . $table->getAdapter()->quoteIdentifier($relationTableReference['foreignField']) . ' = ? ';
              $table->getAdapter()->execute($q, $params);

              # insert id`s of two entities in many_many table
              $q = 'INSERT INTO ' . $table->getAdapter()->quoteIdentifier($relationTableReference['tableName']) . ' SET ' . $table->getAdapter()->quoteIdentifier($relationTableReference['myField']) . ' = ? , ' . $table->getAdapter()->quoteIdentifier($relationTableReference['foreignField']) . ' = ? ';
              $table->getAdapter()->execute($q, $params);

            }

            return true;
            break;

          case "set":
            if ($relationType != $table::RELATION_ONE_TO_ONE) {
              throw new \Exception('You can set relations only in one_to_one type. Current type is ' . $relationType);
            }

            if (empty($relation['myField'])) {
              throw new \Exception('myField required in relation');
            }

            $model = !empty($arguments[0]) ? $arguments[0] : null;

            if ($model === null) {
              throw new \Exception('You need related models');
            }
            if ($model->stored() == false) {
              throw new \Exception('Related model not stored. Save it first');
            }

            /** @var $model Model */
            if (get_class($model->getTable()) !== $relation['table']) {
              throw new \Exception('You can set only model created by table ' . $relation[1]);
            }

            $field = $relation['myField'];
            $this->$field = $model->pk();

            return $this;
            break;
        }

      }

      throw new \Exception('Method name not valid ' . $name);
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
     * @param $name
     * @throws \Exception
     * @return mixed
     */
    protected function getRelatedObject($name) {
      $relation = $this->table->getRelation($name);
      $tableClassName = $relation['table'];

      /** @var $table \Uc\Db\Table */
      $table = $tableClassName::instance();

      if ($relation['type'] == $table::RELATION_ONE_TO_ONE) {
        if (!empty($relation['myField'])) {
          $pkField = $this->{$relation['myField']};
          $item = $table->fetchOne($pkField);
        } else {
          $item = $table->fetchOne(array(
            $relation['foreignField'] => $this->pk()
          ));
        }
        return $item;
      } elseif ($relation['type'] == $table::RELATION_ONE_TO_MANY) {
        if (!empty($relation['foreignField'])) {
          $items = $table->fetchAll(array($relation['foreignField'] => $this->pk()));
        } else if (!empty($relation['myField'])) {
          $items = $this->table->fetchAll(array($relation['myField'] => $this->pk()));
        } else {
          throw new \Exception('Not valid relation ' . $name . ' in class ' . get_called_class() . '. Please set myField or foreignField');
        }
        return $items;
      } elseif ($relation['type'] == $table::RELATION_MANY_TO_MANY) {
        $select = $table->select();
        $relatedTableReference = $relation['reference'];
        $select->join('LEFT JOIN '
          . $relatedTableReference['tableName']
          . ' on '
          . $table->getTableName() . '.' . $table->pk()
          . ' = '
          . $relatedTableReference['tableName'] . '.' . $relatedTableReference['foreignField']
        );

        $select->where($relation['reference']['tableName'] . '.' . $relation['reference']['myField'] . ' = ? ', $this->pk());
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
      $this->runAllBehaviors('afterSave');
    }

    /**
     * Called before save
     * If return true save method invoke
     *
     * @return boolean
     */
    protected function beforeSave() {
      $this->runAllBehaviors('beforeSave');
      return true;
    }

    /**
     * Called before delete
     * If return true delete method invoke
     *
     * @return boolean
     */
    protected function beforeDelete() {
      $this->runAllBehaviors('afterDelete');
      return true;
    }

    /**
     * Called after delete
     */
    protected function afterDelete() {
      $this->runAllBehaviors('afterDelete');
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