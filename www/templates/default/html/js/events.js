require(['jquery', 'wdn', 'modernizr'], function($, WDN, Modernizr) {
	"use strict";
	
	var $progress = $('<progress>'),
		mqBp2 = '(min-width: 768px)';
	
	$(function() {
		var homeUrl = $('link[rel=home]'),
			mainScript = $('#script_main'),
			$monthWidget = $('.wp-calendar'),
			$sidebarCal,
			initRoute = 'day',
			widgetDate, nowActive, progressTimeout;
		
		if (homeUrl.length) {
			homeUrl = homeUrl[0].href;
		} else {
			homeUrl = '/';
		}
		
		if (mainScript.length) {
			mainScript = WDN.toAbs('./', mainScript[0].src);
		} else {
			mainScript = '/templates/default/html/js/';
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
				$(document.body).trigger("sticky_kit:recalc");
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
				stickyHeader();
				$(document.body).trigger("sticky_kit:recalc");
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
				$(document.body).trigger("sticky_kit:recalc");
			});
		}
		
		function stickyHeader()
		{
			if (!Modernizr.mediaqueries || Modernizr.mq(mqBp2)) {
				var $dayHeading = $('h1.day-heading, h1.upcoming-heading');
				if ($dayHeading.length) {
					require([mainScript + 'jquery.sticky-kit.min.js'], function() {
						$dayHeading.stick_in_parent();
					});
				}
			}
		}
		
		function stickySidebar()
		{
			if (!Modernizr.mediaqueries || Modernizr.mq(mqBp2)) {
				require([mainScript + 'jquery.sticky-kit.min.js'], function() {
					$sidebarCal.closest('aside').stick_in_parent();
				});
			}
		}
		
		$sidebarCal = $('aside .calendar');
		if ($sidebarCal.length) {
			determineActiveDay();
			addMonthWidgetStates();

			// Add a button for returning to "Today"
			$('<p>')
				.append($('<a>', {'class': 'return-today eventicon-angle-circled-left', 'href': '#'}).text('Return to today'))
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
		stickyHeader();
		
		if ($('.view-unl_ucbcn_frontend_eventinstance').length) {
			initRoute = 'event';
		}
		
		// set up arrow navigation
		$(document).on('keyup', function(e) {
			if ($(e.target).is('input, select, textarea, button')) {
				return;
			}
			
			var $dayNav = $('.day-nav'), day;
			
			if (!$dayNav.length) {
				return;
			}

			switch (e.which) {
				case 39:
					if (e.altKey) {
						day = new Date(nowActive);
						day.setMonth(day.getMonth() + 1);
					} else {
						day = $('.next', $dayNav).attr('href');
					}
					changeDay(day);
					break;
				case 37:
					if (e.altKey) {
						day = new Date(nowActive);
						day.setMonth(day.getMonth() - 1);
					} else {
						day = $('.prev', $dayNav).attr('href');
					}
					changeDay(day);
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
		
		$(window).on('resize', function() {
			if (Modernizr.mediaqueries && !Modernizr.mq(mqBp2)) {
				$monthWidget.trigger('sticky_kit:detach');
				$('h1').trigger('sticky_kit:detach');
			} else {
				stickySidebar();
				stickyHeader();
			}
		});
	});
});
