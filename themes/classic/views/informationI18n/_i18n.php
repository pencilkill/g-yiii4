<div class="form">






		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, "[$language_id]title", array('maxlength' => 256)); ?>
		<?php echo $form->error($model, "[$language_id]title"); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model, "[$language_id]description", array('class'=>'fck')); ?>
		<?php echo $form->error($model, "[$language_id]description"); ?>
		</div><!-- row -->



</div><!-- form -->