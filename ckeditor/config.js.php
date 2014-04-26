<?php error_reporting(E_ALL ^E_NOTICE);ini_set('display_errors', 0);header('content-type: application/x-javascript');?>
<?php
/**

This is an example for app which is not under webroot,
e.g webroot/admin/index.php
ckeditor aways works well for app which is under webroot directly
e.g webroot/index.php

Notice: both the ckeditor and ckfinder are customized to compatibel with relative url
please check both of them by comparing the original version if you have any question

<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../ckeditor/adapters/jquery.js"></script>
<script type="text/javascript">CKEDITOR.config.customConfig = '../ckeditor/config.js.php?base=../&YiiApp=<?php echo Yii::app()->id?>'</script>
*/
?>
<?php
	$base = '';
	if(isset($_GET['base'])){
		$base = $_GET['base'];
		unset($_GET['base']);
	}

	$uri = $_GET ? '&' . http_build_query($_GET) : '';
?>
/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function( config ) {
	/*
	Define changes to default configuration here. For example:
	config.language = 'fr';
	config.uiColor = '#AADC6E';
	*/
	config.baseHref = '<?php echo $base?>';
	config.basePath = '<?php echo $base?>ckeditor/';
	config.filebrowserBrowseUrl = '<?php echo $base?>ckfinder/ckfinder.html.php<?php echo $uri?>';
	config.filebrowserImageBrowseUrl = '<?php echo $base?>ckfinder/ckfinder.html.php?Type=Images<?php echo $uri?>';
	config.filebrowserFlashBrowseUrl = '<?php echo $base?>ckfinder/ckfinder.html.php?Type=Flash<?php echo $uri?>';
	config.filebrowserUploadUrl = '<?php echo $base?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files<?php echo $uri?>';
	config.filebrowserImageUploadUrl = '<?php echo $base?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images<?php echo $uri?>';
	config.filebrowserFlashUploadUrl = '<?php echo $base?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash<?php echo $uri?>';
};