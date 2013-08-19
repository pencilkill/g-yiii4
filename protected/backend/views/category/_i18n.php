<div class="form">




		<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->textField($model, "[{$language_id}]parent_id"); ?>
		<?php echo $form->error($model, "[$language_id]parent_id"); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'top'); ?>
		<?php echo $form->checkBox($model, "[{$language_id}]top"); ?>
		<?php echo $form->error($model, "[$language_id]top"); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'sort_id'); ?>
		<?php echo $form->textField($model, "[{$language_id}]sort_id"); ?>
		<?php echo $form->error($model, "[$language_id]sort_id"); ?>
		</div><!-- row -->





</div><!-- form -->