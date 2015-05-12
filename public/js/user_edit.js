$(document).ready(function {

	function validation() {
		var ok = true;
		var errors = [];
		var username = document.getElementsByName('username');
		var first_name = document.getElementsByName('first_name');
		var last_name = document.getElementsByName('last_name');
		var new_password = document.getElementsByName('new_password');
		var confirm_password = document.getElementsByName('confirm_password');

		if (trim(username.value) == "" || trim(first_name.value) == "" || trim(last_name.value) == "") {
			$(username).style('border', '1px solid red');
			ok = false;
		}
		if (new_password.value.lenght < 6) {
			$(new_password).style('border', '1px solid red');
			ok = false;
			new_password.focus();
		}
		if (new_password.value != confirm_password.value) {
			$(confirm_password).style('border', '1px solid red');
			ok = false;
			confirm_password.focus();
		}
		if (!isAlphanumeric(username.value)) {
			$(username).style('border', '1px solid red;');
			ok = false;
			username.focus();
		}
		return ok;
	}
});
