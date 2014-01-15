


		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'product2categories'); ?>
			</td>
			<td>
				<?php $name = CHtml::activeName($p2c, '[]category_id')?>
				<?php $ids = CHtml::listData($p2cs, 'category_id', 'category_id')?>
				<div class="scrollbox">
					<div class="even" style="margin-left:0px;">
						<?php echo CHtml::checkBox($name, false, array('value' => false, 'disabled' => 'disabled'))?>
						<?php echo Yii::t('app', 'None')?>
					</div>
					<?php $class='odd'?>
					<?php foreach (Category::model()->treeList() as $val):?>
						<div class="<?php //echo $class?>" style="margin-left:<?php echo $val['level']*20?>px;">
						<?php echo CHtml::checkBox($name, in_array($val['category_id'], $ids), array('value'=>$val['category_id']))?>
						<?php echo $val['title']?>
						</div>
						<?php $class = $class=='even' ? 'odd' : 'even'?>
					<?php endforeach;?>
				</div>
				<?php echo $form->error($model,'product2categories'); ?>
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
