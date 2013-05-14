<?php
  namespace Ub\Simpleblog\Categories;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Model extends \Uc\Db\Model {

    const N = __CLASS__;

    const STATUS_DISABLED = 0;

    const STATUS_ENABLED = 1;

    public function getViewUrl() {
      return \Uc::app()->url->create('ub/simpleblog/posts/category', array(
        'catsef' => $this->sef,
        'catpk' => $this->pk(),
      ));
    }

  }