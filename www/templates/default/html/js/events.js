require(['jquery', 'wdn'], function($, WDN) {
	var $progress = $('<progress>'),
		months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	
	$(function() {
		var homeUrl = $('link[rel=home]'),
			$monthWidget = $('.wp-calendar'),
			widgetDate, nowActive, progressTimeout;
		
		if (homeUrl.length) {
			homeUrl = homeUrl[0].href;
		} else {
			homeUrl = '/';
		}
		
		function addMonthWidgetStates()
		{
			widgetDate = new Date($monthWidget.data('datetime'));
			
			var now = new Date(),
				month = widgetDate.getMonth(),
				year = widgetDate.getFullYear(),
				$dates = $('td', $monthWidget);
			
			$dates.removeClass('today active');
			if (year === now.getFullYear() && month === now.getMonth()) {
				$dates.not('.prev,.next').each(function() {
					var dateText = $.trim($(this).text());
					if (dateText == now.getDate()) {
						$(this).addClass('today');
						return false;
					}
				});
			}
			
			if (year == nowActive.getFullYear() && month == nowActive.getMonth()) {
				$dates.not('.prev,.next').each(function() {
					var dateText = $.trim($(this).text());
					if (dateText == nowActive.getDate()) {
						$(this).addClass('active');
						return false;
					}
				});
			};
		}
		
		function scheduleProgress($loadTo)
		{
			cancelProgress();
			$progress.hide();
			progressTimeout = setTimeout(function() {
				$progress.prependTo($loadTo);
				$progress.fadeIn(200);
			}, 1000)
		}
		
		function cancelProgress()
		{
			clearTimeout(progressTimeout);
		}
		
		function determineActiveDay()
		{
			var headingDate = $('h1').data('datetime');
			if (headingDate) {
				nowActive = new Date(headingDate);
			}
		}
		
		function loadMonthWidget(datetime)
		{
			var url, $loadTo = $('aside .calendar');
			if (datetime instanceof Date) {
				url = homeUrl + datetime.getFullYear() + '/' + (datetime.getMonth() + 1) + '/'; 
			} else {
				url = datetime;
			}
			
			scheduleProgress($loadTo);
			$.get(url + '?monthwidget&format=hcalendar', function(data) {
				cancelProgress();
				$loadTo.html(data);
				$monthWidget = $('.wp-calendar');
				addMonthWidgetStates();
			});
		}
		
		function changeDay(datetime)
		{
			var url, $loadTo = $('#updatecontent');
			if (datetime instanceof Date) {
				url = homeUrl + datetime.getFullYear() + '/' + (datetime.getMonth() + 1) + '/' + datetime.getDate() + '/';
			} else {
				url = datetime;
			}
			
			scheduleProgress($loadTo);
			$.get(url + '?format=hcalendar', function(data) {
				cancelProgress();
				$loadTo.html(data);
				determineActiveDay();
				if (widgetDate.getFullYear() !== nowActive.getFullYear() || widgetDate.getMonth() !== nowActive.getMonth()) {
					loadMonthWidget(nowActive);
				} else {
					addMonthWidgetStates();
				}
			});
		}
		
		var $sidebarCal = $('aside .calendar');
		if ($sidebarCal.length) {
			determineActiveDay();
			addMonthWidgetStates();
			
			$sidebarCal.on('click', 'td a', function(e) {
				e.preventDefault();
				changeDay(this.href);
			});
			
			$sidebarCal.on('click', '.next a, .prev a', function(e) {
				e.preventDefault();
				loadMonthWidget(this.href);
			})
		}
		
		// set up arrow navigation
		var $dayNav = $('.day-nav');
		if ($dayNav.length) {
			$(document).on('keyup', function(e) {
				if ($(e.target).is('input, select, textarea, button')) {
					return;
				}
				
				switch (e.which) {
					case 39:
						changeDay($('.day-nav .next').attr('href'));
						break;
					case 37:
						changeDay($('.day-nav .prev').attr('href'));
						break;
				}
			});
		}
	});
});
