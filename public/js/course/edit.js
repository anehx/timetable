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
	])
})