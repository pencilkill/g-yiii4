<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

	<?php echo $content; ?>

<script type="text/javascript">
/**
 * tabs
 */
jQuery('#tabs a').tabs();
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