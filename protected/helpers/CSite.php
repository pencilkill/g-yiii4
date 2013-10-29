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
			$src = Yii::app()->image->load($imageFile)->resize($width, $height, $master)->cache(false);
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


	/**
	 * mixed url, may be using for download url
	 * @param $array
	 * @return String
	 */
    public static function encodeUrl($array)
    {
        $arr = array(
            '=' => '_',
            '+' => '.'
        );

        return strtr(base64_encode(serialize($array)),$arr);
    }
    /**
	 * mixed url, may be using for download url
	 * @param $array
	 * @return Array
	 */
    public static function decodeUrl($array)
    {
        $arr = array(
            '_' => '=',
            '.' => '+'
        );

        return unserialize(base64_decode(strtr($array,$arr)));
    }
    /**
     * Rand making string from specified characters
     * @param $length
     * @return String
     */
    public static function charsGenerator($length)
    {
        $chars = '';

        // remove o,0,1,l
        $word = 'abcdefghijkmnpqrstuvwxyz-ABCDEFGHIJKLMNPQRSTUVWXYZ_23456789';

        $len = strlen($word);

        for ($i = 0; $i < $length; $i++) {
            $chars .= $word[rand() % $len];
        }

        return $chars;
    }
    /**
     * utf8 strrev, compatiable Chinese
     * @param $str
     * @return String
     */
    public static function utf8Strrev($str)
    {
        preg_match_all('/./us', $str, $ar);

        return implode('', array_reverse($ar[0]));
    }

    /**
     *
     * @param $file, Object . The upload file object.
     * @param $uploadDir, String, default null. The directory to upload file,  if set to null CSite::createUploadDirectory will be called to make a new directory.
     * @param $serialize, Bool, default false. whether to serialize the return value. if set false an relative path of upload file, otherwise an serialize object string
     * @return String
     */
    public static function uploadFile($file, $uploadDir=null, $serialize = false)
	{
        if (is_object($file) && get_class($file) == 'CUploadedFile')
        {
        	if(empty($uploadDir)){
        		$uploadDir = CSite::createUploadDirectory(null, true);
        	}
            $fileName = $file->getName();
            $fileSize = $file->getSize();
            $fileType = $file->getType();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid().'.'.$ext;

            $uploadFullFile = $uploadDir .'/'. $newFileName;
            $file->saveAs($uploadFullFile,true);// upload

            $uploadFile = strtr($uploadFullFile, array(Yii::getPathOfAlias('webroot').'/' => ''));
            if($serialize){
            	$return = new stdClass;
            	$return->name = $fileName;
            	$return->size = $fileSize;
            	$return->type = $fileType;
            	$return->file = $uploadFile;
            }
            return $serialize ? serialize($return) : $uploadfile;
        }
        return '';
	}

	/**
	 * download
	 * @param $url
	 * @param $name
	 */
	public static function download($url, $name=null){
		$url = CSite::decodeUrl($url);
       	$name = $name ? CSite::decodeUrl($name) : CSite::charsGenerator(10);
        $ext = strtolower(strrchr($name,'.'))==strtolower(strrchr($url,'.')) ? '' : strtolower(strrchr($url,'.'));
        $name = $name.$ext;


       	$ua = $_SERVER['HTTP_USER_AGENT'];
       	$filename = strtr(urlencode($name), array('+'=>'%20'));

    	header('Content-type:application');
    	if (preg_match('/MSIE/', $ua)) {
    		header('Content-Disposition: attachment; filename="' . $filename . '"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $name . '"');
		} else {
			header('Content-Disposition: attachment; filename="' . $name . '"');
		}

    	readfile($url);

    	exit();
	}
}//End of CSite