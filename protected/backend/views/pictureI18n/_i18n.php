		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'url'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, "[{$language_id}]url", array('maxlength' => 256)); ?>
				<?php echo $form->error($model, "[$language_id]url"); ?>
			</td>
		</tr><!-- row -->

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
				<?php echo $form->textArea($model, "[{$language_id}]keywords", array('rows' => 5, 'cols' => 50, 'class' => '')); ?>
				<?php echo $form->error($model, "[$language_id]keywords"); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'description'); ?>
			</td>
			<td>
				<?php echo $form->textArea($model, "[{$language_id}]description", array('rows' => 5, 'cols' => 50, 'class' => 'fck')); ?>
				<?php echo $form->error($model, "[$language_id]description"); ?>
			</td>
		</tr><!-- row -->

		<tr style="display:none; visibility: hidden; height: 0px;">
			<td>
				<?php echo $form->labelEx($model, "[$language_id]language_id"); ?>
			</td>
			<td>
				<?php echo $form->hiddenField($model, "[$language_id]language_id", array('value' => $language_id)); ?>
				<?php echo $form->error($model, "[$language_id]language_id"); ?>
			</td>
		</tr><!-- row -->

		</table>
