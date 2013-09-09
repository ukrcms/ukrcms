<?php

  namespace Uc;

  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Component {

    protected $behaviors = array();

    /**
     * Component initialization put here
     */
    public function init() {

    }

    /**
     * Attach behavior
     * <code>
     * public function init(){
     *  $this->image = new \Ub\Helper\Image\Object($this)
     *  $this->attachBehavior('image');
     * }
     * </code>
     * @param $behaviorName
     * @return $this
     */
    public function attachBehavior($behaviorName) {
      $this->behaviors[$behaviorName] = $this->$behaviorName;
      return $this;
    }

    /**
     * <code>
     *  $this->removeBehavior('image');
     * </code>
     * @param $behaviorName
     * @return $this
     */
    public function removeBehavior($behaviorName) {
      unset($this->behaviors[$behaviorName]);
      return $this;
    }

  }