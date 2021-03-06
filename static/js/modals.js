$(document).ready(function() {
	$("a[href*='zoeken']").click(function(e) {
		e.preventDefault();
		var a = $(this);
		
		$("#zoek_modal").modal("show");
		$("#zoek_form").attr("action", a.attr("href"));
		$("#zoek_modal").find(".mijn-dropdown-select").find("button").children("span").first().text("Zoeken op...");
		$("#zoek_modal").find(".mijn-dropdown-select").find("li").removeClass("active");
		$("#zoek_modal").find(".modal-title").children("span").text(a.parents("ul").siblings("a").text());
		$("#zoek_modal").find(".mijn-dropdown-select").find(".dropdown-menu").empty();

		$.getJSON("/automate/geef_kolommen.php?cat="+ a.attr("href").split("/")[2], function(data) {
			$.each(data, function(key, val) {
				$("#zoek_modal").find(".mijn-dropdown-select").find(".dropdown-menu").append("<li id=\""+ val +"\"><a href=\"#\">"+ (val.charAt(0).toUpperCase() + val.slice(1)).replace("_", " ") +"</a></li>");
			});
		});
	});
	
	$(".mijn-dropdown-select").on("click", "a", function(e) {
		e.preventDefault();
		var parent = $(this).parents(".mijn-dropdown-select");
		
		parent.find("li").removeClass("active");
		$(this).parent("li").addClass("active");
		
		parent.find("button").children("span").first().text($(this).text());
		$(this).parents("form").find("#"+ parent.data("references")).val($(this).parent("li").attr("id"));
	});
	
	$("#button_zoeken").click(function() {
		$("#zoek_form").find("#input_sorteer_kolom").val($("#zoek_form").find("#input_zoek_kolom").val());
		$("#zoek_form").submit();
	});
});