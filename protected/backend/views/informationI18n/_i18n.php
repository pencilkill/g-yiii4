		<table class="form">
		<tr>
			<td>
				<?php echo $form->labelEx($model,'title'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, "[{$language_id}]title", array('maxlength' => 256)); ?>
				<?php echo $form->error($model, "[$language_id]title"); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'keywords'); ?>
			</td>
			<td>
				<?php echo $form->textArea($model, "[{$language_id}]keywords", array('cols' => 50, 'rows' => 5, 'class' => '')); ?>
				<?php echo $form->error($model, "[$language_id]keywords"); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'description'); ?>
			</td>
			<td>
				<?php echo $form->textArea($model, "[{$language_id}]description", array('cols' => 50, 'rows' => 5, 'class' => 'fck')); ?>
				<?php echo $form->error($model, "[$language_id]description"); ?>
			</td>
		</tr><!-- row -->

		</table>
