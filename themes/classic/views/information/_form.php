<div class="form">


		<div class="row">
		<?php echo $form->labelEx($model,'sort'); ?>
		<?php echo $form->textField($model, 'sort'); ?>
		<?php echo $form->error($model,'sort'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model, 'status'); ?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->


</div><!-- form -->