<?php
/**
 * class CActiveFormBehavior file
 *
 * @author @author Sam <mail.song.de.qiang@gmail.com> <mail.song.de.qiang@gmail.com>
 *
 * Using for clean up assets, unlink file, image ...
 *
 * This behavior is optional,
 * cause we may use file manager sometimes, e.g CKFinder,
 * the assets are aways shared, they should not be deleted
 */
class CActiveRecordAssetBehavior  extends CActiveRecordBehavior {
	private $_ar;
	/**
	 * filter the assets, key/value list, key as attribute name,
	 * support as following:
	 * String, compared with the old atrribute value directy
	 * Closure, callback function using the owner as first parameter and the attribute as second parameter
	 *
	 * @example
	 	array(
	 		'file',
			'pic' => function($model, $attribute, $value, $force){
				$files = array();

				if($value && ($file = CHtml::value($model, $attribute)) && ($force || strnatcasecmp($file, $value)){
					$files[] = $value;
				}

				return $files;
			},
		)
	 */
	public $assets = array();

	public function afterConstruct($event){
		parent::afterConstruct($event);

		$this->_ar = new stdClass;

		foreach ($this->assets as $attribute => $asset){
			if(is_numeric($attribute)){
				$attribute = $asset;
			}

			$this->_ar->{$attribute} = CHtml::value($this->owner, $attribute);
		}
	}

	public function afterFind($event){
		parent::afterFind($event);

		$this->_ar = new stdClass;

		foreach ($this->assets as $attribute => $asset){
			if(is_numeric($attribute)){
				$attribute = $asset;
			}

			$this->_ar->{$attribute} = CHtml::value($this->owner, $attribute);
		}
	}

	public function afterSave($event){
		parent::afterSave($event);

		$this->clean();
	}

	public function afterDelete($event){
		parent::afterDelete($event);

		$this->clean(true);
	}

	private function getAsset($asset, $attribute, $value, $force = false){
		$files = array();

		if($value){
			if(is_scalar($asset) && ($force || strnatcasecmp($value, $asset))){
				$files[] = $value;
			}elseif(is_object($asset) && $asset instanceof Closure){
				$files = call_user_func($asset, $this->owner, $attribute, $value, $force);
			}
		}

		return $files;
	}

	private function delete($file){
		if($file){
			$file = HCUrl::trim($file);

			$file = Yii::getPathOfAlias('webroot') . '/' . $file;

			is_file($file) && @unlink($file);
		}
	}

	private function clean($force = false){
		foreach ($this->assets as $attribute => $asset){
			if(is_numeric($attribute)){
				$attribute = $asset;

				$asset = CHtml::value($this->owner, $attribute);
			}

			$files = $this->getAsset($asset, $attribute, $this->_ar->{$attribute}, $force);

			$files = is_array($files) ? $files : array($files);

			foreach($files as $file){
				$this->delete($file);
			}
		}

	}
}