<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCImage {
	/**
	 * Image cache
	 * If imageFile is not a real file on server, default image named "no_image.jpg" which located under ext.image will be show,
	 * @param String, $imageFile
	 * @param Assoc array, $option, call image methods depend on opton's key and value.The key/value is alias to method/parameters
	 * @see ext.image
	 */
	public static function cache($imageFile, $option=array())
	{
		$imageCache = Yii::app()->image->load($imageFile);
		if(isset($option['resize'])){
			$resize=$option['resize'];
			$imageCache->resize($resize['width'], $resize['height'], isset($resize['master']) ? $resize['master'] : Image::AUTO);
		}
		if(isset($option['crop'])){
			$crop=$option['crop'];
			$imageCache->corp($crop['width'], $crop['height'], $crop['top'], $crop['left']);
		}
		if(isset($option['rotate'])){
			$rotate=$option['rotate'];
			$imageCache->rotate($rotate);
		}
		if(isset($option['flip'])){
			$flip=$option['flip'];
			$imageCache->flip($flip);
		}
		if(isset($option['quality'])){
			$quality=$option['quality'];
			$imageCache->quality($quality);
		}
		if(isset($option['sharpen'])){
			$sharpen=$option['sharpen'];
			$imageCache->sharpen($sharpen);
		}

		if(isset($option['render'])){
			$render=$option['render'];
			$src = $imageCache->render($render);
		}else if(isset($option['save'])){
			$save = $option['save'];
			$src = $imageCache->save($save);
		}else{
			$cache=isset($option['cache'])?$option['cache']:null;
			$src = $imageCache->cache($cache);
		}

		return $src;
	}

	/**
	 * image resize, cache is force to be enabled
	 * @param $imageFile
	 * @param $width
	 * @param $height
	 * @param $master
	 */
	public static function resize($imageFile, $width, $height, $master=2)
	{
		$src = strtr(strtr($imageFile, array('\\' => '/')), array(Yii::getPathOfAlias('webroot') . '/' => ''));

		if($width && $height){
			$image = Yii::app()->image->load($imageFile);

			$master = $master===NULL ? Image::AUTO : $master;

			$src = $image->resize($width, $height, $master)->cache(false);
		}

		return $src;
	}
}
?>