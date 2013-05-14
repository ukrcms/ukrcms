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
     * Relation constant One to One
     */
    const ONE_TO_ONE = 1;

    /**
     * Relation constant One to Many
     */
    const ONE_TO_MANY = 2;

    /**
     * Relation constant Many to Many
     */
    const MANY_TO_MANY = 3;

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
     * @todo make delete
     * @var array
     */
    private $deleteRelationsWithEntities = array();

    protected $table = null;

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

      $this->init();
    }

    public function __call($name, $arguments) {
      $relation = $this->relations();
      if (!empty($relation) and isset($relation[$name])) {
        return $this->getRelatedObject($relation[$name]);
      } else {
        throw new \Exception('Can not call method ' . $name . '()');
      }
    }

    public function __set($name, $value) {
      if ($this->getTable()->hasColumn($name)) {
        $this->data[$name] = $value;
        $this->columnChanged[$name] = true;
      } else {
        $this->$name = $value;
      }
    }

    public function __isset($name) {
      if ($this->getTable()->hasColumn($name)) {
        return isset($this->data[$name]);
      } else {
        return false;
      }
    }

    public function __get($name) {
      if ($this->getTable()->hasColumn($name)) {
        return isset($this->data[$name]) ? $this->data[$name] : false;
      } else {
        throw new \Exception('Can not get property ' . $name);
      }
    }

    protected function init() {

    }

    /**
     *
     * @return array
     */
    protected function relations() {

    }

    /**
     *
     * @return array
     */
    protected function rules() {

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

      $table = $tableClassName::instance();
      if ($relationParams[0] == self::ONE_TO_ONE) {
        $pkField = $this->{$relationParams[2]};
        $item = $table->fetchOne($pkField);
        return $item;
      } elseif ($relationParams[0] == self::ONE_TO_MANY) {
        $items = $table->fetchAll(array($relationParams[2] => $this->pk()));
        return $items;
      } elseif ($relationParams[0] == self::MANY_TO_MANY) {
        $select = $table->select();
        $relatedTableInfo = explode(',', $relationParams[2]);
        $select->join('left join ' . trim($relatedTableInfo[0]) . ' on ' . $relatedTableInfo[0] . '.' . trim($relatedTableInfo[2]) . '=' . $table->tableName() . '.id');
        $select->where($relatedTableInfo[0] . '.' . trim($relatedTableInfo[1]) . ' = ? ', $this->pk());
        $items = $table->fetchAll($select);
        return $items;
      }
      return false;
    }

    /**
     * In version 0.1 support only \Uc\Db\Model
     *
     * @todo make type of second params: array(attributes) or string(primary key).
     * @param string       $relationName
     * @param \Uc\Db\Model $object
     * @throws \Exception
     */
    public function addRelatedObject($relationName, $object) {
      $relation = $this->relations();
      if (!empty($relation) and isset($relation[$relationName])) {
        $this->addedRelatedEntities[$relationName][] = $object;
      } else {
        throw new \Exception('Can`t add related. Relation #' . $relationName . ' does not exists in entity #' . get_class($this));
      }
    }

    /**
     * @todo make $object as string (primary key)
     * @param string    $relationName
     * @param Uc_Entity $object
     * @throws \Exception
     */
    public function deleteRelation($relationName, $object) {
      if ($this->stored() === false) {
        throw new \Exception('Can nod delete relations. Entity is new.');
      }

      $relation = $this->relations();
      if (!empty($relation) and isset($relation[$relationName])) {
        $this->deleteRelationsWithEntities[$relationName][] = $object;
      } else {
        throw new \Exception('Can`t delete connection. Relation #' . $relationName . ' does not exists in entity #' . get_class($this));
      }
    }

    /**
     * Set data from array.
     *
     * @author  Ivan Scherbak <dev@funivan.com> 7/24/12 4:53 PM
     * @param type $data
     */
    public function setFromArray($data) {
      if (!empty($this->data)) {
        foreach ($data as $key => $value) {
          if (!isset($this->data[$key]) or $this->data[$key] != $value) {
            $this->columnChanged[$key] = true;
          }
        }

        $this->data = array_merge($this->data, $data);
      } else {
        $this->data = $data;
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

        if (!empty($this->deleteRelationsWithEntities)) {
          $this->deleteEntityRelations();
        }

        if (!empty($this->columnChanged) or $this->stored == false) {

          $table = $this->getTable();

          # insert or update

          if ($this->stored) {
            # do Update of entity
            $pk = $this->pk();
            $fields = array_intersect_key($this->data, $this->columnChanged);
            $result = $this->getTable()->update($fields, $pk);
          } else {
            # do Insert of entity
            $result = $this->getTable()->insert($this->data);

            if ($result != false) {
              # set primary key for entity
              /*
               * @todo update full data for Entity.
               * For example we have fields id, name, title, date
               * date is set automaticaly with database engine
               * if we make insert in future we whant to get date
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

        $this->saveRelatedEntities();
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
        $adapter = $this->getTable()->getAdapter();
        $adapter->startTransaction($transactionKey);

        if ($this->stored != true) {
          throw new \Exception('Can not delete ' . get_class($this) . 'becourse it is not stored in database');
        }

        if (!$this->beforeDelete()) {
          $adapter->endTransaction($transactionKey);
          return false;
        }

//        $this->deleteAllRelations();
//        $this->deleteEntityRelations();

        $result = $this->getTable()->delete($this->pk());

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
     * Delete all entity relations by default
     * or only from $relationsNames array
     *
     * @param array $relationsNames
     */
    public function deleteAllRelations($relationsNames = array()) {
      $deleteRelationsKeys = array_keys($this->relations());

      if (!empty($relationsNames)) {
        $deleteRelationsKeys = array_intersect($relationsNames, $deleteRelationsKeys);
      }

      foreach ($deleteRelationsKeys as $relationName) {

        $relatedItems = $this->$relationName();
        if (!is_array($relatedItems)) {
          $relatedItems = array($relatedItems);
        }

        foreach ($relatedItems as $item) {
          if ($item instanceof \Uc\Db\Model) {
            $this->deleteRelation($relationName, $item);
          }
        }
      }
    }

    /**
     * Delete only relations with entities. Not entities
     * Default relation key is 0
     *
     *
     * @throws \Exception
     */
    private function deleteEntityRelations() {
      $defaultRelationKey = 0;

      $entityRelations = $this->relations();
      foreach ($this->deleteRelationsWithEntities as $relationName => $relatedItems) {
        foreach ($relatedItems as $relatedIndex => $relatedItem) {

          $relationInfo = $entityRelations[$relationName];

          switch ($relationInfo[0]) {
            case self::MANY_TO_MANY:
              # delete many to many relations

              $relatedTableInfo = explode(',', $relationInfo[2]);
              $manyToManyTable = trim($relatedTableInfo[0]);
              $params = array(
                $this->pk(),
                $relatedItem->pk(),
              );

              # delete relation with this model
              $q = 'DELETE FROM `' . $manyToManyTable . '` WHERE ' . trim($relatedTableInfo[1]) . ' = ? and ' . trim($relatedTableInfo[2]) . ' = ? ';
              \Uc::app()->db->execute($q, $params);

              break;
            case self::ONE_TO_ONE:
            case self::ONE_TO_MANY:

              # get relative field name and clean it in
              # connected model
              $cleanRelatedField = $relationInfo[2];
              if ($relatedItem->$cleanRelatedField == $this->pk()) {
                $relatedItem->$cleanRelatedField = $defaultRelationKey;
                $relatedItem->save();
              } else {
                throw new \Exception('Entity #' . get_class($relatedItem) . ' is not connected to #' . get_class($this));
              }
              break;
            default :
              throw new \Exception('Relation type is not supported');
              break;
          }

          //@todo delete cache of relation entities for $relationName
          # connection deleted
          unset($this->deleteRelationsWithEntities[$relationName][$relatedIndex]);
        }
      }
    }

    /**
     * Main item is stored.
     * Save related entities and connection
     *
     * @throws \Exception
     */
    private function saveRelatedEntities() {
      $entityRelations = $this->relations();
      foreach ($this->addedRelatedEntities as $relationName => $relatedItems) {
        foreach ($relatedItems as $relatedIndex => $relatedItem) {

          $relationInfo = $entityRelations[$relationName];

          switch ($relationInfo[0]) {
            case self::MANY_TO_MANY:
              # save related item
              $relatedItem->save();
              # save many to many relations

              $relatedTableInfo = explode(',', $relationInfo[2]);
              $manyToManyTable = trim($relatedTableInfo[0]);
              $params = array(
                $this->pk(),
                $relatedItem->pk(),
              );

              # delete relation with this model
              $q = 'DELETE FROM `' . $manyToManyTable . '` WHERE ' . trim($relatedTableInfo[1]) . ' = ? and ' . trim($relatedTableInfo[2]) . ' = ? ';
              \Uc::app()->db->execute($q, $params);

              # insert id`s of two entities in many_many table
              $q = 'INSERT INTO `' . $manyToManyTable . '` SET ' . trim($relatedTableInfo[1]) . ' = ? , `' . trim($relatedTableInfo[2]) . '` = ? ';
              \Uc::app()->db->execute($q, $params);
              break;
            case self::ONE_TO_MANY:
            case self::ONE_TO_ONE:
              # for related entity set primary key pf current object
              # this two models now connected
              $relatedEntityFieldName = $relationInfo[2];
              $relatedItem->$relatedEntityFieldName = $this->pk();
              $relatedItem->save();
              break;

            default :
              throw new \Exception('Relation type is not supported');
              break;
          }

          //@todo delete cache of relation entities for $relationName
          # connection create. Unset from addRelated
          unset($this->addedRelatedEntities[$relationName][$relatedIndex]);
        }
      }
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
     * @return mixed (integer | string)
     */
    public function pk() {
      return isset($this->data[$this->getTable()->pk()]) ? $this->data[$this->getTable()->pk()] : false;
    }

  }