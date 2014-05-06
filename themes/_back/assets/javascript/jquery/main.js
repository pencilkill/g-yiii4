// jQuery regex selector
jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}
// getURLVar
function getURLVar(urlVarName) {
	var urlHalves = String(document.location).toLowerCase().split('?');
	var urlVarValue = '';

	if (urlHalves[1]) {
		var urlVars = urlHalves[1].split('&');

		for (var i = 0; i <= (urlVars.length); i++) {
			if (urlVars[i]) {
				var urlVarPair = urlVars[i].split('=');

				if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
					urlVarValue = urlVarPair[1];
				}
			}
		}
	}

	return urlVarValue;
}
// Customer functions
jQuery(function($) {
	/**
	 * remove Flash
	 */
	$('#messageBox').on('click', 'div', function() {
		$(this).hide('fast');
	});
	/**
	 * Grid View Flash
	 */
	GridViewFlash = function (type, message) {
		if (!(type && message))
			return false;

		var box = $('#messageBox');
		box.find('.' + type).remove();
		
		var html = $('<div/>').addClass(type).css({'display':'none'}).html(message);
		
		html.appendTo(box).show('fast');
		
		//setTimeout(function(){html.hide('slow');}, 5000);
		
		return true;
	}
	/**
	 * Grid View Multiple Delete, with ajax  
	 */
	GridViewDelete = function(params) {
		var params = $.extend(
			{
				id : null,	// grid form id
				url : null,	// action url
				checkBoxColumn : ':checkbox:not(:disabled)[name^="GridViewSelect"]:checked',	// checkbox selector
				postName : 'selected',
				postData : {
					returnUrl : window.location.href	// extra data to post
				},
				deleteConfirmation : 'Confirm Grid View Delete?',	// alert message after multiple delete em clicked
				selectNoneMessage : 'No results found',		// flash message to show if no selected em after multiple delete em clicked
				warningMessage : 'Operation Failure',
			},
			params || {}
		);

		if (!(params.id && params.url && params.checkBoxColumn))
			return false;

		var selected = new Array();
		$.each($(params.checkBoxColumn), function() {
			selected.push($(this).val());
		});
		
		params.postData[params.postName + '[]'] = selected;
		
		if (selected.length > 0) {
			confirm(params.deleteConfirmation) && $.post(
				params.url, 
				params.postData, 
				function(data) {
					var ret = $.parseJSON(data);
					if (ret != null && ret.success != null && ret.success) {
						$.fn.yiiGridView.update(params.id);
					}else if(ret != null){
						// show the first flash only
						jQuery.each(ret, function(t, m){
								GridViewFlash(t, m);
								return false;
							}
						);
					}else{
						GridViewFlash('warning', params.warningMessage);
					}
				}
			);
		} else {
			GridViewFlash('warning', params.selectNoneMessage);
		}
	}
	/**
	 * Grid View Update, without ajax
	 */
	GridViewUpdate = function (params) {
		var params = $.extend({}, {
			id : null,
			submitConfirmation : 'Confirm Grid View Update?'
		}, params || {});
		
		if (!params.id){
			return false;
		}
		
		confirm(params.submitConfirmation) && $('#' + params.id).submit();
		
		return false;
	}
	/**
	 * Grid View Changed event
	 */
	GridViewChanged = function (params) {
		var params = $.extend({}, {
			id : null,
			trackEm : '[name^="edit"]',
			parentEm : 'tr',
			checkEm : '[name^="editted"]'
		}, params || {});
		
		if (!params.id){
			return false;
		}
		
		jQuery('body').on('change', '#' + params.id + ' ' + params.trackEm, function(){
			$(this).closest(params.parentEm).find(':checkbox' + params.checkEm + ':not(:disabled)').attr({'checked':true});
		});
		
		return false;
	}
	/**
	 * CKEditor Dynamic Update Value
	 */
	CKFormUpdateValue = function (){
		for (var instance in CKEDITOR.instances){
	        CKEDITOR.instances[instance].updateElement();
		}
	}
	/**
	 * Preview, dependencies fancybox2
	 */
	Preview = function (formData){
		var that = $(this);
		$.ajax({
			type: 'POST',
			cache: false,
			url: that.attr('href'),
			data: formData,
			dataType: 'html',
			beforeSend:	function(XMLHttpRequest){
				$.fancybox.showLoading();
			},
			success: function(responseText) {
				$.fancybox({
					content   : '<iframe id="preview-iframe" name="preview-iframe" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" src="about:blank"></iframe>',
					width     : '90%',
					height    : '90%',

					autoSize: false,
					closeClick: false,
					openEffect: 'elastic',
					closeEffect: 'fade',
					helpers: { overlay: { css: { 'background': 'rgba(0, 0, 0, 0.65)' } } },

					beforeShow: function() {
						$.fancybox.showLoading();

						var previewIframe = document.getElementById('preview-iframe');
						var iframeDoc = (previewIframe.contentWindow.document || previewIframe.contentDocument );
						iframeDoc.open();
						iframeDoc.write(responseText);
						iframeDoc.close();

						$(previewIframe).load(function(){
							$.fancybox.hideLoading();
						});
					},

					afterClose: function () {
						// rechecking
						$.fancybox.hideLoading();
					}
				}); // fancybox
			}, //success
			complete: function(XMLHttpRequest, textStatus){

			},
			error: function(XMLHttpRequest, message, e){
				alert(XMLHttpRequest);
			}
	   }); // ajax
	}
});