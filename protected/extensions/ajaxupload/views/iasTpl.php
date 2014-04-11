<?php
	/**
	 * ias, collect imageAreaSelect data show customized
	 * it is compatiable with widget javascript callback
	 * carefully to edit ...
	 */
?>
<div class="<?php echo $iasClassPrefix?>">
	<span class="<?php echo $iasClassPrefix?>-label"></span>
	<span class="<?php echo $iasClassPrefix?>-width">0</span>
	<span class="<?php echo $iasClassPrefix?>-split">:</span>
	<span class="<?php echo $iasClassPrefix?>-height-label"></span>
	<span class="<?php echo $iasClassPrefix?>-height">0</span>
	<button class="<?php echo $iasClassPrefix?>-submit" disabled="disabled">OK</button>
	<form method="post" class="<?php echo $iasClassPrefix?>-data" onsubmit="return false;" style="display: none;">
		<input type="hidden" class="<?php echo $iasClassPrefix?>-data-source" name="source"/>
		<input type="hidden" class="<?php echo $iasClassPrefix?>-data-scale-width" name="scale_width"/>
		<input type="hidden" class="<?php echo $iasClassPrefix?>-data-scale-height" name="scale_height"/>
		<input type="hidden" class="<?php echo $iasClassPrefix?>-data-x1" name="x1"/>
		<input type="hidden" class="<?php echo $iasClassPrefix?>-data-y1" name="y1"/>
		<input type="hidden" class="<?php echo $iasClassPrefix?>-data-x2" name="x2"/>
		<input type="hidden" class="<?php echo $iasClassPrefix?>-data-y2" name="y2"/>
		<input type="hidden" class="<?php echo $iasClassPrefix?>-data-width" name="width"/>
		<input type="hidden" class="<?php echo $iasClassPrefix?>-data-height" name="height"/>
	</form>
</div>
