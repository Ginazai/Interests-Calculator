$(document).ready(function() {
	$.ajax({
		url: "php/unset.php",
		method: "GET",
		dataType: "script"
	});
});