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
		return $("#input_limiet").val() < 1 ? ($("#input_limiet").attr("placeholder") < 1 ? 15 : $("#input_limiet").attr("placeholder")) : $("#input_limiet").val();
	}
	
	//Redirect naar de juiste url aan de hand van het sorteermenu
	$("#button_vertoon").click(function() {
		$("#input_richting").val($("#richting_toggle").children("i").hasClass("fa-sort-amount-desc") ? "DESC" : "ASC");
		$("#input_limiet").val(getLim());
		$("#input_pagina").val($("#dropdown_input_pagina").val() > 0 ? $("#dropdown_input_pagina").val() : ($("#input_pagina").val() > 0 ? $("#input_pagina").val() : 1));
		
		$("#sorteer_form").submit();
	});
	
	//Verander text als de sorteerrichting aan/uitgecheckt wordt
	$("#richting_toggle").click(function() {
		var curr = $(this).children("i").hasClass("fa-sort-amount-asc");
		$(this).children("i").attr("class", "").addClass("fa fa-fw");
		
		$(this).children("span").text(curr ? "Aflopend" : "Oplopend");
		$(this).children("i").addClass(curr ? "fa-sort-amount-desc" : "fa-sort-amount-asc");
	});
	
	$("#dropdown_input_pagina").parent().click(function(e) {
		e.preventDefault();

		if(e.target.id == "dropdown_input_pagina") {
			e.stopPropagation();
		}
	});
	
	$("#dropdown_pagina_verstuur").parent().click(function() {
		$("#button_vertoon").trigger("click");
	});
	
	$("#pagina_buttons").children("button").click(function() {
		$("#input_pagina").val($(this).data("pagina"));
		
		$("#button_vertoon").trigger("click");
	});
});
