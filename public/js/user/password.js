jQuery(function($, document) {
	'use strict'

	var $submit = $('input[type="submit"]')
	var validator = new Validator($submit)

	validator.init([
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