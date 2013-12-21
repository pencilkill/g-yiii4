<?php
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