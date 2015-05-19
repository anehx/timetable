jQuery(function() {
	'use strict'

	var $submit = $('input[type="submit"]')
	var validator = new Validator($submit)

	validator.init([
		{
			selector: 'input[name="name"]'
		,	callback: function(selector) {
				return $(selector).checkLength(1, 50) && $(selector).checkSpecialChar()
			}
		}
	,	{
			selector: 'select[name="weekday"]'
		,	callback: function(selector) {
				return $(selector).val() != 0
			}
		}
	,	{
			selector: 'select[name="lessonTimeID"]'
		,	callback: function(selector) {
				console.log($(selector).val())
				return $(selector).val() != 0
			}
		}
	])
})