<?php
  namespace Ub\Users;

  /**
   * @author
   */
  class Model extends \Uc\Db\Model {

    const N = __CLASS__;

    public function setNewPassword($password) {
      $this->password = \Uc::app()->userIdentity->getPasswordHash($password);
    }
  }