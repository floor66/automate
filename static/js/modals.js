$(document).ready(function() {
	$("a[href*='zoeken']").click(function(e) {
		e.preventDefault();
		
		$("#zoek_modal").modal("show");
		$("#zoek_form").attr("action", $(this).attr("href"));
		$("#zoek_modal").find(".mijn-dropdown-select").find("button").children("span").first().text("Zoeken op...");
		$("#zoek_modal").find(".mijn-dropdown-select").find("li").removeClass("active");
		$("#zoek_modal").find(".modal-title").children("span").text($(this).parents("ul").siblings("a").text());
	});
	
	$(".mijn-dropdown-select").find("li").children("a").click(function(e) {
		e.preventDefault();
		var parent = $(this).parents(".mijn-dropdown-select");
		
		parent.find("li").removeClass("active");
		$(this).parent("li").addClass("active");
		
		parent.find("button").children("span").first().text($(this).text());
		$(this).parents("form").find("#"+ parent.data("references")).val($(this).parent("li").attr("id"));
	});
	
	$("#button_zoeken").click(function() {
		$("#zoek_form").submit();
	});
});