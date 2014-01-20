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
		$("#richting").val($("#richting_toggle").children("i").hasClass("fa-sort-amount-desc") ? "af" : "op");
		$("#limit").val(getLim());
		$("#pagina").val($("#pagina_input").val() > 0 ? $("#pagina_input").val() : ($("#pagina").val() > 0 ? $("#pagina").val() : 1));
		
		$("#sorteer_form").submit();
	});
	
	//Update voor soort custom <select> element bestaande uit een Bootstrap dropdown
	$(".sorteren-veranderen").click(function(e) {
		e.preventDefault();
		
		$(".sorteren-veranderen").removeClass("active");
		$(this).addClass("active");
		
		$("#selected").children("span").first().text($(this).text());
		$("#sorteer_kolom").val($(this).attr("id"));
	});
	
	//Verander text als de sorteerrichting aan/uitgecheckt wordt
	$("#richting_toggle").click(function() {
		var curr = $(this).children("i").hasClass("fa-sort-amount-asc");
		$(this).children("i").attr("class", "").addClass("fa fa-fw");
		
		$(this).children("span").text(curr ? "Aflopend" : "Oplopend");
		$(this).children("i").addClass(curr ? "fa-sort-amount-desc" : "fa-sort-amount-asc");
	});
	
	$("#pagina_input").parent().click(function(e) {
		e.preventDefault();

		if(e.target.id == "pagina_input") {
			e.stopPropagation();
		}
	});
	
	$("#ga_naar_pagina").parent().click(function() {
		$("#vertoon").trigger("click");
	});
	
	$("#pagina_knoppen").children("button").click(function() {
		$("#pagina").val($(this).data("pagina"));
		
		$("#vertoon").trigger("click");
	});
});
