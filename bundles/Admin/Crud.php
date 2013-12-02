<?php
  namespace Ub\Admin;

  /**
   * Class Crud
   * @package Ub\Admin
   */
  abstract class Crud extends Controller {

    const PAGE_VAR = 'page';

    const PAGE_ON_VAR = 'onPage';

    const PK_VAR = 'pk';

    const AJAX_VAR = 'getajax';

    /**
     * @return \Uc\Db\Table
     */
    protected abstract function getConnectedTable();

    public function actionDelete() {
      $table = $this->getConnectedTable();
      if (!empty($_GET[static::PK_VAR])) {
        $model = $table->fetchOne($_GET[static::PK_VAR]);
        $model->delete();
        \Uc::app()->url->redirect();
      } else {
        throw new \Exception('Pk is invalid');
      }
    }

    public function actionList() {

      $page = (!empty($_GET[self::PAGE_VAR]) and $_GET[self::PAGE_VAR] > 1) ? $_GET[self::PAGE_VAR] : 1;
      $onPage = (!empty($_GET[self::PAGE_ON_VAR]) and $_GET[self::PAGE_ON_VAR] > 1) ? $_GET[self::PAGE_ON_VAR] : 30;

      $table = $this->getConnectedTable();

      $select = $table->select();
      $select->pageLimit($page, $onPage);

      foreach ($_GET as $name => $value) {
        $whereCondition = strpos($name, '-w-') === 0;
        $whereLikeCondition = strpos($name, '-l-') === 0;
        if ($whereCondition or $whereLikeCondition) {
          $name = substr($name, 3);
          if (in_array(substr($value, 0, 2), array('!=', '>=', '<='))) {
            $cutFromValue = 2;
          } elseif (!empty($value) and in_array($value[0], array('=', '<', '>'))) {
            $cutFromValue = 1;
          } else {
            $cutFromValue = false;
          }

          if ($cutFromValue !== false) {
            $condition = substr($value, 0, $cutFromValue);
            if ($whereLikeCondition) {
              $condition = ($condition == '!=') ? 'NOT LIKE' : 'LIKE';
            }
            $name .= ' ' . $condition . ' ?';
            $value = substr($value, $cutFromValue);
          } else {
            $name .= !empty($whereLikeCondition) ? ' LIKE ?' : ' = ?';
          }
          $select->where($name, $value);
        }
      }

      $select->order($table->pk(), 'DESC');

      $select = $this->beforeList($select);

      $data = $table->fetchPage($select);
      $data[static::PAGE_VAR] = $page;
      $data[static::PAGE_ON_VAR] = $onPage;

      if (!$this->isUseAjax()) {
        $this->renderView('list', $data);
      } else {
        echo $this->renderViewPartial('list', $data);
      }
    }

    protected function beforeList($select) {
      return $select;
    }

    /**
     * @throws \Exception
     */
    public function actionEdit() {

      $table = $this->getConnectedTable();

      if (!empty($_GET[static::PK_VAR])) {
        $model = $table->fetchOne($_GET[static::PK_VAR]);
      } else {
        $model = $table->createModel();
      }

      if (isset($_POST['save_and_list']) or isset($_POST['save_and_edit']) or isset($_POST['data'])) {
        $this->beforeSave($model);

        $this->setModelDataFromRequest($model);

        if ($model->save()) {
          # redirect user to edit page or list

          $this->afterSave($model);

          if (isset($_POST['save_and_list'])) {
            $url = \Uc::app()->url->create(\Uc::app()->url->getControllerName() . '/list');
          } else {
            $url = \Uc::app()->url->create(\Uc::app()->url->getRoute(), array(
              'pk' => $model->pk()
            ));
          }

          \Uc::app()->url->redirect($url);
        } else {
          throw new \Exception('Can not save entity ' . get_class($this));
        }
      }

      if (!$this->isUseAjax()) {

        $this->renderView('edit', array(
          'model' => $model,
        ));
      } else {
        echo $this->renderViewPartial('edit', array(
          'model' => $model,
        ));
      }
    }

    protected function setModelDataFromRequest($model) {
      $model->setFromArray($_POST['data']);
      unset($_POST['data']);
      if (!empty($_POST['data'])) {
        $model->setFromArray($_POST['data']);
        unset($_POST['data']);
      }

      foreach ($_POST as $methodPartialName => $values) {
        $methodName = 'set' . ucfirst($methodPartialName);
        if (method_exists($model, $methodName) and is_callable(array($model, $methodName))) {
          $model->{$methodName}($values);
          unset($_POST[$methodPartialName]);
        }
      }
      if (!empty($_FILES)) {
        foreach ($_FILES as $methodPartialName => $values) {
          $methodName = 'set' . ucfirst($methodPartialName);
          if (!empty($values['tmp_name']) and method_exists($model, $methodName) and is_callable(array($model, $methodName))) {
            $model->{$methodName}($values);
            unset($_FILES[$methodPartialName]);
          }
        }
      }
    }

    protected function beforeSave($model) {

    }

    protected function afterSave($model) {

    }

    /**
     * @return bool
     */
    protected function isUseAjax() {
      return empty($_REQUEST[self::AJAX_VAR]) ? false : $_REQUEST[self::AJAX_VAR] == true;
    }
  }