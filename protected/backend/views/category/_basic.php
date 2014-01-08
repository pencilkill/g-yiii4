


		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'parent_id'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'parent_id'); ?>
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
