<div style="border: 1px solid #EEEEEE; padding: 10px; display: inline-block;">
<?php if(!empty($preview)):?>
<a href="<?php echo $preview?>" target="_blank" alt="" id="<?php echo $htmlOptions['id']?>_preview">View</a>
<?php ;else:?>
<a href="javascript:void(0);" target="_blank" alt="" id="<?php echo $htmlOptions['id']?>_preview" style="visibility: hidden;">View</a>
<?php endif;?>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" onclick="$('#<?php echo $htmlOptions['id']?>_preview').attr({'href':'javascript:void(0);', 'style':'visibility: hidden;'}); $('#<?php echo $htmlOptions['id']?>').attr('value', ''); return false;">Clear</a>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a id="<?php echo $htmlOptions['id']?>_upload">Upload</a>
<br/>
<?php echo CHtml::textField($name, $value, $htmlOptions);?>
</div>