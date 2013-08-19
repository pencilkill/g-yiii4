<?php
/* @var $this SiteController */

$this->breadcrumbs = array(
	Yii::t('app', '操作'),
);
?>
<style type="text/css">
.content ul {
	list-style: none;
	text-align: center;
}
.content ul li {
	display: inline-block;
	margin: 10px 0px 0px 20px;
	width: 80px;
}
.content ul li a {
	text-align: center;
	text-decoration: none;
}
.content ul li img {
	margin: 10px;
	width: 50px;
}
.content ul li span{
	display: block;
	width: 80px;
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
				<li><a href="#" onclick="window.open('<?php echo Yii::app()->baseUrl; ?>'); return false;"><img src="_ozman/image/home.png"/><span><?php echo Yii::t('nav', 'Site Frontend')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('category/index', array())?>"><img src="_ozman/image/category.png"/><span><?php echo Yii::t('nav', 'Category')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('product/index', array())?>"><img src="_ozman/image/product.png"/><span><?php echo Yii::t('nav', 'Product')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('news/index', array())?>"><img src="_ozman/image/review.png"/><span><?php echo Yii::t('nav', 'News')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('information/index', array())?>"><img src="_ozman/image/information.png"/><span><?php echo Yii::t('nav', 'Information')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('pic/index', array())?>"><img src="_ozman/image/image.png"/><span><?php echo Yii::t('nav', 'Pic')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('admin/index', array())?>"><img src="_ozman/image/user.png"/><span><?php echo Yii::t('nav', 'Admin')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('setting/index', array())?>"><img src="_ozman/image/setting.png"/><span><?php echo Yii::t('nav', 'Setting')?></span></a></li>
				<li><a href="<?php echo Yii::app()->createUrl('site/logout', array())?>"><img src="_ozman/image/error.png"/><span><?php echo Yii::t('nav', 'Exit System')?></span></a></li>
			</ul>
		</div>
	</div>
</div>


