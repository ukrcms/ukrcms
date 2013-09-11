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
     * Attach behavior.
     * Set owner and init behavior
     *
     * <code>
     * public function init(){
     *  $this->image = new \Ub\Helper\Image\Object()
     *  $this->image->owner_field = 'image_data';
     *  $this->attachBehavior('image');
     * }
     * </code>
     * @param $behaviorName
     * @return $this
     */
    public function attachBehavior($behaviorName) {
      /** @var $behavior Behavior */
      $behavior = $this->$behaviorName;
      $behavior->setOwner($this);
      $behavior->init();
      $this->behaviors[$behaviorName] = $behavior;
      return $this;
    }

    /**
     * Run method in all behaviors
     * <code>
     *  $this->runAllBehaviors('beforeSave');
     * </code>
     * @todo Create test
     *
     * @param $methodName
     * @return $this
     */
    public function runAllBehaviors($methodName) {
      /** @var $behavior Behavior */
      foreach ($this->behaviors as $behavior) {
        if ($behavior->hasMethod($methodName)) {
          $behavior->$methodName();
        }
      }
      return $this;
    }

    /**
     * Remove behavior from owner
     *
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