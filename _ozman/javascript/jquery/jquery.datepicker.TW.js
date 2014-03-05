jQuery.datepicker._phoenixGenerateMonthYearHeader = jQuery.datepicker._generateMonthYearHeader;
jQuery.datepicker._generateMonthYearHeader = function(inst, drawMonth, drawYear, minDate, maxDate, selectedDate, secondary, monthNames, monthNamesShort){
	var result = $($.datepicker._phoenixGenerateMonthYearHeader(inst, drawMonth, drawYear, minDate, maxDate, selectedDate, secondary, monthNames, monthNamesShort));
	
	result.children(".ui-datepicker-year").children().each(function(x){
		var suffix = '民';
		var re = new RegExp('^' + suffix);
		var year = $(this).text();
		if(year.match(re)){
			// nothing
		} else {
			var bbb = parseInt(year) - 1911;
			var aaa = suffix + (bbb < 0 ? '前' : '國' ) + Math.abs(bbb);
			result.children(".ui-datepicker-year").children().eq(x).text(aaa);
		}
	});
	
	return '<div class="ui-datepicker-title">'+result.html()+'</div>';
};