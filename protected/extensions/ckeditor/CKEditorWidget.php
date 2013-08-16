<?php
/*
 * Created on 02.01.2013
 *
 * Copyright: Shahram Monshi Pouri
 * Based on Christian Kütbach's FCKEditorWidget
 *
 * GNU LESSER GENERAL PUBLIC LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Requirements:
 * The CK-Editor have to be installed and configured. The Editor itself is
 * not includet to this extension.
 *
 * This extension have to be installed into:
 * <Yii-Application>/proected/extensions/ckeditor
 *
 */

/**
 * @author Sam, sam@ozchamp.net
 * @example
 * for basic:
 * <?php $this->widget('ext.ckeditor.CKEditorWidget',array('model'=>$model, 'attribute'=>'content', 'value'=>$model->content)); ?>
 * @example
 * for single: in this case, textarea tag is not included
 * <?php $this->widget('ext.ckeditor.CKEditorWidget',array('htmlOptions'=>array('id'=>'textarea_id'))); ?>
 * @example
 * for name and value: in this case, value is not requried:
 * <?php $this->widget('ext.ckeditor.CKEditorWidget',array('htmlOptions'=>array('name'=>CHtml::activeName($model, 'content'))), 'value'=>$model->content); ?>
 * @example
 * for multiple: in this case, textarea tag is not included
 * <?php $this->widget('ext.ckeditor.CKEditorWidget',array('htmlOptions'=>array('class'=>'textarea_class'))); ?>
 */

class CKEditorWidget extends CInputWidget
{

	public $ckEditor;
    public $ckFinder;
	public $ckBasePath;
    public $config;

    public function init() {

		if(!isset($this->ckEditor)){
			$this->ckEditor = Yii::getPathOfAlias('webroot').'/ckeditor/ckeditor.php';
		}
        if(!isset($this->ckFinder)){
            $this->ckFinder = Yii::getPathOfAlias('webroot').'/ckfinder/ckfinder.php';
        }
		if(!isset($this->ckBasePath)){
			$this->ckBasePath = Yii::app()->getBaseUrl().'/ckeditor/';
		}
        if(!isset($this->value)){
			$this->value = '';
		}

    	if(!(isset($this->htmlOptions['class']) || isset($this->htmlOptions['id']) || isset($this->htmlOptions['name']))){
			if(!isset($this->model)){
				throw new CHttpException(500,'"model" have to be set!');
			}
			if(!isset($this->attribute)){
				throw new CHttpException(500,'"attribute" have to be set!');
			}
			$this->htmlOptions['name']=CHtml::activeName($this->model, $this->attribute);
    	}
    }

	public function run()
	{
		$this->render('CKEditorView',array(
			"ckBasePath"=>$this->ckBasePath,
			"ckEditor"=>$this->ckEditor,
            "ckFinder"=>$this->ckFinder,
			"htmlOptions"=>$this->htmlOptions,
			"value"=>$this->value,
			"config"=>$this->config,
		));
	}
}
?>