<?php
  namespace Ub\Helper\Image;

  /**
   *
   * Author:    Jarrod Oberto
   * Version:   1.1
   *
   * Date:      17-Jan-10
   * Purpose:   Resizes and saves image
   * Requires: Requires PHP5, GD library.
   *
   * Usage Example:
   * include("classes/resize_class.php");
   * $resizeObj = new resize('images/cars/large/input.jpg');
   * $resizeObj -> resizeImage(150, 100, 0);
   * $resizeObj -> saveImage('images/cars/large/output.jpg', 100);
   *
   */

  class Resize {

    /**
     *
     * @var <type>
     */
    private $image = null;

    /**
     *
     * @var <type>
     */
    private $width = '';

    /**
     *
     * @var <type>
     */
    private $height = '';

    /**
     *
     * @var array
     */
    private $resizedImgInfo = array();

    /**
     *
     * @var array
     */
    private $sourceImgInfo = array();

    /**
     *
     * @var <type>
     */
    private $imageResized = false;

    public function __construct($fileName) {

      // *** Open up the file
      $this->image = $this->openImage($fileName);

      // *** Get width and height
      $this->width = imagesx($this->image);
      $this->height = imagesy($this->image);

      $this->sourceImgInfo['path'] = $fileName;
      $this->sourceImgInfo['w'] = $this->width;
      $this->sourceImgInfo['h'] = $this->height;
    }

    public static function resize($source, $destination, $maxW, $maxH) {
      // *** 1) Initialise / load image
      $resizeObj = new \Ub\Helper\Image\Resize($source);
      // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
      $resizeObj->resizeImage($maxW, $maxH);
      // *** 3) Save image
      $resizeObj->saveImage($destination, 100);

      return $resizeObj;
    }

    private function openImage($file) {
      // *** Get extension
      $imageInfo = getimagesize($file);
      $extension = substr(image_type_to_extension($imageInfo[2]), 1);

      $this->sourceImgInfo['ext'] = $extension;

      switch ($extension) {
        case 'jpg':
        case 'jpeg':
          $img = imagecreatefromjpeg($file);
          break;
        case 'gif':
          $img = imagecreatefromgif($file);
          break;
        case 'png':
          $img = imagecreatefrompng($file);
          break;
        default:
          $img = false;
          break;
      }
      return $img;
    }

    public function resizeImage($newWidth, $newHeight, $option = "auto") {
      // *** Get optimal width and height - based on $option
      $optionArray = $this->getDimensions($newWidth, $newHeight, $option);

      $optimalWidth = $optionArray['optimalWidth'];
      $optimalHeight = $optionArray['optimalHeight'];
      # save params to static object
      $this->resizedImgInfo['w'] = $optimalWidth;
      $this->resizedImgInfo['h'] = $optimalHeight;

      // *** Resample - create image canvas of x, y size
      $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
      imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);

      // *** if option is 'crop', then crop too
      if ($option == 'crop') {
        $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
      }
    }

    private function getDimensions($newWidth, $newHeight, $option) {

      switch ($option) {
        case 'exact':
          $optimalWidth = $newWidth;
          $optimalHeight = $newHeight;
          break;
        case 'portrait':
          $optimalWidth = $this->getSizeByFixedHeight($newHeight);
          $optimalHeight = $newHeight;
          break;
        case 'landscape':
          $optimalWidth = $newWidth;
          $optimalHeight = $this->getSizeByFixedWidth($newWidth);
          break;
        case 'auto':
          $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
          $optimalWidth = $optionArray['optimalWidth'];
          $optimalHeight = $optionArray['optimalHeight'];
          break;
        case 'crop':
          $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
          $optimalWidth = $optionArray['optimalWidth'];
          $optimalHeight = $optionArray['optimalHeight'];
          break;
      }
      return array('optimalWidth' => round($optimalWidth), 'optimalHeight' => round($optimalHeight));
    }

    private function getSizeByFixedHeight($newHeight) {
      $ratio = $this->width / $this->height;
      $newWidth = $newHeight * $ratio;
      return $newWidth;
    }

    private function getSizeByFixedWidth($newWidth) {
      $ratio = $this->height / $this->width;
      $newHeight = $newWidth * $ratio;
      return $newHeight;
    }

    private function getSizeByAuto($newWidth, $newHeight) {

      $widthRatio = $this->width / $newWidth;
      $heightRatio = $this->height / $newHeight;

      $compressRatio = max($widthRatio, $heightRatio);

      $result = array(
        'optimalWidth' => round($this->width / $compressRatio),
        'optimalHeight' => round($this->height / $compressRatio)
      );

      return $result;
    }

    private function getOptimalCrop($newWidth, $newHeight) {

      $heightRatio = $this->height / $newHeight;
      $widthRatio = $this->width / $newWidth;

      if ($heightRatio < $widthRatio) {
        $optimalRatio = $heightRatio;
      } else {
        $optimalRatio = $widthRatio;
      }

      $optimalHeight = $this->height / $optimalRatio;
      $optimalWidth = $this->width / $optimalRatio;

      return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight) {
      // *** Find center - this will be used for the crop
      $cropStartX = ($optimalWidth / 2) - ($newWidth / 2);
      $cropStartY = ($optimalHeight / 2) - ($newHeight / 2);

      $crop = $this->imageResized;
      //imagedestroy($this->imageResized);
      // *** Now crop from center to exact requested size
      $this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
      imagecopyresampled($this->imageResized, $crop, 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight, $newWidth, $newHeight);
    }

    public function saveImage($savePath, $imageQuality = "80") {
      // *** Get extension
      $extension = substr(strtolower(strrchr($savePath, '.')), 1);

      switch ($extension) {
        case 'jpg':
        case 'jpeg':
          if (imagetypes() & IMG_JPG) {
            imagejpeg($this->imageResized, $savePath, $imageQuality);
          }
          break;

        case 'gif':
          if (imagetypes() & IMG_GIF) {
            imagegif($this->imageResized, $savePath);
          }
          break;

        case 'png':
          // *** Scale quality from 0-100 to 0-9
          $scaleQuality = round(($imageQuality / 100) * 9);

          // *** Invert quality setting as 0 is best, not 9
          $invertScaleQuality = 9 - $scaleQuality;

          if (imagetypes() & IMG_PNG) {
            imagepng($this->imageResized, $savePath, $invertScaleQuality);
          }
          break;

        // ... etc

        default:
          // *** No extension - No save.
          break;
      }

      imagedestroy($this->imageResized);
    }

    public function getSourceInfo() {
      return $this->sourceImgInfo;
    }

    public function getResizedInfo() {
      return $this->resizedImgInfo;
    }

  }

