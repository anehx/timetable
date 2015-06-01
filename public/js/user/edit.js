jQuery(function($, document) {
	'use strict'
	'use strict'

	var $submit = $('input[type="submit"]')
	var validator = new Validator($submit)

	validator.init([
		{
			selector: 'input[name="username"]'
		,	callback: function(selector) {
				return $(selector).checkSpecialChar() && $(selector).checkMutation() && $(selector).checkWhitespace() && $(selector).checkLength(1, 50)
			}
		}
	,	{
			selector: 'input[name="firstName"]'
		,	callback: function(selector) {
				if ($(selector).val()) {
					return $(selector).checkSpecialChar() && $(selector).checkLength(1, 50) && $(selector).checkDigit()
				}
				else {
					return true
				}
			}
		}
	,	{
			selector: 'input[name="lastName"]'
		,	callback: function(selector) {
				if ($(selector).val()) {
					return $(selector).checkSpecialChar() && $(selector).checkLength(1, 50) && $(selector).checkDigit()
				}
				else {
					return true
				}
			}
		}
	,	{
			selector: 'input[name="password"]'
		,	callback: function(selector) {
				return $(selector).checkPassword()
			}
		}
	,	{
			selector: 'input[name="confirmPassword"]'
		,	callback: function(selector) {
				return $(selector).checkPassword() && ($(selector).val() === $('input[name="password"]').val())
			}
		}
	])
})