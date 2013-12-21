<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

	<?php echo $content; ?>

<script type="text/javascript">
/**
 * tabs
 */
jQuery.each(jQuery('.htabs, .vtabs'), function(i, v){
	var addClassName = 'tabs-i-' + i;
	jQuery(this).addClass(addClassName);
	jQuery('.' + addClassName + ' a').tabs();
});
/**
 * setting $.fn.yiiactiveform
 */
if ($.fn.yiiactiveform) {
	$.fn.yiiactiveform.defaults = $.extend($.fn.yiiactiveform.defaults, {
		inputContainer : 'tr'
	// ,successCssClass:'success'
	} || {});
}
</script>
<?php $this->endContent(); ?>