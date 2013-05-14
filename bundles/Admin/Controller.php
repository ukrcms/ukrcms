<?php
  namespace Ub\Admin;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Uc\Controller {

    /**
     * @var type
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
      $this->createLeftMenu();
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


    public function createLeftMenu() {

      if (empty(\Uc::app()->params['bundles'])) {
        return false;
      }

      $bundles = \Uc::app()->params['bundles'];
      foreach ($bundles as $bundleClassName) {
        $menu = call_user_func($bundleClassName . '::getAdminMenu');
        $this->leftMenu = array_merge($this->leftMenu, $menu);
      }

      if (empty($this->leftMenu)) {
        return false;
      }

      $route = \Uc::app()->url->getRoute();
      foreach ($this->leftMenu as $moduleName => $urls) {
        foreach ($urls as $k => $urlInfo) {
          if (!empty($urlInfo['route'])) {
            if ($urlInfo['route'] == $route) {
              $this->leftMenu[$moduleName][$k]['current'] = true;
            }

            $this->leftMenu[$moduleName][$k]['href'] = \Uc::app()->url->create($urlInfo['route']);
          }
        }
      }
      return $this->leftMenu;
    }


    /**
     * Helper function for rendering files from bundles view folder
     * Used only in backend
     *
     * @param string $file
     * @param array  $data
     */
    public function renderView($file, $data = array()) {
      # render view file
      $content = $this->renderViewPartial($file, $data);
      echo $this->renderLayout($content);
    }

    public function renderLayout($content) {
      $layoutFile = \Uc::app()->theme->getLayoutFilePath();
      $layoutFileAbsolute = \Uc::app()->theme->getAbsoluteFilePath($layoutFile);
      echo $this->renderFile($layoutFileAbsolute, array('content' => $content));
    }


    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com>
     */
    public function renderViewPartial($controllerViewFile, $data = array()) {

      $controllerViewFile = 'view' . DIRECTORY_SEPARATOR . $controllerViewFile;
      $object = new \ReflectionObject($this);
      $file = dirname($object->getFilename()) . DIRECTORY_SEPARATOR . $controllerViewFile . '.php';

      return $this->renderFile($file, $data);
    }

  }

