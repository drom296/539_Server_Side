/**
 * @author tuxedo
 */

$(document).ready(function() {
	console.log("document is ready");
	
	$('.QapTcha').QapTcha({
		disabledSubmit : true,
		autoRevert : true,
		PHPfile: "js/qaptcha_v4.0/php/Qaptcha.jquery.php"
	});
});
