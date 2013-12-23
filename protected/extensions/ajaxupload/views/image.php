<div style="border: 1px solid #EEEEEE; padding: 10px; display: inline-block;">
<?php echo CHtml::hiddenField($name, $value, $htmlOptions);?>
<table>
	<tr style="border: 0px;">
		<td colspan="3" style="border: 0px; width: <?php echo $resize['width']?>px; height: <?php echo $resize['width']?>px;" align="center">
			<img src="<?php echo $preview?>" alt="" id="<?php echo $prefix?>_preview"/>
		</td>
	</tr>
	<tr style="border: 0px;">
		<td align="center" style="border: 0px;"><a href="#" onclick="$('#<?php echo $prefix?>_preview').attr('src', '<?php echo $previewX?>'); $('#<?php echo $prefix?>').attr('value', ''); return false;">Clear</a></td>
		<td align="center" style="border: 0px;">&nbsp;&nbsp;|&nbsp;&nbsp;</td>
		<td align="center" style="border: 0px;"><a id="<?php echo $prefix?>_upload">Upload</a></td>
	</tr>
</table>
</div>