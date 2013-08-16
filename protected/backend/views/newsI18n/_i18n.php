<div class="form">






		<div class="row">
		<?php echo $form->labelEx($model,'pic'); ?>
		<?php echo CSite::ajaxFileUpload(array($model, "[$language_id]pic"))?>
		<?php echo $form->error($model, "[$language_id]pic"); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, "[$language_id]title", array('maxlength' => 256)); ?>
		<?php echo $form->error($model, "[$language_id]title"); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'keywords'); ?>
		<?php echo $form->textArea($model, "[$language_id]keywords"); ?>
		<?php echo $form->error($model, "[$language_id]keywords"); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model, "[$language_id]description", array('class'=>'fck')); ?>
		<?php echo $form->error($model, "[$language_id]description"); ?>
		</div><!-- row -->



</div><!-- form -->