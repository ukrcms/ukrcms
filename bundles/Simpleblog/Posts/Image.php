<?php
  namespace Ub\Simpleblog\Posts;

  /**
   * @author Ivan Scherbak
   */
  class Image extends \Ub\Helper\Image\Object {

    protected $types = array(
      'main' => array(
        'w' => 600,
        'h' => 400,
      ),
      'small' => array(
        'w' => 300,
        'h' => 200,
      ),
    );

    /**
     *
     * @var string
     */
    protected $path = '/posts';

    /**
     *
     * @var integer
     */
    protected $pathLevel = 2;

  }