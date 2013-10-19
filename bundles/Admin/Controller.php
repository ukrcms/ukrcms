<?php
  namespace Ub\Admin;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Uc\Controller {

    /**
     * @var array
     */
    public $topMenu = array();

    /**
     * @var array
     */
    public $leftMenu = array();

    public function __construct() {

      if (!$this->validateAdminRoute()) {
        throw new \Exception('Сторінка не знайдена', 404);
      }

      if (\Uc::app()->userIdentity->isLogin() == false) {
        $loginRoute = \Uc::app()->userIdentity->getLoginRoute();
        \Uc::app()->url->redirectToRoute($loginRoute);
      }

      \Uc::app()->theme->setThemeName('admin');
      $this->createMenu();
    }

    /**
     * Disable direct access to admin panel via ub/admin/index or other actions
     *
     * @return bool
     */
    protected function validateAdminRoute() {
      $adminPageUrl = \Uc::app()->url->create('ub/admin/index');
      $currentUrl = \Uc::app()->url->getAbsoluteRequestUrl();
      return (strpos($currentUrl, $adminPageUrl) === 0);
    }

    public function actionIndex() {
      $this->renderView('index');
    }

    public function createMenu() {

      if (empty(\Uc::app()->params['bundles'])) {
        return false;
      }

      $menuTypes = array(
        'leftMenu' => 'getAdminMenu',
        'topMenu' => 'getAdminTopMenu',
      );
      foreach ($menuTypes as $menuPosition => $methodName) {
        $bundles = \Uc::app()->params['bundles'];

        $menuItems = array();
        foreach ($bundles as $bundleClassName) {
          if (is_callable($bundleClassName . '::' . $methodName)) {
            $menu = call_user_func($bundleClassName . '::' . $methodName);
            $menuItems = array_merge($menuItems, $menu);
          }
        }

        $route = \Uc::app()->url->getRoute();
        foreach ($menuItems as $moduleName => $urls) {
          foreach ($urls as $k => $urlInfo) {
            if (!empty($urlInfo['route'])) {
              if ($urlInfo['route'] == $route) {
                $menuItems[$moduleName][$k]['current'] = true;
              }

              $menuItems[$moduleName][$k]['href'] = \Uc::app()->url->create($urlInfo['route']);
            }
          }
        }

        $this->$menuPosition = $menuItems;
      }

    }


  }

