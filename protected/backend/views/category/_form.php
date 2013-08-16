<div class="form">






		<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php $name = CHtml::activeName($model,'parent_id')?>
		<div style="border:1px solid gray; height:200px; width:500px; overflow:scroll;">
			<label style="margin-left:0px;">
				<?php echo CHtml::radioButton($name, CHtml::resolveValue($model, 'parent_id')==0 , array('value'=>0))?>
				<?php echo Yii::t('app', 'None')?>
			</label>
			<?php foreach ($categories as $val):?>
				<label style="margin-left:<?php echo $val['level']*20?>px;">
				<?php echo CHtml::radioButton($name, CHtml::resolveValue($model, 'parent_id')==$val['category_id'], array('value'=>$val['category_id']))?>
				<?php echo $val['title']?>
				</label>
			<?php endforeach;?>
		</div>
		<?php echo $form->error($model,'parent_id'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'top'); ?>
		<?php echo $form->checkBox($model, 'top'); ?>
		<?php echo $form->error($model,'top'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'sort_id'); ?>
		<?php echo $form->textField($model, 'sort_id'); ?>
		<?php echo $form->error($model,'sort_id'); ?>
		</div><!-- row -->




</div><!-- form -->