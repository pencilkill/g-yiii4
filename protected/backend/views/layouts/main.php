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
<script type="text/javascript" src="<?php echo $this->skinUrl?>/javascript/jquery/main.js"></script>
<?php
    if (Yii::app()->user->loginRequiredAjaxResponse){
        Yii::app()->clientScript->registerScript('ajaxLoginRequired',
        	'jQuery("body").ajaxComplete(
                function(event, request, options) {
                    if (request.responseText == "'.Yii::app()->user->loginRequiredAjaxResponse.'") {
                        window.location.href = "'.CHtml::normalizeUrl(Yii::app()->user->loginUrl) .'";
                    }
                }
            );'
        );
    }
?>
</head>


<body>

<div id="container">
<div id="header">
  <div class="div1">
    <div class="div2"><img class="logo" src="<?php echo $this->skinUrl?>/image/logo.gif" title="<?php echo Yii::app()->name; ?>" onclick="location = '<?php echo Yii::app()->homeUrl; ?>'" /></div>
    <?php if (empty(Yii::app()->user->isGuest)) : ?>
    <div class="div3"><img class="lock" src="<?php echo $this->skinUrl?>/image/lock.png"/>&nbsp;<?php echo Yii::t('app', 'Welcome to administration panel:') . Yii::app()->user->name; ?></div>
    <?php endif; ?>
  </div>
  <?php if (empty(Yii::app()->user->isGuest)) : ?>
  <div id="menu">
  	<?php
  		/**
  		 * @example
  		 * <ul class="left">
  		 * <li id="example"><a href="http://www.google.com.hk/">Example</a>
  		 * 	<ul>
  		 * 		<li><a class="parent">SubItem<a/>
  		 * 			<ul>
  		 * 				<li><a href="http://www.google.com.hk/">SubItem</a></li>
  		 * 				<li><a href="http://www.google.com.hk/">SubItem</a></li>
  		 * 				<li><a href="http://www.google.com.hk/">SubItem</a></li>
  		 * 			</ul>
  		 * 		</li>
  		 * 		<li><a href="http://www.google.com.hk/">SubItem</a></li>
  		 * 	</ul>
  		 * </li>
  		 * <li><a href="http://www.google.com.hk/">SubItem</a></li>
  		 * </ul>
  		 */
  	?>
    <ul class="left">
      <li><a href="<?php echo Yii::app()->homeUrl; ?>"><?php echo Yii::t('nav', 'Dashboard'); ?></a></li>
      <li><a><?php echo Yii::t('nav', 'Catalog'); ?></a>
        <ul>
          <li><a href="<?php echo Yii::app()->createUrl('category/index', array()); ?>"><?php echo Yii::t('nav', 'Category'); ?></a></li>
          <li><a href="<?php echo Yii::app()->createUrl('product/index', array()); ?>"><?php echo Yii::t('nav', 'Product'); ?></a></li>
        </ul>
      </li>
	  <li><a href="<?php echo Yii::app()->createUrl('news/index', array()); ?>"><?php echo Yii::t('nav', 'News'); ?></a></li>
      <li><a href="<?php echo Yii::app()->createUrl('information/index', array()); ?>"><?php echo Yii::t('nav', 'Information'); ?></a></li>
      <li><a href="<?php echo Yii::app()->createUrl('picture/index', array()); ?>"><?php echo Yii::t('nav', 'Picture'); ?></a></li>
      <li><a href="<?php echo Yii::app()->createUrl('contact/index', array()); ?>"><?php echo Yii::t('nav', 'Contact'); ?></a></li>
      <li><a><?php echo Yii::t('nav', 'Customers'); ?></a>
        <ul>
          <li><a href="<?php echo Yii::app()->createUrl('customer/index', array()); ?>"><?php echo Yii::t('nav', 'Customer'); ?></a></li>
          <li><a href="<?php echo Yii::app()->createUrl('customerGroup/index', array()); ?>"><?php echo Yii::t('nav', 'CustomerGroup'); ?></a></li>
        </ul>
      </li>
      <li><a href="<?php echo Yii::app()->createUrl('admin/index', array()); ?>"><?php echo Yii::t('nav', 'Admin'); ?></a></li>
      <li><a><?php echo Yii::t('nav', 'System'); ?></a>
        <ul>
          <li><a href="<?php echo Yii::app()->createUrl('admin/account', array()); ?>"><?php echo Yii::t('nav', 'Account'); ?></a></li>
          <li><a href="<?php echo Yii::app()->createUrl('setting/index', array()); ?>"><?php echo Yii::t('nav', 'Setting'); ?></a></li>
          <li><a href="<?php echo Yii::app()->createUrl('setting/asset', array()); ?>"><?php echo Yii::t('nav', 'Asset'); ?></a></li>
        </ul>
      </li>
    </ul>
    <ul class="right">
      <li><a onclick="window.open('<?php echo Yii::app()->baseUrl; ?>');"><?php echo Yii::t('nav', 'Site Frontend'); ?></a></li>
      <li><a href="<?php echo Yii::app()->createUrl('site/logout', array()); ?>"><?php echo Yii::t('nav', 'Exit System'); ?></a></li>
    </ul>
	<script type="text/javascript">
		jQuery(function($) {
			route = getURLVar('r');

			if (!route) {
				$('#dashboard').addClass('selected');
			} else {
				prefix = '#menu a:regex(href, .*?[\?\&]?r[^=]*\=[^=]*';
				suffix = '[\?\&]?.*)';

				part = route.split('/');

				o = $(prefix + part.join('/') + suffix);
				try{
					do{
						o = $(prefix + part.join('/') + suffix);
						part.pop();
					}while(part.length && !o.length);
				}catch(e){
					//
				}finally{
					if(o.length){
						o.first().closest('#menu > ul > li').addClass('selected');
					}
				}
			}
		});
	</script>
  </div>
  <?php endif; ?>
