jQuery(function() {
	'use strict'

	/**
	 * Updates the rotation of the analog clock
	 */
	function updateClock(){
		var now = new Date()
		var second = now.getSeconds() * 6
		var minute = now.getMinutes() * 6 + second / 60
		var hour = ((now.getHours() % 12) / 12) * 360 + 90 + minute / 12

		$('#hour').css("transform", "rotate(" + hour + "deg)")
		$('#minute').css("transform", "rotate(" + minute + "deg)")
		$('#second').css("transform", "rotate(" + second + "deg)")
	}

	/**
	 * Main function to highlight current lesson
	 */
	function updateHighlight() {
		var now = new Date()
		var weekday = now.getDay()

		if ($('#timetable').is(':visible')) {
			updateDesktopTable(now)
		}
		else {
			updateMobileTable(now)
		}
	}

	/**
	 * Highlight current lesson in the big desktop table
	 */
	function updateDesktopTable(now) {
		$('#timetable tbody tr').each(function(){
			$(this).find('td[data-weekday="'+now.getDay()+'"]').toggleClass('highlight', timeIsBetween($(this).data('time-from'), $(this).data('time-to'), now))
		})
	}

	/**
	 * Highlight current lesson in the small mobile tables
	 */
	function updateMobileTable(now) {
		var $table = $('#timetable-wd-'+now.getDay()+' tbody')

		$table.find('tr').each(function() {
			$(this).find('td.lesson').toggleClass('highlight', timeIsBetween($(this).data('time-from'), $(this).data('time-to'), now))
		})
	}

	/**
	 * Checks if a given time is between two given times
	 */
	function timeIsBetween(from, to, now) {
		var dtFrom = new Date()
		var dtTo   = new Date()
		var dtNow  = now

		// parse time string to date object
		dtFrom.setHours(from.split(':')[0], from.split(':')[1], 0, 0)
		dtTo.setHours(to.split(':')[0], to.split(':')[1], 0, 0)

		return dtNow < dtTo && dtNow > dtFrom
	}

	// Initially run update functions
	updateClock()
	updateHighlight()

	// Update clock every second
	setInterval(updateClock, 1000)
	// Update highlight every 10 seconds
	setInterval(updateHighlight, 10000)
})