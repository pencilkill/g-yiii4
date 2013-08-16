<?php
/**
 * Site helper class.
 *
 * @author     Sam@ozchamp.net
 * @copyright  www.ozchamp.net
 */
class CSite {
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
			$imageCache->resize($resize['width'], $resize['height'], isset($resize['master'])?$resize['master']:2);
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
	 * @param String $directory
	 */
	public static function createUploadDirectory($directory=null, $full=false){
		if(empty($directory)){
			$directory = Yii::app()->getParams()->uploadDir.'/'.date('Y/m/d');
		}
		$directory = trim($directory, '\/');

		$fullDirectory = Yii::getPathOfAlias('webroot').'/'.$directory;
		is_dir($fullDirectory) || mkdir($fullDirectory, true, 0777);

		return $full ? $fullDirectory : $directory;
	}

	/**
	 * create a image upload clip e.g. image file
	 * @see ext.ajaxuplod.AjaxImageUploadWidget
	 * @param $params
	 */
	public static function ajaxImageUpload($params = array()){
		return Yii::app()->getController()->widget('frontend.extensions.ajaxupload.AjaxImageUploadWidget', $params, true);
	}

	/**
	 * create a file upload clip e.g. pdf file
	 * @see ext.ajaxupload.AjaxFileUploadWidget
	 * @param $params
	 */
	public static function ajaxFileUpload($params = array()){
		return Yii::app()->getController()->widget('frontend.extensions.ajaxupload.AjaxFileUploadWidget', $params, true);
	}
}//End of CSite