jQuery(function() {
	'use strict'

	$('#messages .message').each(function() {
		$(this).notify()
	})
})