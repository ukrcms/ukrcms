<?php

  namespace Ub\Site\Settings;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Model extends \Uc\Db\Model {

    const N = __CLASS__;

    public function getViewUrl() {
      return \Uc::app()->url->create('ub/pages/view', array('sef' => $this->sef));
    }

  }