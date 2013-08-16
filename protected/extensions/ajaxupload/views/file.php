<div style="border: 1px solid #EEEEEE; padding: 10px; display: inline-block;">
<?php echo CHtml::activeHiddenField($model, $attribute, $htmlOptions);?>
<?php if(!empty($preview)):?>
<a href="<?php echo $preview?>" taget="_blank" alt="" id="<?php echo $prefix?>_preview">View</a>
<?php ;else:?>
<a href="javascript:void(0);" taget="_blank" alt="" id="<?php echo $prefix?>_preview">View</a>
<?php endif;?>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" onclick="$('#<?php echo $prefix?>_preview').attr('src', 'javascript:void(0);'); $(\'#<?php echo $prefix?>').attr('value', ''); return false;">Clear</a>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a id="<?php echo $prefix?>_upload">Upload</a>
</div>