jQuery(function($) {
	/**
	 * Grid View Flash
	 */
	GridViewFlash = function (type, message) {
		if (!(type && message))
			return false;

		var box = $('#messageBox');
		var em = box.find('.' + type);
		var html = '<div class="' + type + '">' + message + '</div>';
		(em.length == 0 ? box.append(html) : box.children('.' + type).replaceWith(html));
		return true;
	}
	/**
	 * remove Flash
	 */
	$('#messageBox').on('click', 'div', function() {
		$(this).remove();
	});
	/**
	 * Grid View Delete
	 */
	GridViewDelete = function(params) {
		var params = $.extend({},
						{
							id : null,
							url : null,
							checkBoxColumn : ':checkbox:not(:disabled)[name^="GridViewSelect"]:checked',
							postData : {
								returnUrl : window.location.href
							},
							deleteConfirmation : 'Confirm Grid View Delete?',
							selectNoneMessage : 'No results found'
						}, params || {});

		if (!(params.id && params.url && params.checkBoxColumn))
			return false;

		var models = new Array();
		$.each($(params.checkBoxColumn), function() {
			models.push($(this).val());
		});
		
		if (models.length > 0) {
			confirm(params.deleteConfirmation) && $.post(params.url, $.extend(params.postData
							|| {}, {
						'selected[]' : models
					}), function(data) {
						var ret = $.parseJSON(data);
						if (ret != null && ret.success != null && ret.success) {
							$.fn.yiiGridView.update(params.id);
						}
					});
		} else {
			GridViewFlash('warning', params.selectNoneMessage);
		}
	}
	/**
	 * Grid View Update
	 */
	GridViewUpdate = function (params) {
		var params = $.extend({}, {
			id : null,
			submitConfirmation : 'Confirm Grid View Update?'
		}, params || {});
		if (!params.id)
			return false;
		confirm(params.submitConfirmation) && $('#' + params.id).submit();
		return false;
	}
});
//jQuery regex selector
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