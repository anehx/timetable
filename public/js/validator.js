'use strict'

/**
 *
 * Basic validator class
 *
 * Use addListener to listen to a form field
 * and block buttons and shortkeys if field
 * is not valid
 *
 * Example:
 * 
 * var validator = new Validator()
 * validator.init([
 *	 {
 *     selector: 'input[name="username"]'
 *   , callback: function(selector) {
 *	     return $(selector).checkLength(1, 50)
 *     }
 *   }  
 * ])
 *
 */
function Validator($submit) {
	this.$submit = $submit
	this.fields  = {}
	this.isValid = false
}

Validator.prototype = {
	init: function(fields) {
		for (var i in fields) {
			var item = fields[i]
			this.addListener(item.selector, item.callback)
		}
	}

,	addListener: function(selector, callback) {
		this.fields[selector] = true

		$(document).on('change input blur', selector, function() {	
			this.fields[selector] = callback(selector)
			this.validate()
		}.bind(this))
	}

,	validate: function() {
		this.isValid = true
		for (var i in this.fields) {
			if (!this.fields[i]) {
				this.isValid = false
			}
			$(i).parent().toggleClass('has-error', !this.fields[i])
		}
		this.block()
	}

,	block: function() {
		this.$submit.toggleClass('disabled', !this.isValid)

		$(document).keypress(function(e) {
			if (e.which === 13 && !this.isValid) {
				e.preventDefault()
			}
			else {
				return true
			}
		}.bind(this))
	}
}

/**
 * Checks if a string contains special chars (mutations doesn't count as special char)
 */
$.fn.checkSpecialChar = function() {
	return !/[^A-Za-z0-9ÄÖÜäöüßéàè\s]+/.test(this.val())
}

/**
 * Checks if a string contains whitespaces
 */
$.fn.checkWhitespace = function() {
	return !/[\s]+/.test(this.val())
}

/**
 * Checks if a string contains digits
 */
$.fn.checkDigit = function() {
	return !/[\d]+/.test(this.val())
}

/**
 * Checks if a string contains mutation
 */
$.fn.checkMutation = function() {
	return !/[ÄÖÜäöüßéàè]+/.test(this.val())
}

/**
 * Checks if a strings length is between two digits
 */
$.fn.checkLength = function(min, max) {
	return this.val().length >= min && this.val().length <= max
}

/**
 * Checks if a password is valid:
 *  - only A-Za-z0-9#%&\/()?!$-_]+ used
 *  - at least one digit or special char
 *  - length between 6 and 50 chars
 */
$.fn.checkPassword = function() {
	return !/[^A-Za-z0-9#%&\/()?!$-_]+/.test(this.val()) && /[0-9]{1}|[#%&\/()?!$-_]{1}/.test(this.val()) && this.checkLength(6, 50)
}

/**
 * Checks if a time is valid
 */
$.fn.checkTime = function() {
	return /^[\d]{1,2}:[\d]{2}$/.test(this.val()) && this.checkLength(4, 5)
}