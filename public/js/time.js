jQuery(function() {
	'use strict'

	function checkTime(i) {
		return (i < 10) ? "0" + i : i;
	}

	function startTime() {
		var today = new Date()
		var h = checkTime(today.getHours())
		var m = checkTime(today.getMinutes())
		var s = checkTime(today.getSeconds())

		$('#time').html(h + ":" + m + ":" + s)

		setTimeout(function() {
			startTime()
		}, 500);
	}
	startTime();
})