<?php
  namespace Ub\Helper\Image;

  /**
   * @author Ivan Scherbak
   */
  class Object {

    const DEFAULT_TYPE = 'main';

    protected $types = array(
      'main' => array(
        'w' => 2000,
        'h' => 2000,
      )
    );

    /**
     *
     * @var mixed (integer | string)
     */
    protected $uid = '';

    /**
     *
     *
     * @var string
     */
    protected $extension = '';

    /**
     *
     * @var string
     */
    protected $name = '';

    /**
     *
     * @var string
     */
    protected $path = '';

    /**
     *
     * @var integer
     */
    protected $pathLevel = 2;

    /**
     *
     * @var string
     */
    protected $currentType = self::DEFAULT_TYPE;

    /**
     *
     * @var array
     */
    protected $sizes = array();

    /**
     * @param null $data
     */
    public function __construct($data = null) {
      if (!empty($data)) {
        $this->setClassData($data);
      }
      $this->init();
    }

    public function __call($name, $arguments) {
      if (isset($this->types[$name])) {
        $this->currentType = $name;
        return $this;
      } else {
        throw new \Exception('Method ' . $name . ' can not be call');
      }
    }


    public function __toString() {
      return $this->getClassData();
    }

    public function init() {

    }

    protected function setClassData($data) {
      if (!empty($data)) {
        $filesNames = unserialize($data);
        foreach ($filesNames as $index => $value) {
          $this->$index = $value;
        }
      }
    }

    protected function getClassData() {
      $result = array();
      foreach (array('uid', 'name', 'extension', 'pathLevel', 'path', 'sizes') as $name) {
        $result[$name] = $this->$name;
      }
      return serialize($result);
    }


    /**
     *
     * @param mixed (boolean | string) $niceUrl
     * @return string
     */
    private function fileStr($niceUrl = false) {
      $type = $this->currentType;

      $this->uid = str_pad($this->uid, $this->pathLevel, '0', STR_PAD_LEFT);

      if (empty($niceUrl)) {
        $fileStr = $this->uid . '_' . $type . '.' . $this->extension;
      } else {
        $fileStr = $this->uid . '_' . $type . DIRECTORY_SEPARATOR . $niceUrl . '.' . $this->extension;
      }

      $subStr = '';

      for ($i = 1; $i <= $this->pathLevel; $i++) {
        $subStr .= substr($this->uid, $i * -1, 1) . DIRECTORY_SEPARATOR;
      }

      return $this->path . DIRECTORY_SEPARATOR . $subStr . $fileStr;
    }

    public function loadImageData($imgData) {
      $this->extension = pathinfo($imgData['name'], PATHINFO_EXTENSION);
      $this->name = preg_replace('!.([a-z]+)$!', '', $imgData['name']);
    }

    /**
     *
     * @param array $imgData
     * @return $this
     */
    public function save($imgData) {
      if (empty($this->uid)) {
        $this->uid = md5(microtime(true) . uniqid(md5(serialize($imgData)) . rand(0, 1000)));
      }

      if (!empty($this->name)) {
        $this->delete();
      }

      $this->loadImageData($imgData);
      $this->createImageDir();

      foreach ($this->types as $type => $sizes) {
        $this->currentType = $type;
        $fileName = $this->getPath();
        $imageObject = Resize::resize($imgData['tmp_name'], $fileName, $sizes['w'], $sizes['h']);
        $this->sizes[$type] = $imageObject->getResizedInfo();
      }

      $this->currentType = self::DEFAULT_TYPE;

      return $this;
    }

    public function createImageDir() {
      # set file info from source
      $mainImagePath = dirname($this->getPath());
      if (!is_dir($mainImagePath)) {
        mkdir($mainImagePath, 0777, true);
      }
    }

    public function delete() {
      foreach ($this->types as $type => $sizes) {
        $this->currentType = $type;
        $fileName = $this->getPath();
        if (is_file($fileName)) {
          unlink($fileName);
        }
      }
      return true;
    }

    public function setPath($path) {
      return $this->path = $path;
    }

    public function getUrl($niceUrl = false) {
      return \Uc::app()->url->getUrl() . \Uc::app()->params['filesPath'] . $this->fileStr($niceUrl);
    }

    public function getPath() {
      return \Uc::app()->params['basePath'] . \Uc::app()->params['filesPath'] . $this->fileStr();
    }

    public function getWidth() {
      return $this->sizes[$this->currentType]['w'];
    }

    public function getHeight() {
      return $this->sizes[$this->currentType]['h'];
    }

    public function getExtension() {
      return $this->extension;
    }

    /**
     * @return mixed
     */
    public function getUid() {
      return $this->uid;
    }

    /**
     * @return string
     */
    public function getName() {
      return $this->name;
    }

  }