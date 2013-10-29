


		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'pic'); ?>
			</td>
			<td>
				<?php echo HCSite::ajaxImageUpload(array('model' => $model,'attribute' => 'pic'))?>
				<?php echo $form->error($model,'pic'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'pic_type_id'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($model, 'pic_type_id', GxHtml::listDataEx(PicType::model()->findAllAttributes(null, true))); ?>
				<?php echo $form->error($model,'pic_type_id'); ?>
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


		<tr>
			<td>
				<?php echo $form->labelEx($model,'sort_id'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'sort_id'); ?>
				<?php echo $form->error($model,'sort_id'); ?>
			</td>
		</tr><!-- row -->


		</table>
