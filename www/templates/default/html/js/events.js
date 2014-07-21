require(['jquery', 'wdn'], function($, WDN) {
	var $progress = $('<progress>'),
		months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	
	$(function() {
		var $monthWidget = $('.wp-calendar')
		if ($monthWidget.length) {
			var now = new Date();
				month = $.trim($('.monthvalue', $monthWidget).text()),
				year = $.trim($('.yearvalue', $monthWidget).text());
			
			if (year == now.getFullYear() && month == months[now.getMonth()]) {
				$('td', $monthWidget).not('.prev,.next').each(function() {
					if ($.trim($(this).text()) == now.getDate()) {
						$(this).addClass('today');
						return false;
					}
				});
			}
		}
	});
});
