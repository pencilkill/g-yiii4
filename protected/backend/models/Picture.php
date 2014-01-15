<?php

Yii::import('backend.models._base.BasePicture');

class Picture extends BasePicture
{

	public $filter;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function behaviors() {
		return CMap::mergeArray(parent::behaviors(), array(
			'CActiveRecordFilterBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordFilterBehavior',
			),
			'CTimestampBehavior'=> array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'updateAttribute' => 'update_time',
				'createAttribute' => 'create_time',
				'setUpdateOnCreate' => true,
			),
        ));
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'picture_type_id' => null,
			'pictureType' => null,
			'pictureI18ns' => null,
		));
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.picture_id", $this->picture_id);
		$criteria->compare("{$alias}.sort_order", $this->sort_order);
		$criteria->compare("{$alias}.pic", $this->pic, true);
		$criteria->compare("{$alias}.picture_type_id", $this->picture_type_id);
		$criteria->compare("{$alias}.status", $this->status);
		$criteria->compare("{$alias}.create_time", $this->create_time, true);
		$criteria->compare("{$alias}.update_time", $this->update_time, true);
		$criteria->group = "{$alias}.picture_id";
		$criteria->together = true;

		$criteria->with = array('pictureI18ns');

		$criteria->compare('pictureI18ns.url', $this->filter->pictureI18ns->url, true);
		$criteria->compare('pictureI18ns.title', $this->filter->pictureI18ns->title, true);
		$criteria->compare('pictureI18ns.keywords', $this->filter->pictureI18ns->keywords, true);
		$criteria->compare('pictureI18ns.description', $this->filter->pictureI18ns->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => "{$alias}.sort_order DESC, {$alias}.picture_id ASC",
				'multiSort'=>true,
				'attributes'=>array(
					'sort_order'=>array(
						'desc'=>"{$alias}.sort_order DESC",
						'asc'=>"{$alias}.sort_order ASC",
					),
					'*',
				),
			),
			'pagination' => array(
				'pageSize' => Yii::app()->request->getParam('pageSize', 10),
				'pageVar' => 'page',
			),
		));
	}

}