<div style="border: 1px solid #EEEEEE; padding: 10px; display: inline-block;">
<?php echo CHtml::hiddenField($name, $value, $htmlOptions);?>
<table>
	<tr style="border: 0px;">
		<td colspan="3" style="border: 0px; width: <?php echo $resize['width']?>px; height: <?php echo $resize['width']?>px;" align="center">
		<?php if(empty($fancyBox['target'])){?>
			<img src="<?php echo $preview?>" alt="" id="<?php echo $setting['preview']?>"/>
		<?php }else{?>
			<a id="<?php echo ltrim($fancyBox['target'], '#')?>" href="#"><img src="<?php echo $preview?>" alt="" id="<?php echo $setting['preview']?>"/></a>
			<?php $this->widget('frontend.extensions.fancybox.EFancyBox', $fancyBox); ?>
		<?php }?>
		</td>
	</tr>
	<tr style="border: 0px;">
		<td align="center" style="border: 0px;">
		<a href="#" onclick="$('#<?php echo $setting['preview']?>').attr('src', '<?php echo $previewX?>'); $('#<?php echo $setting['field']?>').attr('value', ''); return false;">Clear</a>
		</td>
		<td align="center" style="border: 0px;">&nbsp;&nbsp;|&nbsp;&nbsp;</td>
		<td align="center" style="border: 0px;"><a id="<?php echo $setting['btn']?>">Upload</a></td>
	</tr>
</table>
</div>
<?php if($imageSelect){$this->widget('frontend.extensions.imageselect.EImageSelect', $imageSelect);}?>