</div>


<?php echo $content; ?>


</div>

<div id="footer">
	Copyright &copy; <?php echo date('Y'); ?> <a href="http://www.ozchamp.com/" rel="external" target="_blank"><?php echo Yii::t('app', 'Design Team')?></a>. All Rights Reserved.
</div><!-- footer -->

<?php $this->widget('frontend.extensions.ckeditor.CKEditorWidget'); ?>
<?php $this->widget('frontend.extensions.fancybox.EFancyBox', array('target' => null, 'config' => array())); ?>
<?php
	$this->widget('zii.widgets.jui.CJuiDatePicker',
		array(
			'flat' => false,
			'language' => Yii::app()->language,
			'options' => array(
				'showMonthAfterYear' => false,
				'showButtonPanel' => false,
				'changeYear' => true,
				'changeMonth' => true,
				'dateFormat' => 'yy-mm-dd',
				'yearRange' => '-5:+5',
				'yearSuffix' => '',
			),
			'htmlOptions' => array(
				'readonly' => 'readonly',
				'id' => 'CJuiDatePickerTemplate,.CJuiDatePicker',
				'class' => 'CJuiDatePickerTemplate',
				'name' => 'CJuiDatePickerTemplate',
				'value' => date('Y-m-d'),
				'style' => 'display:none; width: 0px; height:0px; visibility:hidden;',
	)), true);
	/*
	Yii::app()->clientScript->registerScriptFile('<?php echo $this->skinUrl?>/javascript/jquery/jquery.datepicker.TW.js', CClientScript::POS_END);
	*/
?>
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo $this->skinUrl?>/javascript/jquery/jquery.corner.js"></script>
<script type="text/javascript">$('.button, .success, .warning, .attention').corner();$('.heading').corner('top');</script>
<![endif]-->
<!--
<script type="text/javascript" src="<?php echo $this->skinUrl?>/javascript/jquery/imgpreview.full.jquery.js"></script>
<script type="text/javascript">jQuery(function($) {$('.imgPreview').imgPreview();});</script>
 -->
</body>
</html>
