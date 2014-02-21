/**
 * @example
  	<select id="city" url="index.php?r=twzip/city" county="county"></select>
 	<select id="county" url="index.php?r=twzip/county" postcode="postcode"></select>
 	<input id="postcode" type="text"/>
	<script type="text/javascript">$('#city').twzip();</script>
 */
(function($){
	$.fn.twzip = function(options){
		var defaultOptions = {};
		
		var _county = function(id){
			var $this = $(this);
			
			if($this.data('twzip') == undefined){
				$this.data('twzip', {});
			}
			
			var _twzip = $this.data('twzip');
			
			var prop = id.toString();
			
			if(_twzip.hasOwnProperty(prop)){
				var html = '';
				
				$.each(_twzip[prop], function(k, v){
					html += '<option k="' + v + '" value="' + k + '">' + k + '</option>';
				});
				
				$this.html(html);
				
				$this.trigger('change');
			}else{
				$.ajax({
					url:	$this.attr('url'),
					dataType:	'json',
					data:{'id':id},
					success:	function(data, status, xhr){
						var html = '';
						
						$.each(data, function(k, v){
							html += '<option k="' + v + '" value="' + k + '">' + k + '</option>';
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
		
		return this.each(function(){
			var settings = $.extend({}, defaultOptions || {}, options || {});
			
			var $this = $(this);
			
			$this.on('change', function(){
				var el = $this.attr('county');
				
				if(el && $('#' + el).length > 0){
					var _el = $('#' + el);
					
					_el.on('change', function(){
						var __el = _el.attr('postcode');
						
						if(__el && $('#' + __el).length > 0){
							var ___el = $('#' + __el);
							
							___el.attr({'readonly':'readonly', 'value':_el.find(':selected').attr('k'), 'style':'background:#CCC'});
						}
					});
					
					_county.apply(document.getElementById(el), [$this.find(':selected').attr('k')]);
				}
			});
			
			$.ajax({
				url:	$this.attr('url'),
				dataType:	'json',
				success:	function(data, status, xhr){
					var html = '';
					
					$.each(data, function(k, v){
						html += '<option k="' + k + '" value="' + v + '">' + v + '</option>';
					});
					
					$this.html(html);
					
					$this.trigger('change');
				}
			});
			
		});
	};
})(jQuery);