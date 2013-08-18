<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name;

?>

<div id="content">
  <div class="box" style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
    <div class="heading">
      <h1><img src="_ozman/image/lockscreen.png" alt="" /><?php echo Yii::t('app', 'Login'); ?></h1>
    </div>
    <div class="content" style="min-height: 150px; overflow: hidden;">
    
    <?php if(Yii::app()->user->hasFlash('warning')): ?>
    <div class="warning"><?php echo Yii::app()->user->getFlash('warning'); ?></div>
    <?php endif;?>
	
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'enableClientValidation'=>false,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>
        <table style="width: 100%;">
          <tr>
            <td style="text-align: center;" rowspan="4"><img src="_ozman/image/login.png" alt="<?php echo Yii::t('app', 'Login'); ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $form->labelEx($model,'username', array('style' => 'font-weight: bold; font-size: 0.9em;')); ?><br />
              <?php echo $form->textField($model,'username', array('style' => 'margin-top: 4px;')); ?><br />
              <?php echo $form->error($model,'username'); ?>
              <br />
              <?php echo $form->labelEx($model,'password', array('style' => 'font-weight: bold; font-size: 0.9em;')); ?><br />
              <?php echo $form->passwordField($model,'password', array('style' => 'margin-top: 4px;')); ?><br />
              <?php echo $form->error($model,'password'); ?>
              <br />
              <?php echo $form->checkBox($model,'rememberMe'); ?>
              <?php echo $form->label($model,'rememberMe'); ?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: right;"><a onclick="$('#login-form').submit();" class="button"><?php echo Yii::t('app', 'Login'); ?></a></td>
          </tr>
        </table>
		<?php $this->endWidget(); ?>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#login-form input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login-form').submit();
	}
});
//--></script>