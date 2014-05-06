<?php
/* @var $this SiteController */

$this->breadcrumbs = array(
	Yii::t('app', 'Operation'),
);
?>
<style type="text/css">
.content ul { margin:0; padding:0;
	list-style: none;
	text-align: center;
}
.content ul li {
	display: inline-block;
	margin: 10px 10px 0;
	width: 90px;
	float: inherit;
}
.content ul li a {
	text-align: center;
	text-decoration: none;
	border: 1px solid #F1F1F1;
    display: block;
    padding: 8px 0px 5px;
	border-radius: 5px;
    box-shadow: 0 0 15px #F4F4F4 inset;
}
.content ul li a:hover{
	border: 1px solid #AAA;
}
.content ul li span{ padding:6px 0 0 0;
	display: block;
	color: #333;
}
</style>
<div id="content">
	<div class="breadcrumb">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	</div>
	<div class="box">
		<div class="heading">
			<!--<div class="buttons"></div>-->
		</div>
		<div class="content">
			<ul>
				<li><a href="#" onclick="window.open('<?php echo Yii::app()->baseUrl; ?>'); return false;"><img src="<?php echo $this->skinUrl?>/icon/home.png"/><span><?php echo Yii::t('nav', 'Site Frontend')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('category/index', array())?>"><img src="<?php echo $this->skinUrl?>/icon/folder.png"/><span><?php echo Yii::t('nav', 'Category')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('product/index', array())?>"><img src="<?php echo $this->skinUrl?>/icon/screen.png"/><span><?php echo Yii::t('nav', 'Product')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('news/index', array())?>"><img src="<?php echo $this->skinUrl?>/icon/activity.png"/><span><?php echo Yii::t('nav', 'News')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('information/index', array())?>"><img src="<?php echo $this->skinUrl?>/icon/info.png"/><span><?php echo Yii::t('nav', 'Information')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('picture/index', array())?>"><img src="<?php echo $this->skinUrl?>/icon/photo.png"/><span><?php echo Yii::t('nav', 'Picture')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('contact/index', array())?>"><img src="<?php echo $this->skinUrl?>/icon/mail.png"/><span><?php echo Yii::t('nav', 'Contact')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('admin/index', array())?>"><img src="<?php echo $this->skinUrl?>/icon/person.png"/><span><?php echo Yii::t('nav', 'Admin')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('setting/index', array())?>"><img src="<?php echo $this->skinUrl?>/icon/config.png"/><span><?php echo Yii::t('nav', 'Setting')?></span></a></li>
			</ul>
		</div>
	</div>
</div>


