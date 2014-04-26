<?php

Yii::import('frontend.extensions.image.Image_Driver');

/**
 * Manipulate images using standard methods such as resize, crop, rotate, etc.
 * This class must be re-initialized for every image you wish to manipulate.
 *
 * $Id: Image.php 3809 2008-12-18 12:48:41Z OscarB $
 *
 * @property mixed width
 * @property mixed height
 *
 *
 * @package    Image
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Image
{
    // Master Dimension
    const NONE = 1;
    const AUTO = 2;
    const HEIGHT = 3;
    const WIDTH = 4;
    // Flip Directions
    const HORIZONTAL = 5;
    const VERTICAL = 6;

    // Allowed image types
    public static $allowed_types = array
    (
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_TIFF_II => 'tiff',
        IMAGETYPE_TIFF_MM => 'tiff',
    );

    // Driver instance
    /**
     * @var Image_Driver
     */
    protected $driver;

    // Driver actions
    protected $actions = array();

    // Reference to the current image filename
    protected $image = '';

    /**
     * Creates a new Image instance and returns it.
     *
     * @param   $image string   filename of image
     * @param   $config array    non-default configurations
     * @return  Image
     */
    public static function factory($image, $config = NULL)
    {
        return new Image($image, $config);
    }

    /**
     * Creates a new image editor instance.
     *
     *
     * @param   $image string filename of image
     * @param   $config array non-default configurations
     * @throws CException
     * @return Image
     */
    public function __construct($image, $config = NULL)
    {
        static $check;

        // Make the check exactly once
        ($check === NULL) and $check = function_exists('getimagesize');

        if ($check === FALSE)
            throw new CException('image getimagesize missing');

		// Check to make sure the image exists
		// Image is not a file, maybe url ?
		if ( ! is_file($image)){
			// Assume image file path is relative
			$image=Yii::getPathOfAlias('webroot') . '/' . $image;
			if(! is_file($image)){
				// Actually not a file on server
				// We do not want to throw exception actually, cause we allawys display much more images
				if ( ! is_file($image=dirname(__FILE__) . '/no_image.jpg')){
					throw new CException('image file not found');
				}
			}
		}

		$image = strtr(realpath($image), array('\\' => '/'));

        // Disable error reporting, to prevent PHP warnings
        $ER = error_reporting(0);

        // Fetch the image size and mime type
        $image_info = getimagesize($image);

        // Turn on error reporting again
        error_reporting($ER);

        // Make sure that the image is readable and valid
        if (!is_array($image_info) OR count($image_info) < 3)
            throw new CException('image file unreadable');

        // Check to make sure the image type is allowed
        if (!isset(Image::$allowed_types[$image_info[2]]))
            throw new CException('image type not allowed');

        // Image has been validated, load it
        $this->image = array
        (
            'file' => $image,
            'width' => $image_info[0],
            'height' => $image_info[1],
            'type' => $image_info[2],
            'ext' => Image::$allowed_types[$image_info[2]],
            'mime' => $image_info['mime']
        );

        // Load configuration
        if ($config === null) {
            $this->config = array(
                'driver' => 'GD',
                'params' => array(),
            );
        } else {
            $this->config = $config;
        }

        // Set driver class name
        $driver = 'Image_' . ucfirst($this->config['driver']) . '_Driver';

        // Load the driver
        Yii::import("frontend.extensions.image.drivers.$driver");

        // Initialize the driver
        $this->driver = new $driver($this->config['params']);

        // Validate the driver
        if (!($this->driver instanceof Image_Driver))
            throw new CException('image driver must be implement Image_Driver class');
    }

    /**
     * Handles retrieval of pre-save image properties
     *
     * @param   $property string property name
     * @throws CException
     * @return  mixed
     */
    public function __get($property)
    {
        if (isset($this->image[$property])) {
            return $this->image[$property];
        } else {
            throw new CException('invalid property');
        }
    }

    /**
     * Resize an image to a specific width and height. By default, Kohana will
     * maintain the aspect ratio using the width as the master dimension. If you
     * wish to use height as master dim, set $image->master_dim = Image::HEIGHT
     * This method is chainable.
     *
     * @throws  CException
     * @param   $width integer  width
     * @param   $height integer  height
     * @param   $master integer  one of: Image::NONE, Image::AUTO, Image::WIDTH, Image::HEIGHT
     * @return  Image
     */
    public function resize($width, $height, $master = NULL)
    {
        if (!$this->valid_size('width', $width))
            throw new CException('image invalid width');

        if (!$this->valid_size('height', $height))
            throw new CException('image invalid height');

        if (empty($width) AND empty($height))
            throw new CException('image invalid dimensions');

        if ($master === NULL) {
            // Maintain the aspect ratio by default
            $master = Image::AUTO;
        } elseif (!$this->valid_size('master', $master))
            throw new CException('image invalid master');

        $this->actions['resize'] = array
        (
            'width' => $width,
            'height' => $height,
            'master' => $master,
        );

        return $this;
    }

    /**
     * Crop an image to a specific width and height. You may also set the top
     * and left offset.
     * This method is chainable.
     *
     *
     * @param   $width int  width
     * @param   $height int  height
     * @param   $top int|string  top offset, pixel value or one of: top, center, bottom
     * @param   $left int|string  left offset, pixel value or one of: left, center, right
     * @throws  CException
     * @return  Image
     */
    public function crop($width, $height, $top = 'center', $left = 'center')
    {
        if (!$this->valid_size('width', $width))
            throw new CException('image invalid width', $width);

        if (!$this->valid_size('height', $height))
            throw new CException('image invalid height', $height);

        if (!$this->valid_size('top', $top))
            throw new CException('image invalid top', $top);

        if (!$this->valid_size('left', $left))
            throw new CException('image invalid left', $left);

        if (empty($width) AND empty($height))
            throw new CException('image invalid dimensions');

        $this->actions['crop'] = array
        (
            'width' => $width,
            'height' => $height,
            'top' => $top,
            'left' => $left,
        );

        return $this;
    }

    /**
     * Allows rotation of an image by 180 degrees clockwise or counter clockwise.
     *
     * @param   $degrees int
     * @return  Image
     */
    public function rotate($degrees)
    {
        $degrees = (int)$degrees;

        if ($degrees > 180) {
            do {
                // Keep subtracting full circles until the degrees have normalized
                $degrees -= 360;
            } while ($degrees > 180);
        }

        if ($degrees < -180) {
            do {
                // Keep adding full circles until the degrees have normalized
                $degrees += 360;
            } while ($degrees < -180);
        }

        $this->actions['rotate'] = $degrees;

        return $this;
    }

    /**
     * Flip an image horizontally or vertically.
     *
     * @throws  CException
     * @param   $direction int direction
     * @return  Image
     */
    public function flip($direction)
    {
        if ($direction !== self::HORIZONTAL AND $direction !== self::VERTICAL)
            throw new CException('image invalid flip');

        $this->actions['flip'] = $direction;

        return $this;
    }

    /**
     * Change the quality of an image.
     *
     * @param $amount int quality as a percentage
     * @return  Image
     */
    public function quality($amount)
    {
        $this->actions['quality'] = max(1, min($amount, 100));
        return $this;
    }

    /**
     * Sharpen an image.
     *
     * @param   $amount int amount to sharpen, usually ~20 is ideal
     * @return  Image
     */
    public function sharpen($amount = 20)
    {
        $this->actions['sharpen'] = max(1, min($amount, 100));

        return $this;
    }

    /**
     * Grayscale an image.
     *
     * @return Image
     */
    public function grayscale()
    {
        $this->actions['grayscale'] = true;
        return $this;
    }

    public function colorize($r, $g, $b, $a)
    {
        $this->actions['colorize'] = array(
            'r' => $r,
            'g' => $g,
            'b' => $b,
            'a' => $a,
        );
    }

    /**
     * Emboss an image.
     *
     * @author parcouss
     * @param  $radius int [0..1] only for imagemagick
     * @return Image
     */
    public function emboss($radius = 1)
    {
        $this->actions['emboss'] = max(1, min($radius, 0));
        return $this;
    }

    /**
     * Negate an image.
     *
     * @author parcouss
     * @return Image
     */
    public function negate()
    {
        $this->actions['negate'] = true;
        return $this;
    }

    /**
     * Save the image to a new image or overwrite this image.
     *
     *
     * @param  $new_image bool|string  new image filename
     * @param  $chmod int  permissions for new image
     * @param  $keep_actions bool  keep or discard image process actions
     * @throws CException
     * @return  Image
     */
    public function save($new_image = false, $chmod = 0644, $keep_actions = false)
    {
        // If no new image is defined, use the current image
        empty($new_image) and $new_image = $this->image['file'];

        // Separate the directory and filename
        $dir = pathinfo($new_image, PATHINFO_DIRNAME);
        $file = pathinfo($new_image, PATHINFO_BASENAME);

        // Normalize the path
        $dir = strtr(realpath($dir), array('\\' => '/')) . '/';

        if (!is_writable($dir))
            throw new CException('image directory unwritable');

        if ($status = $this->driver->process($this->image, $this->actions, $dir, $file)) {
            if ($chmod !== FALSE) {
                // Set permissions
                @chmod($new_image, $chmod);
            }
        }

        // Reset actions. Subsequent save() or render() will not apply previous actions.
        if ($keep_actions === FALSE)
            $this->actions = array();

        return $status;
    }

	/**
	 * Save image using actions paramers as cache file
	 * @author @author Sam <mail.song.de.qiang@gmail.com> <mail.song.de.qiang@gmail.com>
	 * @see save()
	 * @return cache image relative webroot
	 */
	public function cache($new_image = FALSE){
		$cachedir = Yii::getPathOfAlias('webroot') . '/' . Yii::app()->getParams()->cacheDir . '/';

		if( ! is_dir($cachedir)){
			CFileHelper::mkdir($cachedir);
		}

		if ( ! is_writable($cachedir)){
			throw new CException('cache directory unwritable');
		}

		// If no new image is defined, create new_image
		if(empty($new_image)){
			$actions = $this->actions;

			HCArray::sortNestedArray($actions, 'ksort');

			$new_image = $cachedir . strtr(urldecode(http_build_query($actions)), array('['=>'_', '&'=>'', ']'=>'', '='=>'', '\\' => '', '/' => '')) . '__' . pathinfo($this->image['file'], PATHINFO_BASENAME);
		}else{
			$new_image = $cachedir . $new_image;
		}

		$file = pathinfo($new_image, PATHINFO_BASENAME);

		if(!is_file($new_image) && $this->driver->process($this->image, $this->actions, $cachedir, $file)){
			// Set permissions
			@chmod($new_image, 0644);
		}else if (is_file($new_image) && (filemtime($this->image['file']) > filemtime($new_image)) && $this->driver->process($this->image, $this->actions, $cachedir, $file)){
			@chmod($new_image, 0644);
		}

		return strtr($new_image, array(Yii::getPathOfAlias('webroot').'/' => ''));
	}

    /**
     * Output the image to the browser.
     *
     * @param   $keep_actions bool  keep or discard image process actions
     * @return  Image
     */
    public function render($keep_actions = FALSE)
    {
        $new_image = $this->image['file'];

        // Separate the directory and filename
        $dir = pathinfo($new_image, PATHINFO_DIRNAME);
        $file = pathinfo($new_image, PATHINFO_BASENAME);

        // Normalize the path
        $dir = strtr(realpath($dir), array('\\' => '/')) . '/';

        // Process the image with the driver
        $status = $this->driver->process($this->image, $this->actions, $dir, $file, $render = TRUE);

        // Reset actions. Subsequent save() or render() will not apply previous actions.
        if ($keep_actions === FALSE)
            $this->actions = array();

        return $status;
    }

    /**
     * Sanitize a given value type.
     *
     * @param   $type string   type of property
     * @param   $value mixed    property value
     * @return  boolean
     */
    protected function valid_size($type, & $value)
    {
        if (is_null($value))
            return TRUE;

        if (!is_scalar($value))
            return FALSE;

        switch ($type) {
            case 'width':
            case 'height':
                if (is_string($value) AND !ctype_digit($value)) {
                    // Only numbers and percent signs
                    if (!preg_match('/^[0-9]++%$/D', $value))
                        return FALSE;
                } else {
                    $value = (int)$value;
                }
                break;
            case 'top':
                if (is_string($value) AND !ctype_digit($value)) {
                    if (!in_array($value, array('top', 'bottom', 'center')))
                        return FALSE;
                } else {
                    $value = (int)$value;
                }
                break;
            case 'left':
                if (is_string($value) AND !ctype_digit($value)) {
                    if (!in_array($value, array('left', 'right', 'center')))
                        return FALSE;
                } else {
                    $value = (int)$value;
                }
                break;
            case 'master':
            	$value = (int)$value;

                if ($value !== Image::NONE AND
                    $value !== Image::AUTO AND
                        $value !== Image::WIDTH AND
                            $value !== Image::HEIGHT
                )
                    return FALSE;
                break;
        }

        return TRUE;
    }

    public function centeredpreview($width, $height)
    {
        if ($this->width / $this->height > $width / $height) {
            $res = $this->resize(null, $height);
        } else {
            $res = $this->resize($width, null);
        }
        return $res->crop($width, $height, 'center');
    }

    public function fit($width, $height)
    {
        if ($this->width / $this->height > $width / $height) {
            $res = $this->resize($width, null);
        } else {
            $res = $this->resize(null, $height);
        }
        return $res;
    }

    /**
     * Resize an image to a specific width and height. By default, Kohana will
     * maintain the aspect ratio using the width as the master dimension. If you
     * wish to use height as master dim, set $image->master_dim = Image::HEIGHT
     * This method is chainable.
     *
     * @throws  CException
     * @param   $width integer  width
     * @param   $height integer  height
     * @param   $master integer  one of: Image::NONE, Image::AUTO, Image::WIDTH, Image::HEIGHT
     * @return  Image
     */
    public function cresize($width, $height, $master = NULL)
    {
        if (!$this->valid_size('width', $width))
            throw new CException('image invalid width');

        if (!$this->valid_size('height', $height))
            throw new CException('image invalid height');

        if (empty($width) AND empty($height))
            throw new CException('image invalid dimensions');

        if ($master === NULL) {
            // Maintain the aspect ratio by default
            $master = Image::AUTO;
        } elseif (!$this->valid_size('master', $master))
            throw new CException('image invalid master');
        if ((int)$this->width > (int)$width && (int)$this->height > (int)$height)
            $this->actions['resize'] = array
            (
                'width' => $width,
                'height' => $height,
                'master' => $master,
            );

        return $this;
    }

    /**
     * Places watermark on image
     * @param string $image watermark path to png image
     * @param null $x watermark X coordinate, if not set watermark is centered
     * @param null $y watermark Y coordinate, if not set watermark is centered
     */
    public function watermark($image, $x=null, $y=null){
		// Check to make sure the image exists
		// Image is not a file, maybe url ?
		if ( ! is_file($image)){
			// Assume image file path is relative
			$image=Yii::getPathOfAlias('webroot') . '/' . $image;
			if(! is_file($image)){
				// Actually not a file on server
				// We do not want to throw exception actually, cause we allawys display much more images
				if ( ! is_file($image=dirname(__FILE__) . '/watermark.png')){
					throw new CException('image file not found');
				}
			}
		}

		$image = strtr(realpath($image), array('\\' => '/'));

		// Check watermark size
		list($width, $height) = getimagesize($image);

		if($width > $this->image['width'] || $height > $this->image['height']){
			return $this;
		}

		$image = strtr($image, array(Yii::getPathOfAlias('webroot') . '/' => ''));

        $this->actions['watermark'] = array('image'=>$image, 'x'=>$x, 'y'=>$y);

        return $this;
    }

    /**
     * Places watermark on image
     * @param string $image watermark path to png image
     * @param null $ratioX watermark X offset percent, if not set watermark is located right
     * @param null $ratioY watermark Y offset percent, if not set watermark is located bottom
     */
    public function watermarkRatio($image = 'watermark.png', $ratioX=100, $ratioY=100){
        // Check to make sure the image exists
		// Image is not a file, maybe url ?
		if ( ! is_file($image)){
			// Assume image file path is relative
			$image=Yii::getPathOfAlias('webroot') . '/' . $image;
			if(! is_file($image)){
				// Actually not a file on server
				// We do not want to throw exception actually, cause we allawys display much more images
				if ( ! is_file($image=dirname(__FILE__) . '/watermark.png')){
					throw new CException('image file not found');
				}
			}
		}

		$image = strtr(realpath($image), array('\\' => '/'));

		// Check watermark size
		list($width, $height) = getimagesize($image);

		if($width > $this->image['width'] || $height > $this->image['height']){
			return $this;
		}

		$ratioX = max(0, min(100, (int)$ratioX));
		$ratioY = max(0, min(100, (int)$ratioY));

		$deltaX = $this->image['width'] - $width;
		$deltaY = $this->image['height'] - $height;

		$x = ($deltaX * $ratioX)/100;
		$y = ($deltaY * $ratioY)/100;

		$image = strtr($image, array(Yii::getPathOfAlias('webroot') . '/' => ''));

        $this->actions['watermark'] = array('image'=>$image, 'x'=>$x, 'y'=>$y);

        return $this;
    }
} // End Image