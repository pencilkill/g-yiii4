


		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'sort_id'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'sort_id'); ?>
				<?php echo $form->error($model,'sort_id'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'status'); ?>
			</td>
			<td>
				<?php echo $form->checkBox($model, 'status'); ?>
				<?php echo $form->error($model,'status'); ?>
			</td>
		</tr><!-- row -->

		</table>
