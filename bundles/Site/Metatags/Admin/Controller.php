<?php

  namespace Ub\Site\Metatags\Admin;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Ub\Admin\Crud {

    protected function getConnectedTable() {
      return \Ub\Site\Metatags\Table::instance();
    }

  }

