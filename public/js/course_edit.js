jQuery(function($, document) {
	'use strict'

	var $nameField = $('input[name="name"]')
	var $submit = $('input[type="submit"]')

	$nameField.on('change blur', function() {
		validate()
	})

	function validate() {
		var validName = validateName()
		$nameField.parent().toggleClass('has-error', validName)
		$submit.toggleClass('disabled', validName)
	}

	function validateName() {
		return /[^A-Za-z0-9\s]+/.test($nameField.val()) || $nameField.val().length > 50 || $nameField.val().length < 1
	}
})