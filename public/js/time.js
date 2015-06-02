jQuery(function() {
	'use strict'

	function updateClock(){
		var now = new Date()
		var second = now.getSeconds() * 6
		var minute = now.getMinutes() * 6 + second / 60
		var hour = ((now.getHours() % 12) / 12) * 360 + 90 + minute / 12

		$('#hour').css("transform", "rotate(" + hour + "deg)")
		$('#minute').css("transform", "rotate(" + minute + "deg)")
		$('#second').css("transform", "rotate(" + second + "deg)")
	}

	updateClock()

	setInterval(updateClock, 1000)
})