


		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'parent_id'); ?>
			</td>
			<td>
				<?php $name = CHtml::activeName($model,'parent_id')?>
				<div class="scrollbox">
					<div class="even" style="margin-left:0px;">
						<?php echo CHtml::radioButton($name, false, array('value' => false))?>
						<?php echo Yii::t('app', 'None')?>
					</div>
					<?php $class='odd'?>
					<?php foreach ($model->treeList() as $val):?>
						<div class="<?php //echo $class?>" style="margin-left:<?php echo $val['level']*20?>px;">
						<?php echo CHtml::radioButton($name, $val['category_id'] == $model->parent_id, array('value'=>$val['category_id']))?>
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
				<?php echo $form->labelEx($model,'sort_order'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'sort_order'); ?>
				<?php echo $form->error($model,'sort_order'); ?>
			</td>
		</tr><!-- row -->

		</table>
