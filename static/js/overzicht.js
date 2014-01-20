$(document).ready(function() {
	//Custom sorteermethode omdat datums in de database UNIX timestamps zijn
	$.tablesorter.addParser({
		id: "myDateSort",
		is: function (s) {
			return false;
		},
		format: function (s, table, cell, cellIndex) {
			return $(cell).data("date");
		},
		type: "numeric"
	});
	
	var headerSet = {};
	
	//Vind alle datumkolommen
	$("#overzicht").find("th").each(function(i) {
		if($(this).text().toLowerCase().indexOf("datum") > -1) {
			//Zorg dat de custom methode toegepast wordt hier
			headerSet[i] = {
				sorter: "myDateSort"
			};
		}
	});
	
	$("#overzicht").tablesorter({
		headers: headerSet
	});
	
	//Bepaal de ingevoerde limiet of geef standaardwaarde
	function getLim() {
		return $("#limit").val() < 1 ? ($("#limit").attr("placeholder") < 1 ? 15 : $("#limit").attr("placeholder")) : $("#limit").val();
	}
	
	//Redirect naar de juiste url aan de hand van het sorteermenu
	$("#vertoon").click(function() {
		var cat = window.location.pathname.split("/")[2];
		var richting = $("#richting").children("i").hasClass("fa-toggle-down") ? "af" : "op";
		
		window.location.href = "/automate/"+ cat +"/overzicht/"+ getLim() +"/"+ $(".sorteren-veranderen.active").attr("id") +"/"+ richting +"/";
	});
	
	//Update voor soort custom <select> element bestaande uit een Bootstrap dropdown
	$(".sorteren-veranderen").click(function(e) {
		e.preventDefault();
		
		$(".sorteren-veranderen").removeClass("active");
		$(this).addClass("active");
		
		$("#selected").children("span").first().text($(this).text());
	});
	
	//Verander text als de sorteerrichting aan/uitgecheckt wordt
	$("#richting").click(function() {
		var curr = $(this).children("i").hasClass("fa-toggle-up");
		$(this).children("i").removeClass("fa-toggle-up fa-toggle-down");
		
		$(this).children("span").text(curr ? "Aflopend" : "Oplopend");
		$(this).children("i").addClass(curr ? "fa-toggle-down" : "fa-toggle-up");
	});
});
