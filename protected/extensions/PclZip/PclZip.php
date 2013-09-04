<?php
/**
 * Defined PCLZIP_TEMPORARY_DIR
 * Nothing further
 * @author Sam, sam@ozchamp.net
 */
  if (!defined('PCLZIP_TEMPORARY_DIR')) {
  	$pclzip_temporary_dir = Yii::getPathOfAlias('webroot').'/assets/pclzip/temp/';
  	if(! (is_dir($pclzip_temporary_dir) && is_writeable($pclzip_temporary_dir))){
  		mkdir($pclzip_temporary_dir, 0777, true);
  	}
    define( 'PCLZIP_TEMPORARY_DIR', $pclzip_temporary_dir);
  }
  require_once __DIR__.'/pclzip.lib.php';
