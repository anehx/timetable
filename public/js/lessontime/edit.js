jQuery(function() {
	'use strict'

	$('.timepicker').each(function() {
		$(this).timepicker({
			minuteStep: 5,
			showSeconds: false,
			showMeridian: false,
			defaultTime: false
		})
	})

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
				return $(selector).checkTime()
			}
		}
	])
})