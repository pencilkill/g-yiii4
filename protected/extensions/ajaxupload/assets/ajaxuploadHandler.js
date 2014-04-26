/**
 * ajaxUploadHandler
 * 
 * This is a helper plugin based on jQuery, AjaxUpload
 * Notice: ajaxUploadHandler selector is a field element which used for keeping the AjaxUpload return value while that AjaxUpload selector is a button element for upload file 
 * 
 * 2013-07-20
 * @author Sam <mail.song.de.qiang@gmail.com>
 * @base jQuery
 * @version 1.0
 * 
 */
(function($){  

	$.fn.ajaxUploadHandler=function(options){	
		function onChange(file, extension){
			$('.ajaxUploadLoading').remove();
    		// check extension
			
    		return true;
    	}
    	
    	function onSubmit(file, extension){
    		var setting = this._settings.setting;

    		var btn = null;
    		
    		if(setting.hasOwnProperty('btn')){
    			btn = $('#' + setting.btn);
    		}
    		
    		if(this._settings.setting.hasOwnProperty('baseUrl')){
    			btn.after('<img src="' + this._settings.setting.baseUrl + '/images/loading.gif" class="ajaxUploadLoading" style="padding-left: 5px;"/>');
    		}
    	
    		btn.attr('disabled', true);
    		  		
    		var yiiLoginRequired = false;
    		if(this._settings.setting.hasOwnProperty('yiiLoginRequired') && typeof this._settings.setting.yiiLoginRequired === 'function'){
    			yiiLoginRequired = this._settings.setting.yiiLoginRequired();
    		}

    		return yiiLoginRequired === false;
    	}
    	
    	function onComplete(file, json){
    		// 'this' refers to the element's Ajaxupload, not the element
    		var setting = this._settings.setting;

    		var btn = null, field = null, preview = null;
    		
    		if(setting.hasOwnProperty('btn')){
    			btn = $('#' + setting.btn);
    		}
    		
    		if(setting.hasOwnProperty('field')){
    			field = $('#' + setting.field);
    		}
    		
    		if(setting.hasOwnProperty('preview')){
    			preview = $('#' + setting.preview);
    		}
    		
    		btn.attr('disabled', false);
    		
    		if (json['success']){
    			//alert(json['success']);
    			if(preview){
	    			var tagName = preview.prop('tagName').toString().toUpperCase();
	    			
	    			if(tagName=='IMG'){
	    				preview.attr({'src':json.src});
	    			}else if(tagName=='A'){
	    				preview.attr({'href':json.file, 'style':'visibility: visible;'}).show();
	    			}
    			}
    			
    			if(field){
    				field.attr({'value':json.file});
    			}
    		}
    		
    		if (json['error']){
    			alert(json['error']);
    		}
    		
    		$('.ajaxUploadLoading').remove();
    	}
    	
		var defaults = {
				action: undefined,
				name: 'userfile',	// compatiable with Ajaxupload, be carefully to change this default setting
				data:{},
				setting:{
					'btn':undefined
				},
				autoSubmit: true,
				responseType: 'json',
				onChange: onChange,
				onSubmit: onSubmit,
				onComplete: onComplete
		};
    	
    	var _options = $.extend({}, defaults, options);
    	
        return this.each(function(){
        	//
        	if(_options.action && _options.setting.btn){
        		new AjaxUpload(_options.setting.btn, _options);
        	}else{
        		throw 'ajaUploadHanler: action for AjaxUpload is required!';
        	}
        	//$(this).data('ajaxUploadHandler', new AjaxUpload(this.id + '_upload', _options));	// debug       	
        });
    };  
    
})(jQuery);  
 