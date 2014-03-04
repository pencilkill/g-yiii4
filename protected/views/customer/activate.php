<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Activate';
$this->breadcrumbs=array(
	'Activate',
);
?>

<?php foreach(Yii::app()->user->getFlashes() as $key => $message){?>
<div class="<?php echo $key?>">
<?php echo $message; ?>
</div>
<?php }?>

<?php if($model->status){?>
<br/>
<div id="timer">
</div>
<script type="text/javascript">
var t = 5;
function showTime()
{
    t -= 1;
    document.getElementById('timer').innerHTML= '<?php echo Yii::t('app', 'The page will redirect in {t} seconds')?>'.toString().replace('{t}', t);

    if(t==0)
    {
        location.assign('<?php echo $this->createUrl('customer/login')?>');
    }

    setTimeout('showTime()',1000);
}
showTime();
</script>
<?php }?>