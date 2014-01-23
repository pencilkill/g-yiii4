<?php /* @var Yii::app() Controller */ ?>
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

<script type="text/javascript" src="_ozman/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="_ozman/javascript/jquery/superfish/js/superfish.js"></script>
<script type="text/javascript" src="_ozman/javascript/jquery/main.js"></script>
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
    <div class="div2"><img src="_ozman/image/logo.gif" style="height: 26px;" title="<?php echo Yii::app()->name; ?>" onclick="location = '<?php echo Yii::app()->homeUrl; ?>'" /></div>
    <?php if (empty(Yii::app()->user->isGuest)) : ?>
    <div class="div3"><img src="_ozman/image/lock.png" alt="" style="position: relative; top: 3px;" />&nbsp;<?php echo Yii::t('app', 'Welcome to administration panel:') . Yii::app()->user->name; ?></div>
    <?php endif; ?>
  </div>
  <?php if (empty(Yii::app()->user->isGuest)) : ?>
  <div id="menu">
  	<?php
  		/**
  		 * @example
  		 * <ul class="left" style="display: none;">
  		 * <li id="example"><a href="http://www.google.com.hk/" class="top">Example</a>
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
  		 * <li><a href="http://www.google.com.hk/" class="top">SubItem</a></li>
  		 * </ul>
  		 */
  	?>
    <ul class="left" style="display: none;">
      <li id="dashboard"><a href="<?php echo Yii::app()->homeUrl; ?>" class="top"><?php echo Yii::t('nav', 'Dashboard'); ?></a></li>
      <li id="catalog"><a class="top"><?php echo Yii::t('nav', 'Catalog'); ?></a>
        <ul>
          <li><a href="<?php echo Yii::app()->createUrl('category/index', array()); ?>"><?php echo Yii::t('nav', 'Category'); ?></a></li>
          <li><a href="<?php echo Yii::app()->createUrl('product/index', array()); ?>"><?php echo Yii::t('nav', 'Product'); ?></a></li>
        </ul>
      </li>
	  <li id="news"><a href="<?php echo Yii::app()->createUrl('news/index', array()); ?>" class="top"><?php echo Yii::t('nav', 'News'); ?></a></li>
      <li id="information"><a href="<?php echo Yii::app()->createUrl('information/index', array()); ?>" class="top"><?php echo Yii::t('nav', 'Information'); ?></a></li>
      <li id="pic"><a href="<?php echo Yii::app()->createUrl('picture/index', array()); ?>" class="top"><?php echo Yii::t('nav', 'Picture'); ?></a></li>
      <li id="contact"><a href="<?php echo Yii::app()->createUrl('contact/index', array()); ?>" class="top"><?php echo Yii::t('nav', 'Contact'); ?></a></li>
      <li id="admin"><a href="<?php echo Yii::app()->createUrl('admin/index', array()); ?>" class="top"><?php echo Yii::t('nav', 'Admin'); ?></a></li>
      <li id="system"><a class="top"><?php echo Yii::t('nav', 'System'); ?></a>
        <ul>
          <li><a href="<?php echo Yii::app()->createUrl('admin/account', array()); ?>"><?php echo Yii::t('nav', 'Account'); ?></a></li>
          <li><a href="<?php echo Yii::app()->createUrl('setting/index', array()); ?>"><?php echo Yii::t('nav', 'Setting'); ?></a></li>
        </ul>
      </li>
    </ul>
    <ul class="right">
      <li id="store"><a onclick="window.open('<?php echo Yii::app()->baseUrl; ?>');" class="top"><?php echo Yii::t('nav', 'Site Frontend'); ?></a></li>
      <li id="exit"><a class="top" href="<?php echo Yii::app()->createUrl('site/logout', array()); ?>"><?php echo Yii::t('nav', 'Exit System'); ?></a></li>
    </ul>
    <script type="text/javascript">
    jQuery(function($) {
	$('#menu > ul').superfish({
		hoverClass	 : 'sfHover',
		pathClass	 : 'overideThisToUse',
		delay		 : 0,
		animation	 : {height: 'show'},
		speed		 : 'normal',
		autoArrows   : false,
		dropShadows  : false,
		disableHI	 : false, /* set to true to disable hoverIntent detection */
		onInit		 : function(){},
		onBeforeShow : function(){},
		onShow		 : function(){},
		onHide		 : function(){}
	});

	$('#menu > ul').css('display', 'block');
});

function getURLVar(urlVarName) {
	var urlHalves = String(document.location).toLowerCase().split('?');
	var urlVarValue = '';

	if (urlHalves[1]) {
		var urlVars = urlHalves[1].split('&');

		for (var i = 0; i <= (urlVars.length); i++) {
			if (urlVars[i]) {
				var urlVarPair = urlVars[i].split('=');

				if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
					urlVarValue = urlVarPair[1];
				}
			}
		}
	}

	return urlVarValue;
}

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
				o.first().parents('li[id]').addClass('selected');
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

<?php $this->widget('frontend.extensions.ckeditor.CKEditorWidget', array('htmlOptions' => array('class'=>'fck'))); ?>
<?php $this->widget('frontend.extensions.fancybox.EFancyBox', array('target' => null, 'config' => array())); ?>
<?php
	$this->widget('zii.widgets.jui.CJuiDatePicker',
		array(
			'flat' => false,
			'language' => Yii::app()->language,
			'options' => array(
				'showButtonPanel' => false,
				'changeYear' => true,
				'changeMonth' => true,
				'dateFormat' => 'yy-mm-dd',
				'yearRange' => '-5:+5',
			),
			'htmlOptions' => array(
				'readonly' => 'readonly',
				'id' => 'CJuiDatePickerTemplate,.CJuiDatePicker',
				'class' => 'CJuiDatePickerTemplate',
				'name' => 'CJuiDatePickerTemplate',
				'value' => date('Y-m-d'),
				'style' => 'display:none; width: 0px; height:0px; visibility:hidden;',
	)), true);
?>
</body>
</html>
