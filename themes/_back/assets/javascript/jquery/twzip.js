/**
 * @example
  	<select id="city"></select>
 	<select id="county"></select>
 	<input id="postcode" type="text"/>
	<script type="text/javascript"></script>
	<script type="text/javascript">$('#city').twzip();</script>
 */
(function($){
	$.fn.twzip = function(options){
		var defaultOptions = {
			city	:	undefined
			,cityUrl	:	'index.php?r=twzip/city'
			,cityValue:	undefined
			,cityPlaceholder:	'-- 請選擇 --'
			,countyAttrName	:	'county'
			,county	:	'#county'
			,countyUrl	:	'index.php?r=twzip/county'
			,countyPlaceholder	:	'-- 請選擇 --'
			,postcodeAttrName	:	'postcode'
			,postcode	:	'#postcode'
			,postcodeValue	:	undefined
			,postcodePlaceholder	:	undefined
		};
		
		var _county = function(id){
			var $this = $(this);
			
			if($this.data('twzip') == undefined){
				$this.data('twzip', {});
			}
			
			var _twzip = $this.data('twzip');
			
			var prop = id ? id.toString() : '';	// city
			
			if(_twzip.hasOwnProperty(prop)){
				var html = settings.countyPlaceholder ? '<option value>' + settings.countyPlaceholder + '</option>' : '';
				
				$.each(_twzip[prop], function(k, v){  
					if(settings.countyValue && v == settings.countyValue){
						html += '<option ' + settings.postcodeAttrName + '="' + v + '" value="' + k + '" selected="selected">' + k + '</option>';
					}else{
						html += '<option ' + settings.postcodeAttrName + '="' + v + '" value="' + k + '">' + k + '</option>';
					}
				});
				
				$this.html(html);
				
				$this.trigger('change');
			}else if(settings.countyUrl){
				$.ajax({
					url:	settings.countyUrl,
					dataType:	'json',
					data:{
						'id'	:	prop	// city id
					},
					success:	function(data, status, xhr){
						var html = settings.countyPlaceholder ? '<option value>' + settings.countyPlaceholder + '</option>' : '';
						
						$.each(data, function(k, v){
							if(settings.countyValue && v == settings.countyValue){
								html += '<option ' + settings.postcodeAttrName + '="' + v + '" value="' + k + '" selected="selected">' + k + '</option>';
							}else{
								html += '<option ' + settings.postcodeAttrName + '="' + v + '" value="' + k + '">' + k + '</option>';
							}
						});
						
						$this.html(html);
						
						if(prop != ''){
							_twzip[prop] = data;
						}

						$this.trigger('change');
					}
				});
			}
			
		};
		
		var _postcode = function(code){
			var $this = $(this);
			
			$this.attr({
				'readonly'	:	'readonly'
				,'value'	:	(code || '')
				,'placeholder'	:	settings.postcodePlaceholder
			}).css({
				'background':	'#CCC'
			});
		}
		
		var settings = $.extend({}, defaultOptions || {}, options || {});

		return this.each(function(){
			
			var $this = $(this);
			
			$this.on('change', function(){			
				if($(settings.county).length > 0){
					$(settings.county).on('change', function(){
						if($(settings.postcode).length > 0){
							_postcode.apply($(settings.postcode)[0], [$(settings.county).find(':selected').attr(settings.postcodeAttrName)]);
						}
					});
					_county.apply($(settings.county)[0], [$this.find(':selected').attr(settings.countyAttrName)]);
				}
			});
			
			if(settings.cityUrl){
				$.ajax({
					url:	settings.cityUrl,
					dataType:	'json',
					success:	function(data, status, xhr){
						var html = settings.cityPlaceholder ? '<option value>' + settings.cityPlaceholder + '</option>' : '';
						
						$.each(data, function(k, v){
							if(settings.cityValue && v == settings.cityValue){
								html += '<option ' + settings.countyAttrName + '="' + k + '" value="' + v + '" selected="selected">' + v + '</option>';
							}else{
								html += '<option ' + settings.countyAttrName + '="' + k + '" value="' + v + '">' + v + '</option>';
							}
						});
						
						$this.html(html);
						
						$this.trigger('change');
					}
				});
			}
		});
	};
})(jQuery);