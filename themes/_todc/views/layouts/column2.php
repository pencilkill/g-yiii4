<?php
	/**
	 * This layout is designed for fancybox.
	 * the differences between fancybox and main is that fancybox has no section 'header','footer'.
	 */
?>
<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/box'); ?>

	<?php echo $content; ?>

<script type="text/javascript">
/**
 * tabs
 */
jQuery.each(jQuery('.htabs, .vtabs'), function(i, v){
	var className = 'tabs-' + i;
	jQuery(this).addClass(className);
	jQuery('.' + className + ' a').tabs();
});
/**
 * setting $.fn.yiiactiveform
 */
if ($.fn.yiiactiveform) {
	$.fn.yiiactiveform.defaults = $.extend($.fn.yiiactiveform.defaults, {
		inputContainer : 'tr'
//		,successCssClass:'success'
		,afterValidate	: function(form, data, hasError){
			if(hasError){
				GridViewFlash('warning', '<?php echo Yii::t('app', 'Validation Failure')?>');
				return false;
			}
			return true;
		}
	} || {});
}
</script>
<?php $this->endContent(); ?>