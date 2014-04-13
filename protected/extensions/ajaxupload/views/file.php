<div style="border: 1px solid #EEEEEE; padding: 10px; display: inline-block;">
<?php if(!empty($preview)):?>
<a href="<?php echo $preview?>" target="_blank" alt="" id="<?php echo $setting['preview']?>">View</a>
<?php ;else:?>
<a href="javascript:void(0);" target="_blank" alt="" id="<?php echo $setting['preview']?>" style="visibility: hidden;">View</a>
<?php endif;?>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" onclick="$(#'<?php echo $setting['preview']?>').attr({'href':'javascript:void(0);', 'style':'visibility: hidden;'}); $('#<?php echo $setting['field']?>').attr('value', ''); return false;">Clear</a>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a id="<?php echo $setting['btn']?>">Upload</a>
<br/>
<?php echo CHtml::textField($name, $value, $htmlOptions);?>
</div>