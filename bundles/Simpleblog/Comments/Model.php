<?php
  namespace Ub\Simpleblog\Comments;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Model extends \Uc\Db\Model {

    const N = __CLASS__;

    const STATUS_PENDING = 0;

    const STATUS_APPROVED = 1;

    const STATUS_DELETED = 2;


    protected function relations() {
      return array(
        'post' => array(self::ONE_TO_ONE, \Ub\Simpleblog\Posts\Table::N, 'post_id')
      );
    }

    public static function getStatusDescription() {
      return array(
        self::STATUS_PENDING => 'На модерації',
        self::STATUS_APPROVED => 'Дозволені',
        self::STATUS_DELETED => 'Видалені',
      );
    }

    public function getCommentHtml() {
      return nl2br($this->comment);
    }

    /**
     *
     * @return boolean
     */
    protected function beforeSave() {
      # automatically approve comments from good users
      if (!empty($this->email) and !$this->stored()) {
        $previousComment = $this->getTable()->fetchOne(array('email' => $this->email));
        if (!empty($previousComment) and $previousComment->status == self::STATUS_APPROVED) {
          # previous comment is approved so user is good
          $this->status = self::STATUS_APPROVED;
        }
      }

      $this->comment = strip_tags($this->comment);

      if (empty($this->time)) {
        $this->time = time();
      }

      return parent::beforeSave();
    }

  }