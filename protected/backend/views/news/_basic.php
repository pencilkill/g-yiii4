


		<table class="form">

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
				<?php echo $form->labelEx($model,'sort_order'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'sort_order'); ?>
				<?php echo $form->error($model,'sort_order'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'date_added'); ?>
			</td>
			<td>
				<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'date_added',
			'language' => Yii::app()->language,
			'options' => array(
				'showButtonPanel' => false,
				'changeYear' => true,
				'changeMonth' => true,
				'dateFormat' => 'yy-mm-dd',
				'yearRange' => '-5:+5',
			),
			'htmlOptions' => array(
				'readonly' => 'readonly',
				'value' => $model->date_added ? date('Y-m-d', strtotime($model->date_added)) : date('Y-m-d'),
			),
			));
; ?>
				<?php echo $form->error($model,'date_added'); ?>
			</td>
		</tr><!-- row -->

		</table>
