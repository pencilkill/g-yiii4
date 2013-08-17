<div class="form">
    <div class="row">
    <div class="swfupload"  style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
       <span id="swfupload"></span>
    </div>
    <div id="divFileProgressContainer" style="height: 75px;"></div>
<!--    <div id="thumbnails"></div>-->
	<?php
		$this->widget('zii.widgets.jui.CJuiSortable', array(
			'items' => $items,
//			'tagName' => 'ul',
//			'itemTemplate' => '<li id="{id}">{content}</li>',
			'itemTemplate' => '{content}',
			'options' => array(
				'cursor' => 'crosshair',
				'forceHelperSize' => true,
				'forcePlaceholderSize' => true,
			),
			'htmlOptions' => array(
				'id' => 'thumbnails',
				'style' => 'margin: 0px; padding: 0px;',
			),
		));
	?>
    </div>
</div>