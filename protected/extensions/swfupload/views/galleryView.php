<table class="form">
    <tr>
    	<td></td>
    	<td>
		    <div class="swfupload"  style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
		       <span id="swfupload"></span>
		    </div>
    	</td>
    </tr>
    <tr>
    	<td></td>
    	<td>
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
						'placeholder' => 'ui-state-highlight',
						'forceHelperSize' => true,
						'forcePlaceholderSize' => true,
						'start' => 'js:function(e, ui ){
						     ui.placeholder.height(ui.helper.innerHeight());
						     ui.placeholder.width(ui.helper.innerWidth());
						}',
					),
					'htmlOptions' => array(
						'id' => 'thumbnails',
						'style' => 'margin: 0px; padding: 0px;',
						'class' => 'images-sortable'
 					),
				));
			?>
	    </td>
	</tr>
</table>