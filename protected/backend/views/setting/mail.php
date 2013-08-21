<?php

$mailHtabs = array(
	'email' => Yii::t('setting', 'Mail Email'),
	'smtp' => Yii::t('setting', 'Mail Smtp'),
);
?>

<div id="tab-<?php echo $group?>">

  <div id="<?php echo $group?>-htabs" class="htabs">
  <?php foreach($mailHtabs as $key => $val):?>
    <a href="#<?php echo $group?>-htabs-<?php echo $key?>"><?php echo $val?></a>
  <?php endforeach;?>
  </div>

  <?php foreach ($mailHtabs as $key => $val) : ?>
  <div id="<?php echo $group?>-htabs-<?php echo $key?>">

		<?php $this->renderPartial("//setting/{$group}/{$key}", array())?>

  </div>
  <?php endforeach; ?>

</div>