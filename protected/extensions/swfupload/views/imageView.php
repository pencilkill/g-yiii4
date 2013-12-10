<li style="display:inline-block; margin:10px; ">
	<table style="border:1px solid gray;">
		<tr>
			<td style="width:<?php echo $resize['width']?>px; height: <?php echo $resize['height']?>px;" align="center">
				<img src="<?php echo $src?>"/>
			</td>
		</tr>
		<tr>
			<td align="center">
				<a href="#" onclick="confirm('<?php echo Yii::t('app', 'Confirm Gallery Image Delete?')?>') && jQuery(this).closest('li').remove(); return false;"><?php echo Yii::t('app', 'Gallery Image Delete')?></a>
			</td>
		</tr>
	</table>
<?php
	if($image->hasAttribute('pic')) echo CHtml::activeHiddenField($image,"[{$index}]pic");
	if($image->hasAttribute('name')) echo CHtml::activeHiddenField($image,"[{$index}]name");
	if($image->hasAttribute('type')) echo CHtml::activeHiddenField($image,"[{$index}]type");
?>
</li>