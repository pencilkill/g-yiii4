/**
 * ajaxUploadHandler
 * 
 * This is a helper plugin based on jQuery, AjaxUpload
 * Notice: ajaxUploadHandler selector is a field element which used for keeping the AjaxUpload return value while that AjaxUpload selector is a button element for upload file 
 * 
 * 2013-07-20
 * @author Sam@ozchamp.net
 * @base jQuery
 * @version 1.0
 * 
 */
(function($){  

	$.fn.ajaxUploadHandler=function(options) {	
		function onChange(file, extension) {
    		// check extension
    		return true;
    	}
    	
    	function onSubmit(file, extension) {
    		var btn = $(this._button);
    		
    		btn.after('<img src="' + _options.baseUrl + '/images/loading.gif" class="ajaxUploadLoading" style="padding-left: 5px;" />');
    		btn.attr('disabled', true);
    		
    		return true;
    	}
    	
    	function onComplete(file, json) {
    		// 'this' refers to the element's Ajaxupload, not the element
    		var btn = $(this._button);
    		var preview = $(btn.attr('previewId'));
    		var hidden = $(btn.attr('hiddenId'));
    		
    		btn.attr('disabled', false);
    		
    		if (json['success']) {
    			//alert(json['success']);
    			if(preview){
	    			var tagName = preview.prop('tagName').toString().toUpperCase();
	    			
	    			if(tagName=='IMG'){
	    				preview.attr('src', json.src);
	    			}else if(tagName=='A'){
	    				preview.attr('href', json.file);
	    			}
    			}
    			
    			if(hidden){
    				hidden.attr('value', json.file);
    			}
    		}
    		if (json['error']) {
    			alert(json['error']);
    		}
    		$('.ajaxUploadLoading').remove();
    	}
    	
		var defaults = {
				action: undefined,
				data:{},
				name: 'userfile',	// compatiable with Ajaxupload, be carefully to change this default setting
				autoSubmit: true,
				responseType: 'json',
				onChange: onChange,
				onSubmit: onSubmit,
				onComplete: onComplete
		};
    	
    	var _options = $.extend({}, defaults, options);
    	
        return this.each(function() {
        	var btnId = _options.btnId ? _options.splice('btnId') : '#' + this.id + '_upload';	// remove after getting
        	var previewId = _options.previewId ? _options.splice('previewId') : (this.previewId ? this.previewId : '#' + this.id + '_preview');
        	var hiddenId = '#' + this.id;
        	
        	$(btnId).attr({
        		'hiddenId':hiddenId,
        		'previewId':previewId
        	});

        	if(_options.action){
        		new AjaxUpload(btnId, _options);
        	}else{
        		throw 'ajaUploadHanler: action for AjaxUpload is required!';
        	}
        	//$(this).data('ajaxUploadHandler', new AjaxUpload(this.id + '_upload', _options));	// debug       	
        });
    };  
    
})(jQuery);  
 