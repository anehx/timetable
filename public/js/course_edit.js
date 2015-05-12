jQuery(function() {
	'use strict'

	var $nameField = $('input[name="name"]')
	var $submit = $('input[type="submit"]')
	var validName = false;

	$nameField.on('change input blur', function(e) {
		validate()
	})

	$(document).keypress(function(e) {
		if (e.which == 13 && !validName) {
			e.preventDefault()
		}
	})

	function validate() {
		validateName()

		$nameField.parent().toggleClass('has-error', !validName)
		$submit.toggleClass('disabled', !validName)
	}

	function validateName() {
		validName = !/[^A-Za-z0-9\s]+/.test($nameField.val()) && $nameField.val().length < 50 && $nameField.val().length > 1
	}
})