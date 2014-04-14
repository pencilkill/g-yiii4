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
			'CActiveRecordI18nBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordI18nBehavior',
				'relations' => array(
					'pictureI18ns' => array(
						'indexes' => CHtml::listData(Language::model()->findAll(), 'language_id', 'language_id'),
					),
				)
			),
			'CActiveRecordAssetBehavior' => array(
				'class' => 'frontend.behaviors.CActiveRecordAssetBehavior',
				'assets' => array(
					'pic',
				)
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
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.picture_id";
		$criteria->together = true;

		$criteria->with[] = 'pictureI18ns';
		$criteria->compare('pictureI18ns.status', $this->filter->pictureI18ns->status);
		$criteria->compare('pictureI18ns.url', $this->filter->pictureI18ns->url, true);
		$criteria->compare('pictureI18ns.title', $this->filter->pictureI18ns->title, true);
		$criteria->compare('pictureI18ns.keywords', $this->filter->pictureI18ns->keywords, true);
		$criteria->compare('pictureI18ns.description', $this->filter->pictureI18ns->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.sort_order" => CSort::SORT_DESC,
					"{$alias}.picture_id" => CSort::SORT_ASC,
				),
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