/**
 * 2013-07-20
 * @author Sam@ozchamp.net
 * @base jQuery
 * @version 1.0
 */
(function($){  

	$.fn.ajaxUploadHandler=function(options) {
		
        return this.each(function() {       	
        	var defaults = {
        			action: 'upload.php',
        			data:{},
        			name: 'userfile',
        			autoSubmit: true,
        			responseType: 'json',
        			onChange: function(file, extension){
        				imageChange(file, extension);
        			},
        			onSubmit: function(file, extension){
        				imageSubmit(file, extension);
        			},
        			onComplete: function(file, json){ 
        				imageComplete(file, json);
        			}
        	}
        	
        	var _options = $.extend({}, defaults, options);

        	var id = $(this).attr('id');
			
        	if(id){
				// hidden input element id, the data submitted finally
				var hiddenId='#' + id;
				// preview image element id
				var imageId = hiddenId + '_preview';
				// the element created by ajaxupload which is float to support ajaxupload
				var fileId = hiddenId+'_upload';
						
				imageUploader(fileId, _options);
				
			}
        	
        	function imageUploader(fileId, _options) {
        		new AjaxUpload(fileId, _options);
        	}
        	
        	function imageChange(file, extension) {
        		// check extension
        		return true;
        	}
        	
        	function imageSubmit(file, extension) {
        		$(fileId).after('<img src="' + _options.baseUrl + '/images/loading.gif" class="ajaxUploadLoading" style="padding-left: 5px;" />');
        		$(fileId).attr('disabled', true);
        		return true;
        	}
        	
        	function imageComplete(file, json) {
        		$(imageId).attr('disabled', false);
        		if (json['success']) {
        			//alert(json['success']);
        			var tagName = $(imageId).prop('tagName').toUpperCase();
        			
        			if(tagName=='IMG'){
        				$(imageId).attr('src', json.src);
        			}else if(tagName=='A'){
        				$(imageId).attr('href', json.file);
        			}
        			
        			$(hiddenId).attr('value', json.file);
        		}
        		if (json['error']) {
        			alert(json['error']);
        		}
        		$('.ajaxUploadLoading').remove();
        	}
        });
    };  
    
})(jQuery);  
 