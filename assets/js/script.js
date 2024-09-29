$(document).ready(() => {
	var alert_length=$("#alert-box").html().trim().length
	if (alert_length<1){
	  	$("#alert-box").addClass("visually-hidden")
	}
})