/**
 * By default, query strings are appended to url  
 * If Yii urlManager is enabled, create full normalize url(including form data)
 * @example
 * 

<?php 

$form = ...
...

?>

function headerSearch(){
	var kw = $.trim($('#<?php echo $form->id?> [name="search[kw]"]').val());

	if(kw != ''){
<?php if(empty(Yii::app()->urlManager)){?>
		return true;
<?php }else if(Yii::app()->urlManager instanceof CUrlManager && Yii::app()->urlManager->urlFormat === CUrlManager::PATH_FORMAT){?>
<?php
	$names = array('search[kw]');
	$uri = array();
	foreach($names as $name){
		$uri[$name] = chr(5) . $name . chr(5);
	}

	$url = $this->createUrl('search/index', $uri);
?>
		var opts = {
			url	:	'<?php echo $url?>'
		};

		var url = createActiveFormUrl.apply($('#<?php echo $form->id?>')[0], [opts]);

		location.assign(url);

		return false;
<?php }else{?>
		return true;
<?php }?>
	}else{
		return false;
	}
}
 */
function createActiveFormUrl(opts){
	// form
	var self = $(this);

	var opt = {
		url	:	self.attr('action'),
		uri	:	self.serializeArray(),
		quote	:	String.fromCharCode(5)
	};

	opt = $.extend(opt, opts || {});

	var quote = opt.quote;

	var url = decodeURI(opt.url);

	$.each(opt.uri, function(k, o){
		url = url.replace(quote + o.name + quote, o.value);
	});

	url = url.replace(new RegExp(quote + '[^' + quote + '].*?' + quote, 'g'), '');

	return encodeURI(url);
}