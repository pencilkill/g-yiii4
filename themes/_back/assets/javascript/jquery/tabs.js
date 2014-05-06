$.fn.tabs = function() {
	var self = $(this);

	this.each(function() {
		var el = $(this); 
		
		$(el.attr('href')).hide();
		
		el.on('click', function(e){
			self.removeClass('selected');
			
			$.each(self, function(i, _el) {
				$($(_el).attr('href')).hide();
			});
			
			el.addClass('selected');
			
			$(el.attr('href')).show();
			
			e.preventDefault();
		});
	});

	self.show();
	
	self.first().trigger('click');
};