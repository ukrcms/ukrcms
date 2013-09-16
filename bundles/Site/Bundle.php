<?php
  namespace Ub\Site;

  /**
   */
  class Bundle {

    const N = __CLASS__;

    /**
     * @return array
     */
    public static function getAdminTopMenu() {
      $menu = array();
      $menu['Сайт'] = array(
        array(
          'route' => 'ub/site/pages/admin/list',
          'text' => 'Сторінки',
          'icon' => 'page'
        ),
        array(
          'route' => 'ub/site/metatags/admin/list',
          'text' => 'Метатеги',
          'icon' => 'page'
        ),
        array(
          'route' => 'ub/site/settings/admin/list',
          'text' => 'Налаштування',
          'icon' => 'page'
        ),
      );
      return $menu;
    }

  }