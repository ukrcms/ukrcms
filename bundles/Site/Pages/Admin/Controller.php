<?php
  namespace Ub\Site\Pages\Admin;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Controller extends \Ub\Admin\Crud {

    protected function getConnectedTable() {
      return \Ub\Site\Pages\Table::instance();
    }

    public function getPageTemplates(){
      \Uc::app()->theme->getModuleFilePath();
    }
  }

