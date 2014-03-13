<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCUploader {
	/**
	 * @param String $directory
	 */
	public static function createUploadDirectory($directory=null, $full=false){
		if(empty($directory)){
			$directory = Yii::app()->getParams()->uploadDir.'/'.date('Y/m/d');
		}
		$directory = trim($directory, '\/');

		$fullDirectory = Yii::getPathOfAlias('webroot').'/'.$directory;
		is_dir($fullDirectory) || CFileHelper::mkdir($fullDirectory);

		return $full ? $fullDirectory : $directory;
	}

	/**
     *
     * @param $file, Object . The upload file object.
     * @param $uploadDir, String, default null. The directory to upload file,  if set to null HCUploader::createUploadDirectory will be called to make a new directory.
     * @param $serialize, Bool, default false. whether to serialize the return value. if set false, function returns an relative path of upload file, otherwise a serialized object string
     * @return String
     */
    public static function uploadFile($file, $uploadDir=null, $serialize = false)
	{
        if (is_object($file) && ($file instanceof CUploadedFile)) {
        	if(empty($uploadDir)){
        		$uploadDir = HCUploader::createUploadDirectory(null, true);
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

        return null;
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
	 * Get server upload limit based on upload_max_filesize, post_max_size
	 */

	public static function maxUploadSize(){
		$sets = array(
			'upload_max_filesize',
			'post_max_size',
			'memory_limit'
		);


		$maxUploadSize = ini_get(array_pop($sets));

		foreach($sets as $set){
			if(HCFile::toBytes($maxUploadSize) > HCFile::toBytes(ini_get($set))){
				$maxUploadSize = ini_get($set);
			}
		}

		return $maxUploadSize;
	}
}
?>