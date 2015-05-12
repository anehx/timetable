jQuery(function($, document) {
	'use strict'

	var $username = $('input[name="username"]')
	var $firstName = $('input[name="firstName"]')
	var $lastName = $('input[name="lastName"]')
	var $password = $('input[name="password"]')
	var $confirmPassword = $('input[name="confirmPassword"]')
	var $submit = $('input[type="submit"]')

	var validUsername = false
	var validFirstName = false
	var validLastName = false
	var validPassword = false
	var validConfirmPassword = false

	$username.on('change input blur', function(e) {
		validateUsername()
		toggleSubmitButton()
	})

	$firstName.on('change input blur', function(e) {
		validateFirstName()
		toggleSubmitButton()
	})
	
	$lastName.on('change input blur', function(e) {
		validateLastName()
		toggleSubmitButton()
	})

	$password.on('change input blur', function(e) {
		validatePassword()
		toggleSubmitButton()
	})

	$confirmPassword.on('change input blur', function(e) {
		validateConfirmPassword()
		toggleSubmitButton()
	})	

	$(document).keypress(function(e) {
		if (e.which == 13 && !(validUsername && validFirstName && validLastName && validPassword && validConfirmPassword)) {
			e.preventDefault()
		}
	})

	function toggleSubmitButton() {
		$submit.toggleClass('disabled', !(validUsername && validFirstName && validLastName && validPassword && validConfirmPassword))
	}

	function validateUsername() {
		validUsername = !/[^A-Za-z0-9\s]+/.test($username.val()) && $username.val().length < 50 && $username.val().length > 1
		$username.parent().toggleClass('has-error', !validUsername)
	}

	function validateFirstName() {
		validFirstName = !/[^A-Za-zäöüéàè\s]+/.test($firstName.val()) && $firstName.val().length < 50
		$firstName.parent().toggleClass('has-error', !validFirstName)	
	}

	function validateLastName() {
		validLastName = !/[^A-Za-zäöüéàè\s]+/.test($lastName.val()) && $lastName.val().length < 50
		$lastName.parent().toggleClass('has-error', !validLastName)
	}

	function validatePassword() {
		validPassword = !/[^A-Za-z0-9#%&/(/)?!$-_]+/.test($password.val()) && $password.val().length >= 6
		$password.parent().toggleClass('has-error', !validPassword)
	}

	function validateConfirmPassword() {
		validConfirmPassword = !/[^A-Za-z0-9#%&/(/)?!$-_]+/.test($confirmPassword.val()) && $confirmPassword.val().length >= 6 && $confirmPassword.val() === $password.val()
		$confirmPassword.parent().toggleClass('has-error', !validConfirmPassword)
	}
})

