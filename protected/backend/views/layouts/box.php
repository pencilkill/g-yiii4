<?php /* @var Yii::app() Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta name="language" content="en" />
<meta name="keywords" content="<?php echo $this->pageTitle; ?>" />
<meta name="description" content="<?php echo $this->pageTitle; ?>" />
<!-- core jquery -->
<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<title><?php echo $this->pageTitle; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $this->skinUrl?>/stylesheet/stylesheet.css" />

<script type="text/javascript" src="<?php echo $this->skinUrl?>/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="<?php echo $this->skinUrl?>/javascript/jquery/superfish/js/superfish.js"></script>
<script type="text/javascript" src="<?php echo $this->skinUrl?>/javascript/jquery/main.js"></script>
<?php if(Yii::app()->user->loginRequiredAjaxResponse):?>
<script type="text/javascript">
	jQuery('body').ajaxComplete(
	        function(event, request, options) {
	            if (request.responseText == '<?php echo Yii::app()->user->loginRequiredAjaxResponse?>') {
	                window.location.href = '<?php echo CHtml::normalizeUrl(Yii::app()->user->loginUrl)?>';
	            }
	        }
	);
</script>
<?php endif;?>
<style type="text/css">
#container {
	height: auto;
}
body > #container {
	height: auto;
	min-height: 0px;
}
.box > .content {
	min-height: 0px;
}
</style>
</head>


<body>

<div id="container">


<?php echo $content; ?>


</div>

<?php $this->widget('ext.ckeditor.CKEditorWidget',array('htmlOptions'=>array('class'=>'fck'))); ?>

</body>
</html>
