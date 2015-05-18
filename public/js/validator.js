'use strict'

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

$.fn.checkSpecialChar = function() {
	return !/[^A-Za-z0-9ÄÖÜäöüßéàè\s]+/.test(this.val())
}

$.fn.checkWhitespace = function() {
	return !/[\s]+/.test(this.val())
}

$.fn.checkMutation = function() {
	return !/[ÄÖÜäöüßéàè]+/.test(this.val())
}

$.fn.checkLength = function(min, max) {
	return this.val().length >= min && this.val().length <= max
}

$.fn.checkPassword = function() {
	return !/[^A-Za-z0-9#%&\/()?!$-_]+/.test(this.val()) && /[0-9]{1}|[#%&\/()?!$-_]{1}/.test(this.val()) && this.checkLength(6, 50)
}

$.fn.checkTime = function() {
	return /^[\d]{1,2}:[\d]{2}$/.test(this.val()) && this.checkLength(4, 5)
}