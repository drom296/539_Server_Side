/**
 * @author tuxedo
 */

console.log("Jquery no work");

$(document).ready(function() {
	console.log("document is ready");
	
	$('.QapTcha').QapTcha({
		disabledSubmit : true,
		autoRevert : true,
		PHPfile: "js/qaptcha/php/Qaptcha.jquery.php"
	});
});
