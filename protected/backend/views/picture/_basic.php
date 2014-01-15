


		<table class="form">

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
				<?php echo $form->labelEx($model,'pic'); ?>
			</td>
			<td>
				<?php echo HCUploader::ajaxImageUpload(array('model' => $model,'attribute' => 'pic')); ?>
				<?php echo $form->error($model,'pic'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'picture_type_id'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($model, 'picture_type_id', CHtml::listData(PictureType::model()->findAll(), 'picture_type_id', 'picture_type'), array('prompt' => '')); ?>
				<?php echo $form->error($model,'picture_type_id'); ?>
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
