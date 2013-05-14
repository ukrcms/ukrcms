<?php
  namespace Ub\Simpleblog\Comments\Admin;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Ub\Admin\Crud {

    protected function getConnectedTable() {
      return \Ub\Simpleblog\Comments\Table::instance();
    }
  }

