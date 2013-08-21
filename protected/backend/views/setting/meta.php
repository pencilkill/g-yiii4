
<div id="tab-<?php echo $group?>">

  <div id="<?php echo $group?>-languages" class="htabs">
    <?php foreach ($this->languages as $language) : ?>
    <a href="#<?php echo $group?>-languages-<?php echo $language['language_id']?>"><?php echo $language['title']; ?></a>
    <?php endforeach; ?>
  </div>

  <?php foreach ($this->languages as $language) : ?>
  <div id="<?php echo $group?>-languages-<?php echo $language['language_id']?>">

		<?php $this->renderPartial("//setting/{$group}/_i18n", array('language_id' => $language['language_id']))?>

  </div>
  <?php endforeach; ?>

</div>