<?php

  namespace Ub\Simpleblog;

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
      $menu['Блог'] = array(
        array(
          'route' => 'ub/simpleblog/categories/admin/list',
          'text' => 'Категорії',
          'icon' => 'page'
        ),
        array(
          'route' => 'ub/simpleblog/posts/admin/list',
          'text' => 'Дописи',
          'icon' => 'page'
        ),
        array(
          'route' => 'ub/simpleblog/posts/admin/edit',
          'text' => 'Додати допис',
          'icon' => 'add_page'
        ),
        array(
          'route' => 'ub/simpleblog/comments/admin/list',
          'text' => 'Коментарі',
          'icon' => 'page'
        ),
      );

      return $menu;
    }

  }