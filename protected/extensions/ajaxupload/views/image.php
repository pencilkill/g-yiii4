<div style="border: 1px solid #EEEEEE; padding: 10px; display: inline-block;">
<?php echo CHtml::activeHiddenField($model, $attribute, $htmlOptions);?>
<img src="<?php echo $preview?>" alt="" id="<?php echo $prefix?>_preview"/>
<br />
<a href="#" onclick="$('#<?php echo $prefix?>_preview').attr('src', '<?php echo $previewX?>'); $('#<?php echo $prefix?>').attr('value', ''); return false;">Clear</a>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a id="<?php echo $prefix?>_upload">Upload</a>
</div>