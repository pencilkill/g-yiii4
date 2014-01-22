<?php

/**
 * This is the model base class for the table "setting".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Setting".
 *
 * Columns in table "setting" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $key
 * @property string $value
 *
 */
abstract class BaseSetting extends GxActiveRecord {


	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'setting';
	}

	public static function label($n = 1) {
		return Yii::t('M/setting', 'Setting|Settings', $n);
	}

	public static function representingColumn() {
		return 'key';
	}

	public function rules() {

		return array(
			/*
			array('key', 'required'),
			array('key', 'match', 'pattern' => '^\w+$'),
			array('key', 'compare', 'compareAttribute'=>'key'),
			array('key', 'length', 'max'=>100),
			array('value', 'safe'),
			array('value', 'default', 'setOnEmpty' => true, 'value' => null),
			array('key, value', 'safe', 'on'=>'search'),
			*/
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			//'key' => Yii::t('m/setting', 'Key'),
			//'value' => Yii::t('m/setting', 'Value'),

			'mail_email_contact' => Yii::t('setting', 'Mail Email Contact'),
			'mail_smtp_host' => Yii::t('setting', 'Mail Smtp Host'),
			'mail_smtp_user' => Yii::t('setting', 'Mail Smtp User'),
			'mail_smtp_password' => Yii::t('setting', 'Mail Smtp Password'),
			'mail_smtp_port' => Yii::t('setting', 'Mail Smtp Port'),
			'analysis_google' => Yii::t('setting', 'Analysis Google'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('key', $this->key, true);
		$criteria->compare('value', $this->value, true);


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'attributes'=>array(
					'*',
				),
			),
		));
	}

	public function behaviors() {
		return array(
			'CTimestampBehavior'=>array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'updateAttribute' => null,
                'createAttribute' => null,
				'setUpdateOnCreate' => true,
			),
        );
	}
}