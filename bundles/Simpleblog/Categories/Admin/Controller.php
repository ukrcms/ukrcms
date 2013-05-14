<?php
  namespace Ub\Simpleblog\Categories\Admin;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Ub\Admin\Crud {

    protected function getConnectedTable() {
      return \Ub\Simpleblog\Categories\Table::instance();
    }

  }

