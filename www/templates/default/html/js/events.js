require(['jquery', 'wdn'], function($, WDN) {
	"use strict";
	
	var $progress = $('<progress>'),
		months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	
	$(function() {
		var homeUrl = $('link[rel=home]'),
			$monthWidget = $('.wp-calendar'),
			initRoute = 'day',
			widgetDate, nowActive, progressTimeout;
		
		if (homeUrl.length) {
			homeUrl = homeUrl[0].href;
		} else {
			homeUrl = '/';
		}
		
		function pushState(url, route)
		{
			if (!window.history.pushState) {
				return;
			}
			
			if (window.location.href === url) {
				return;
			}
			
			window.history.pushState({route: route}, '', url);
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
			} else {
				nowActive = new Date();
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
			
			pushState(url, 'day');
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
		
		function loadEventInstance(href)
		{
			var $loadTo = $('#updatecontent');
			
			pushState(href, 'event');
			scheduleProgress();
			$.get(href + '?format=hcalendar', function(data) {
				cancelProgress();
				$loadTo.html(data);
			});
		}
		
		var $sidebarCal = $('aside .calendar');
		if ($sidebarCal.length) {
			determineActiveDay();
			addMonthWidgetStates();
			
			// Add a button for returning to "Today"
			$('<p>', {'class': 'wdn-center'})
				.append($('<a>', {'class': 'wdn-button', 'href': '#'}).text('Today'))
				.click(function(e) {
					e.preventDefault();
					changeDay(new Date());
				})
				.insertAfter($sidebarCal);
			
			$sidebarCal.on('click', 'td a', function(e) {
				e.preventDefault();
				changeDay(this.href);
			});
			
			$sidebarCal.on('click', '.next a, .prev a', function(e) {
				e.preventDefault();
				loadMonthWidget(this.href);
			});
		}
		
		if ($('.view-unl_ucbcn_frontend_eventinstance').length) {
			initRoute = 'event';
		}
		
		// set up arrow navigation
		$(document).on('keyup', function(e) {
			if ($(e.target).is('input, select, textarea, button')) {
				return;
			}
			
			var $dayNav = $('.day-nav');
			
			if (!$dayNav.length) {
				return;
			}
			
			switch (e.which) {
				case 39:
					changeDay($('.next', $dayNav).attr('href'));
					break;
				case 37:
					changeDay($('.prev', $dayNav).attr('href'));
					break;
			}
		});
		
		$('#updatecontent').on('click', '.vevent a.summary', function(e) {
			e.preventDefault();
			loadEventInstance(this.href);
		});
		
		$(window).on('popstate', function(e) {
			var route = (e.originalEvent.state && e.originalEvent.state.route) || initRoute,
				url = window.location.href;
			
			switch (route) {
				case 'event':
					loadEventInstance(url);
					break;
				case 'day':
					changeDay(url)
					break;
			}
		});
	});
});
