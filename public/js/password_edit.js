jQuery(function($, document) {
	'use strict'

	var $oldPassword = $('input[name="oldPassword"]')
	var $password = $('input[name="password"]')
	var $confirmPassword = $('input[name="confirmPassword"]')
	var $submit = $('input[type="submit"]')

	var validOldPassword = false
	var validPassword = false
	var validConfirmPassword = false

	$oldPassword.on('change input blur', function(e)) {
		validateOldPassword()
		toggleSubmitButton()
	}

	$password.on('change input blur', function(e) {
		validatePassword()
		toggleSubmitButton()
	})

	$confirmPassword.on('change input blur', function(e) {
		validateConfirmPassword()
		toggleSubmitButton()
	})	

	$(document).keypress(function(e) {
		if (e.which == 13 && !(validOldPassword && validPassword && validConfirmPassword)) {
			e.preventDefault()
		}
	})

	function toggleSubmitButton() {
		$submit.toggleClass('disabled', !(validOldPassword && validPassword && validConfirmPassword))
	}

	function validateOldPasswort() {
		validOldPassword = !/[^A-Za-z0-9#%&\/()?!$-_]+/.test($oldPassword.val()) && $oldPassword.val().length <= 6
		$oldPassword.parent().toggleClass('has-error', !validOldPassword)
	}

	function validatePassword() {
		validPassword = !/[^A-Za-z0-9#%&\/()?!$-_]+/.test($password.val()) && $password.val().length <= 6
		$password.parent().toggleClass('has-error', !validPassword)
	}

	function validateConfirmPassword() {
		validConfirmPassword = !/[^A-Za-z0-9#%&\/()?!$-_]+/.test($confirmPassword.val()) && $confirmPassword.val().length <= 6 && $confirmPassword.val() === $password.val()
		$confirmPassword.parent().toggleClass('has-error', !validConfirmPassword)
	}
})

