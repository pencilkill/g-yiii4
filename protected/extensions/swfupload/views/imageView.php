<li style="display:inline-block; margin:10px; ">
	<table style="border:1px solid gray;">
		<tr>
			<td style="width:<?php echo $thumb['width']?>px; height: <?php echo $thumb['height']?>px;" align="center">
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
	foreach ($attributes as $attribute){
		$callback = $attribute['callback'];

		$attribute['callback'] = $image;
		$attribute['attribute'] = '[' . $index .']' . $attribute['attribute'];

		echo call_user_func_array(array('CHtml', $callback), $attribute);
	}
?>
</li>