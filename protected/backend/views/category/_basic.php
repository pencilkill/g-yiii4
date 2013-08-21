


		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'parent_id'); ?>
			</td>
			<td>
				<?php $name = CHtml::activeName($model,'parent_id')?>
				<div class="scrollbox">
					<div class="even" style="margin-left:0px;">
						<?php echo CHtml::radioButton($name, CHtml::resolveValue($model, 'parent_id')==0 , array('value'=>0))?>
						<?php echo Yii::t('app', 'None')?>
					</div>
					<?php $class='odd'?>
					<?php foreach ($categories as $val):?>
						<div class="<?php //echo $class?>" style="margin-left:<?php echo $val['level']*20?>px;">
						<?php echo CHtml::radioButton($name, CHtml::resolveValue($model, 'parent_id')==$val['category_id'], array('value'=>$val['category_id']))?>
						<?php echo $val['title']?>
						</div>
						<?php $class = $class=='even' ? 'odd' : 'even'?>
					<?php endforeach;?>
				</div>
				<?php echo $form->error($model,'parent_id'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'top'); ?>
			</td>
			<td>
				<?php echo $form->checkBox($model, 'top'); ?>
				<?php echo $form->error($model,'top'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'sort_id'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'sort_id'); ?>
				<?php echo $form->error($model,'sort_id'); ?>
			</td>
		</tr><!-- row -->

		</table>
