<table class="form">
    <tr>
    	<td></td>
    	<td>
		    <div>
		       <span id="swfupload<?php echo $id?>" class="swfupload"></span>
		    </div>
    	</td>
    </tr>
    <tr>
    	<td></td>
    	<td>
		    <div id="divFileProgressContainer<?php echo $id?>" class="swfupload_divFileProgressContainer"></div>
			<?php
				$this->widget('zii.widgets.jui.CJuiSortable', array(
					'items' => $items,
					'tagName' => 'ul',
					'itemTemplate' => '{content}',
					'options' => array(
						'cursor' => 'crosshair',
						'placeholder' => 'ui-state-highlight ',
						'forceHelperSize' => true,
						'forcePlaceholderSize' => true,
						'start' => 'js:function(e, ui ){
						     ui.placeholder.css({
						     	\'heigth\':ui.helper.innerHeight(),
						     	\'width\':ui.helper.innerWidth(),
						     	\'display\':\'inline-block\',
						     	\'list-style\':\'none\'
						     });
						}',
					),
					'htmlOptions' => array(
						'id' => 'thumbnails'.$id,
						'style' => 'margin: 0px; padding: 0px;',
						'class' => 'images-sortable'
 					),
				));
			?>
	    </td>
	</tr>
</table>