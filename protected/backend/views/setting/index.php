<?php

$this->breadcrumbs = array(
	Yii::t('setting', 'Setting') => array('index'),
	Yii::t('setting', 'Update'),
);

?>
<div id="content">
  <div class="breadcrumb">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
  </div>

  <div id="messageBox">
  <?php foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
	<div class="<?php echo $key?>"><?php echo $message?></div>
  <?php endforeach;?>
  <?php if($model->getErrors()):?>
  	<div class="warning"><?php echo Yii::t('app', 'Operation Failure')?></div>
  <?php ;else:?>
  	<div class="success"><?php echo Yii::t('app', 'Operation Success')?></div>
  <?php endif;?>
  </div>

  <div class="box">
    <div class="heading">
      <div class="buttons">
      	<a onclick="$('#setting-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      </div>
    </div>
    <div class="content">
		<div id="tabs" class="htabs">
			<a href="#tab-meta"><?php  echo Yii::t('setting', 'Meta')?></a>
			<a href="#tab-mail"><?php  echo Yii::t('setting', 'Mail')?></a>
			<a href="#tab-analysis"><?php  echo Yii::t('setting', 'Analysis')?></a>
		</div>

		<?php
			$form = $this->beginWidget('GxActiveForm', array(
				'id' => 'setting-form',
				'enableAjaxValidation' => true,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			));
		?>
		<!-- Meta begin -->
		<div id="tab-meta">

		  <div id="meta-languages" class="htabs">
		    <?php foreach ($this->languages as $language) : ?>
		    <a href="#meta-languages-<?php echo $language['language_id']?>"><?php echo $language['title']; ?></a>
		    <?php endforeach; ?>
		  </div>

		  <?php foreach ($this->languages as $language) : ?>
		  <div id="meta-languages-<?php echo $language['language_id']?>">

				<table class="form">

				<?php $key = "meta_title_{$language['language_id']}"; ?>
				<tr>
					<td>
						<label><?php echo Yii::t('setting', 'Meta Title'); ?></label>
					</td>
					<td>
						<?php echo $form->textField($model, $key, array('size'=>50)); ?>
						<?php echo $form->error($model, $key)?>
					</td>
				</tr><!-- row -->

				<?php $key = "meta_keywords_{$language['language_id']}"; ?>
				<tr>
					<td>
						<label><?php echo Yii::t('setting', 'Meta Keywords'); ?></label>
					</td>
					<td>
						<?php echo $form->textArea($model, $key, array('rows'=>5, 'cols'=>50)); ?>
						<?php echo $form->error($model, $key)?>
					</td>
				</tr><!-- row -->

				<?php $key = "meta_description_{$language['language_id']}"; ?>
				<tr>
					<td>
						<label><?php echo Yii::t('setting', 'Meta Description'); ?></label>
					</td>
					<td>
						<?php echo $form->textArea($model, $key, array('rows'=>10, 'cols'=>50)); ?>
						<?php echo $form->error($model, $key)?>
					</td>
				</tr><!-- row -->

				</table>

		  </div>
		  <?php endforeach; ?>

		</div>
		<!-- Meta end -->

		<!-- Mail begin -->
		<div id="tab-mail">

		  <div id="mail-htabs" class="htabs">
		    <a href="#mail-htabs-email"><?php echo Yii::t('setting', 'Mail Email')?></a>
		    <a href="#mail-htabs-smtp"><?php echo Yii::t('setting', 'Mail Smtp')?></a>
		  </div>

		  <div id="mail-htabs-email">

			<table class="form">

			<?php $key = 'mail_email_contact'; ?>
			<tr>
				<td>
					<label><?php echo Yii::t('setting', 'Mail Email Contact'); ?></label>
				</td>
				<td>
					<?php echo $form->textArea($model, $key, array('rows'=>5, 'cols'=>50)); ?>
					<?php echo $form->error($model, $key)?>
				</td>
			</tr><!-- row -->

			</table>

		  </div>

		  <div id="mail-htabs-smtp">

			<table class="form">

			<?php $key = 'mail_smtp_host'; ?>
			<tr>
				<td>
					<label><?php echo Yii::t('setting', 'Mail Smtp Host'); ?></label>
				</td>
				<td>
					<?php echo $form->textField($model, $key); ?>
					<?php echo $form->error($model, $key)?>
				</td>
			</tr><!-- row -->

			<?php $key = 'mail_smtp_user'; ?>
			<tr>
				<td>
					<label><?php echo Yii::t('setting', 'Mail Smtp User'); ?></label>
				</td>
				<td>
					<?php echo $form->textField($model, $key); ?>
					<?php echo $form->error($model, $key)?>
				</td>
			</tr><!-- row -->

			<?php $key = 'mail_smtp_password'; ?>
			<tr>
				<td>
					<label><?php echo Yii::t('setting', 'Mail Smtp Password'); ?></label>
				</td>
				<td>
					<?php echo $form->textField($model, $key); ?>
					<?php echo $form->error($model, $key)?>
				</td>
			</tr><!-- row -->

			<?php $key = 'mail_smtp_port'; ?>
			<tr>
				<td>
					<label><?php echo Yii::t('setting', 'Mail Smtp Port'); ?></label>
				</td>
				<td>
					<?php echo $form->textField($model, $key); ?>
					<?php echo $form->error($model, $key)?>
				</td>
			</tr><!-- row -->

			</table>

		  </div>

		</div>
		<!-- Mail end -->

		<!-- Analysis begin -->
		<div id="tab-analysis">

		<table class="form">

		<?php $key = 'analysis_google'; ?>
		<tr>
			<td>
				<?php echo $form->labelEx($model, $key); ?>
			</td>
			<td>
				<?php echo $form->textArea($model, $key, array('rows'=>5, 'cols'=>50)); ?>
				<?php echo $form->error($model, $key)?>
			</td>
		</tr><!-- row -->

		</table>

		</div>
		<!-- Analysis end -->

		<?php
			$this->endWidget();
		?>

	</div><!-- form -->
  </div>
</div>
<script type="text/javascript">
$('[id$="-languages"] a').tabs();
$('[id$="-htabs"] a').tabs();
</script>