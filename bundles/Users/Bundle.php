<?php
  namespace Ub\Users;

  /**
   * @author  Ivan Scherbak <dev@funivan.com> 7/26/12 AM
   */
  class Bundle {

    const N = __CLASS__;


    /**
     *
     * @author  Ivan Scherbak <dev@funivan.com> 7/26/12
     * @return array
     */
    public static function getAdminMenu() {
      $menu = array();

      $menu['Користувачі'] = array(
        array(
          'route' => 'ub/users/admin/list',
          'text' => 'Всі користувачі',
          'icon' => 'icon users'
        ),
        array(
          'route' => 'ub/users/admin/edit',
          'text' => 'Додати користувача ',
          'icon' => 'icon add_user',
        )
      );

      return $menu;
    }

  }