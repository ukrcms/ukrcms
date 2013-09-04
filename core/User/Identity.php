<?php
  namespace Uc\User;

  abstract class Identity extends \Uc\Component {

    const N = __CLASS__;

    public $loginRoute = null;

    public $logoutRoute = null;

    public $successLoginRoute = null;

    public $successLogoutRoute = null;

    public function __construct() {
      $this->init();
    }


    protected function getSessionKey() {
      return md5('user_id' . \Uc::app()->url->getBaseUrl());
    }

    public function getId() {
      return (isset($_SESSION[$this->getSessionKey()])) ? $_SESSION[$this->getSessionKey()] : null;
    }

    public function setId($id) {
      $_SESSION[$this->getSessionKey()] = $id;
    }

    public function deleteId() {
      unset($_SESSION[$this->getSessionKey()]);
    }

    public function isLogin() {
      return $this->getId();
    }

    public function getLoginRoute() {
      return $this->loginRoute;
    }

    public function getSuccessLoginRoute() {
      return $this->successLoginRoute;
    }

    public function getSuccessLogoutRoute() {
      return $this->successLogoutRoute;
    }

    public function getLogoutRoute() {
      return $this->logoutRoute;
    }


    /**
     * Implement this method
     *
     * @return bool
     */
    public function getUser() {
      return false;
    }

    /**
     * Implement this method
     *
     * @param $login
     * @param $password
     * @return bool
     */
    public abstract function authenticate($login, $password);

    public function getPasswordHash($password) {
      $salt = substr('$2a$10$' . md5(uniqid() . microtime()), 0, 29);
      return crypt($password, $salt);
    }

    public function checkPassword($password, $hash) {
      if (crypt($password, $hash) == $hash) {
        return true;
      } else {
        return false;
      }
    }
  }