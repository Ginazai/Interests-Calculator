<?php
session_start();
if(isset($_SESSION['error'])) {
	echo "
	$(document).ready(function() {
		setTimeout(() => {
			$('#alert-box').addClass('visually-hidden');
		}, 2500);
	});";
	unset($_SESSION['error']);
}
?>