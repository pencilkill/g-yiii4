


		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'product2categories'); ?>
			</td>
			<td>
				<?php $name = 'Product[product2categories][][category_id]'?>
				<div class="scrollbox">
					<div style="margin-left:0px;">
						<?php echo CHtml::radioButton($name, sizeOf($categoryIds)==0 , array('value'=>0, 'disabled'=>'disalbed'))?>
						<?php echo Yii::t('app', 'None')?>
					</div>
					<?php foreach ($categories as $val):?>
						<?php
							$htmlOptions = array('value'=>$val['category_id']);
							if($val['totalSubCategories']){
								$htmlOptions['disabled'] = 'disabled';
							}
						?>
						<div style="margin-left:<?php echo $val['level']*20?>px;">
						<?php echo CHtml::radioButton($name, array_key_exists($val['category_id'], $categoryIds), $htmlOptions)?>
						<?php echo $val['title']?>
						</div>
					<?php endforeach;?>
				</div>
				<?php echo $form->error($model,'product2categories'); ?>
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
				<?php echo $form->labelEx($model,'top'); ?>
			</td>
			<td>
				<?php echo $form->checkBox($model, 'top'); ?>
				<?php echo $form->error($model,'top'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'date_added'); ?>
			</td>
			<td>
				<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model' => $model,
					'attribute' => 'date_added',
					'value' => $model->date_added,
					'language' => Yii::app()->language,
					'options' => array(
						'showButtonPanel' => false,
						'changeYear' => true,
						'changeMonth' => true,
						'dateFormat' => 'yy-mm-dd',
						'yearRange' => '-5:+5',
					),
					'htmlOptions' => array(
						'readonly' => 'readonly',
						'value' => $model->date_added ? date('Y-m-d', strtotime($model->date_added)) : date('Y-m-d'),
					),
					));
				?>
				<?php echo $form->error($model,'date_added'); ?>
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
