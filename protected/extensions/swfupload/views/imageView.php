<li style="display: inline-block;"">
	<div style="background:url(<?php echo $src?>) center no-repeat; width: 125px; height: 125px; margin: 5px; border:1px solid gray;">
	</div>
    <div style="text-align:center;">
    <a href="#" onclick="confirm('<?php echo Yii::t('app', 'Confirm Gallery Image Delete?')?>') && jQuery(this).closest('li').remove(); return false;"><?php echo Yii::t('app', 'Gallery Image Delete')?></a>
    </div>
<?php
	if($image->hasAttribute('pic')) echo CHtml::activeHiddenField($image,"[{$index}]pic");
	if($image->hasAttribute('name')) echo CHtml::activeHiddenField($image,"[{$index}]name");
	if($image->hasAttribute('type')) echo CHtml::activeHiddenField($image,"[{$index}]type");
?>
</li>