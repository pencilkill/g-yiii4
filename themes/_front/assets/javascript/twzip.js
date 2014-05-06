/**
 * @example
  	<select id="city"></select>
 	<select id="county"></select>
 	<input id="postcode" type="text"/>
	<script type="text/javascript" src="<?php echo $this->skinUrl?>/javascript/twzip.js"></script>
	<script type="text/javascript">$('#city').twzip();</script>
 */
(function($){
	$.fn.twzip = function(options){
		var defaultOptions = {
			city	:	undefined
			,cityUrl	:	'index.php?r=twzip/city'
			,cityAttrName	:	'data-city'	// city option attribute name which is used to get county data 
			,cityValue:	'twzip_city_id'		// city option value to fill
			,cityDefaultValue:	undefined
			,cityPlaceholder:	'-- 請選擇 --'
			,county	:	'#county'
			,countyUrl	:	'index.php?r=twzip/county'
			,countyValue	:	'twzip_county_id'	// county option value to fill
			,countyDefaultValue	:	undefined
			,countyPlaceholder	:	'-- 請選擇 --'
			,postcodeAttrName	:	'data-postcode'	// county option attribute name which holds the county postcode value
			,postcode	:	'#postcode'
			,postcodePlaceholder	:	undefined
		};
		
		var _county = function(twzip_city_id){
			var $this = $(this);
			
			if($this.data('twzip') == undefined){
				$this.data('twzip', {});
			}
			
			var _twzip = $this.data('twzip');
			
			var id = twzip_city_id ? twzip_city_id.toString() : '';	// city
			
			if(_twzip.hasOwnProperty(id)){
				var html = settings.countyPlaceholder ? '<option value>' + settings.countyPlaceholder + '</option>' : '';
				
				$.each(_twzip[id], function(k, v){  
					if(settings.countyValue && v.twzip_county_id == settings.countyValue){
						html += '<option ' + settings.postcodeAttrName + '="' + v.postcode + '" value="' + v.twzip_county_id + '" selected="selected">' + v.name + '</option>';
					}else{
						html += '<option ' + settings.postcodeAttrName + '="' + v.postcode + '" value="' + v.twzip_county_id + '">' + v.name + '</option>';
					}
				});
				
				$this.html(html);
				
				$this.trigger('change');
			}else if(settings.countyUrl){
				$.ajax({
					url:	settings.countyUrl,
					dataType:	'json',
					data:{
						'id'	:	id	// city id
					},
					success:	function(data, status, xhr){
						var html = settings.countyPlaceholder ? '<option value>' + settings.countyPlaceholder + '</option>' : '';
						
						$.each(data, function(k, v){
							if(settings.countyDefaultValue && v[settings.countyValue] == settings.countyDefaultValue){
								html += '<option ' + settings.postcodeAttrName + '="' + v.postcode + '" value="' + v[settings.countyValue] + '" selected="selected">' + v.name + '</option>';
							}else{
								html += '<option ' + settings.postcodeAttrName + '="' + v.postcode + '" value="' + v[settings.countyValue] + '">' + v.name + '</option>';
							}
						});
						
						$this.html(html);
						
						if(id != ''){
							_twzip[id] = data;
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
					_county.apply($(settings.county)[0], [$this.find(':selected').attr(settings.cityAttrName)]);
				}
			});
			
			if(settings.cityUrl){
				$.ajax({
					url:	settings.cityUrl,
					dataType:	'json',
					success:	function(data, status, xhr){
						var html = settings.cityPlaceholder ? '<option value>' + settings.cityPlaceholder + '</option>' : '';
						
						$.each(data, function(k, v){
							if(settings.cityDefaultValue && v[settings.cityValue] == settings.cityDefaultValue){
								html += '<option ' + settings.cityAttrName + '="' + v.twzip_city_id + '" value="' + v[settings.cityValue] + '" selected="selected">' + v.name + '</option>';
							}else{
								html += '<option ' + settings.cityAttrName + '="' + v.twzip_city_id + '" value="' + v[settings.cityValue] + '">' + v.name + '</option>';
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