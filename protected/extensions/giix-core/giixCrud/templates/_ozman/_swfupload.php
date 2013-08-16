<?php echo "<?php\n";?>
$this->widget('ext.swfupload.CFSwfUpload', array(
        'config' => array(
            'upload_url' => Yii::app()->createUrl('action/upload'),
            'post_params' => array('PHPSESSID'=>$_COOKIE['PHPSESSID']),
            'file_size_limit' => '2 MB',
        )

    )
);
<?php echo '?>'?>