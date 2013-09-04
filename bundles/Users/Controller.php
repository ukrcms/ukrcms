<?php
  namespace Ub\Users;

  /**
   * @author muhasjo <muhasjo@gmail.com>
   */
  class Controller extends \Ub\Site\Controller {

    /**
     *
     * @author muhasjo <muhasjo@gmail.com>
     */
    public static function actionLogout() {
      \Uc::app()->userIdentity->deleteId();
      \Uc::app()->url->redirectToRoute(\Uc::app()->userIdentity->getSuccessLogoutRoute());
    }

    public function actionLogin() {

      if (!empty(\Uc::app()->userIdentity->directAccess) and !$this->validateLoginRoute()) {
        throw new \Exception('Сторінка не знайдена', 404);
      }

      if (isset($_POST['login']) && isset($_POST['password'])) {
        \Uc::app()->userIdentity->authenticate($_POST['login'], $_POST['password']);
      }

      if (\Uc::app()->userIdentity->isLogin()) {
        \Uc::app()->url->redirectToRoute(\Uc::app()->userIdentity->getSuccessLoginRoute());
      }

      $this->render('login');
    }

    protected function validateLoginRoute() {
      $loginPageUrl = \Uc::app()->url->create(\Uc::app()->userIdentity->loginRoute);
      $currentUrl = \Uc::app()->url->getAbsoluteRequestUrl();
      return (strpos($currentUrl, $loginPageUrl) === 0);
    }
  }