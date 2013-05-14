<?php
  namespace Ub\Site\Pages;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Model extends \Uc\Db\Model {

    const N = __CLASS__;

    const STATUS_DRAFT = 0;

    const STATUS_PUBLISHED = 1;

    public function getViewUrl() {
      if (Controller::MAIN_PAGE_SEF == $this->sef) {
        return \Uc::app()->url->create('ub/site/pages/mainpage');
      } else {
        return \Uc::app()->url->create('ub/site/pages/view', array('sef' => $this->sef));
      }
    }

  }