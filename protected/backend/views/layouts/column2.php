<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

	<?php echo $content; ?>

<script type="text/javascript">
/**
 * setting $.fn.yiiactiveform
 */
jQuery(function($){
	if($.fn.yiiactiveform){
		$.fn.yiiactiveform.defaults = $.extend($.fn.yiiactiveform.defaults, {
			inputContainer:'tr'
			//,successCssClass:'success'
		}||{});
	}
});
/**
 * tabs
 */
jQuery('#tabs a').tabs();
</script>
<?php $this->endContent(); ?>