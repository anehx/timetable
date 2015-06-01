jQuery(function() {
	'use strict'

	var $submit = $('input[type="submit"]')
	var validator = new Validator($submit)

	validator.init([
		{
			selector: 'input[name="startTime"]'
		,	callback: function(selector) {
				return $(selector).checkTime()
			}
		}
	,	{
			selector: 'input[name="endTime"]'
		,	callback: function(selector) {
				return $(selector).checkTime() && compareTimeString(
						$('input[name="startTime"]').val(),
						$(selector).val()
					)
			}
		}
	])

	/**
	 * Checks if the "to" time is later than the "from" time
	 */
	function compareTimeString(from, to) {
		var dtFrom = new Date()
		var dtTo   = new Date()

		// parse time string to date object
		dtFrom.setHours(from.split(':')[0], from.split(':')[1], 0, 0)
		dtTo.setHours(to.split(':')[0], to.split(':')[1], 0, 0)

		return dtTo > dtFrom;
	}

	/**
	 * Initialize the timepicker
	 */
	$('.timepicker').each(function() {
		$(this).timepicker({
			minuteStep: 5,
			showSeconds: false,
			showMeridian: false,
			defaultTime: false
		})
	})
})