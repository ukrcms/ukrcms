<?php
  namespace Ub\Simpleblog\Posts\Admin;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Ub\Admin\Crud {

    protected function getConnectedTable() {
      return \Ub\Simpleblog\Posts\Table::instance();
    }

  }

