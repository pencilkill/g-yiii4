<?php
/**
 * class CActiveFormBehavior file
 *
 * @author @author Sam <mail.song.de.qiang@gmail.com> <mail.song.de.qiang@gmail.com>
 *
 * Using for dynamic form validator
 * @example
 *
 <?php
 	// ... ...
 	$html = '';
	$html .= '<tr>';
	$html .= '	<td>' . $form->textField($model, "['+dynamicModelRowIndex+']attribute", array('maxlength' => 256, 'size' => 50)) . $form->error($model, "['+dynamicModelRowIndex+']attribute") . '</td>';
	$html .= '</tr>';

	$inputIDs = array(
		CHtml::activeId($model, "['+dynamicModelRowIndex+']attribute"),
	);

	$validators = $form->getActiveFormAttributes($inputIDs);

	$form->unsetActiveFormAttributes($inputIDs);

	// ... ...
 ?>
 <script type="text/javascript">
 	// ... ...
 	dynamicModelRowIndex = <?php echo $dynamicModelRowIndex++?>;

 	function dynamicAdd(){
	 	var html = '<?php echo CHtml::decode(CJavaScript::quote($html))?>';

		$('#container').append(html);

		// validator
		var settings = {};

		$.extend(true, settings, $('#form').data('settings'));

		// Core jQuery yiiactiveform plugin has been a little changed to support dynamic client validate by adding data() method
		settings.attributes = <?php echo CHtml::decode(CJavaScript::encode(CHtml::encodeArray(array_values($validators))))?>;

		$('#form').yiiactiveform(settings);

		dynamicModelRowIndex++;
	}
	// ... ...
 </script>
 */
class CActiveFormBehavior extends CBehavior{
	public function getActiveFormAttribute($inputID){
		return isset($this->getOwner()->attributes[$inputID]) ? $this->getOwner()->attributes[$inputID] : null;
	}

	public function getActiveFormAttributes(array $inputIDs){
		return array_intersect_key($this->getOwner()->attributes, array_flip($inputIDs));
	}

	public function setActiveFormAttribute($inputID, $option){
		$this->getOwner()->attributes[$inputID] = $option;
	}

	public function setActiveFormAttributes(array $attributes){
		$this->getOwner()->attributes = CMap::mergeArray($this->getOwner()->attributes, $attributes);
	}

	public function unsetActiveFormAttribute($inputID){
		if(isset($this->getOwner()->attributes[$inputID])) unset($this->getOwner()->attributes[$inputID]);
	}

	public function unsetActiveFormAttributes(array $inputIDs){
		foreach($inputIDs as $inputID){
			if(isset($this->getOwner()->attributes[$inputID])) unset($this->getOwner()->attributes[$inputID]);
		}
	}
}
?>