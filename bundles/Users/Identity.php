<?php

  namespace Ub\Users;

  /**
   * Class Identity
   *
   * @package App\Users
   */
  class Identity extends \Uc\User\Identity {

    const N = __CLASS__;

    protected $user = null;

    public function authenticate($login, $password) {

      $userTable = Table::instance();
      $select = $userTable->select();
      $select->where('login = ?', $login);
      $user = $userTable->fetchOne($select);
      if (!empty($user) and $this->checkPassword($password, $user->password)) {
        $this->user = $user;
        $this->setId($user->pk());
        return true;
      }
      return false;
    }

    /**
     * @return bool|Users_Entity|null
     */
    public function getUser() {
      if ($this->user == null) {
        $this->user = Table::instance()->fetchOne($this->getId());
      }
      return $this->user;
    }

  }