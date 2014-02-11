<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<meta name="keywords" content="<?php echo $this->pageTitle; ?>" />
<meta name="description" content="<?php echo $this->pageTitle; ?>" />
<!-- core jquery -->
<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<title><?php echo $this->pageTitle; ?></title>
<link rel="stylesheet" type="text/css" href="_ozman/stylesheet/stylesheet.css" />
</head>
<body>
<div id="container">
<div id="header">
  <div class="div1">
    <div class="div2"><img class="logo" src="_ozman/image/logo.gif" title="<?php echo Yii::app()->name; ?>" onclick="location = '<?php echo Yii::app()->homeUrl; ?>'" /></div>
  </div>
</div>

	<?php echo $content; ?>

</div>
<div id="footer">
	Copyright &copy; <?php echo date('Y'); ?> <a href="http://www.ozchamp.com/" rel="external" target="_blank"><?php echo Yii::t('app', 'Design Team')?></a>. All Rights Reserved.
</div>
</body>
</html>
