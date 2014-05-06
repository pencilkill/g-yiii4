


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
				<?php echo $form->textField($model, 'date_added', array('class' => 'CJuiDatePicker', 'value' => ($a = CHtml::resolveValue($model, 'date_added')) ? date('Y-m-d', strtotime($a)) : date('Y-m-d'))); ?>
				<?php echo $form->error($model,'date_added'); ?>
			</td>
		</tr><!-- row -->

		</table>
