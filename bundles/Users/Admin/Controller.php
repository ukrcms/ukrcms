<?php
  namespace Ub\Users\Admin;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Ub\Admin\Crud {

    protected function getConnectedTable() {
      return \Ub\Users\Table::instance();
    }
  }

