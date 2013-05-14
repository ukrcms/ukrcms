<?php
  namespace Ub\Site\Settings\Admin;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Ub\Admin\Crud {

    protected function getConnectedTable() {
      return \Ub\Site\Settings\Table::instance();
    }

  }

