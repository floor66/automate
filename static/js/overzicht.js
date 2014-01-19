$(document).ready(function() {
	$("#overzicht").tablesorter({
		dateFormat: "dd-mm-yyyy",
		sortList: [[0, 0]]
	});
	
	$("#resultaten").find("button").click(function() {
		if($("#limit").val() > 0) {
			var href = window.location.pathname.split("/")[2];
			window.location.href = "/automate/"+ href +"/overzicht/"+ $("#limit").val() +"/";
		} else {
			$("#limit").val("");
		}
	});
});
