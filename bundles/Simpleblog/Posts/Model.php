<?php
  namespace Ub\Simpleblog\Posts;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Model extends \Uc\Db\Model {

    const N = __CLASS__;

    /**
     *
     * @var Image
     */
    public $image = null;


    protected function init() {
      if (!empty($this->imageData)) {
        $this->image = new Image($this->imageData);
      }
      parent::init();
    }

    public function comments() {
      $commentTable = \Ub\Simpleblog\Comments\Table::instance();
      $select = $commentTable->select();
      $select->where('status = ? ', \Ub\Simpleblog\Comments\Model::STATUS_APPROVED);
      $select->where('post_id = ? ', $this->pk());
      $select->order('time', 'DESC');
      return $commentTable->fetchAll($select);
    }

    protected function beforeSave() {

      if (is_object($this->image)) {
        $newImageData = (string)$this->image;
      } else {
        $newImageData = '';
      }
      if ($newImageData != $this->imageData) {
        $this->imageData = $newImageData;
      }

      if (empty($this->date)) {
        $this->date = time();
      }
      return parent::beforeSave();
    }

    public function getViewUrl() {

      if (!empty($this->category_id)) {
        $categories = \Ub\Simpleblog\Categories\Table::instance()->getAllFromCache();
        if (!empty($categories)) {
          $category = $categories[$this->category_id];
        } else {
          $category = $this->category();
        }
        if (!empty($category)) {
          $params = array(
            'postsef' => $this->sef,
            'postpk' => $this->pk(),
            'catsef' => $category->sef,
            'catpk' => $category->pk(),
          );
          return \Uc::app()->url->create('ub/simpleblog/posts/view', $params);
        }
      }

      return '#error';
    }

    public function setFlushImage($flushImage = true) {
      if ($flushImage !== false and is_object($this->image)) {
        $this->image->delete();
        $this->image = null;
      }
    }

    public function setImage($data) {
      if (!empty($data['tmp_name'])) {
        $imageObject = new \Ub\Simpleblog\Posts\Image();
        $imageObject->save($_FILES['image']);
        $this->image = $imageObject;
      }
    }

  }