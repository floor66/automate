quickmenu_pages = [
	{
		title: "Welkom@Performance",
		text: "Welkom bij Performance Autogarage. Wij doen ons uiterste best voor u en uw auto! Kom een keer langs voor een kijkje in onze showroom. Verder is dit opvultekst zonder enige nuttige betekenis!"
	},
	{
		title: "Performance Team",
		text: "Hier een stuk over hoe goed ons team wel niet is! Voor de rest is dit allemaal opvultekst zonder enige nuttige betekenis."
	},
	{
		title: "State-of-the-art garage",
		text: "De Performance autogarage is uitgerust met de allernieuwste ontwikkelingen op autotechnisch gebied, om een zo goed mogelijke service te kunnen bieden"
	},
	{
		title: "Unieke showroom",
		text: "Audi, Aston Martin, Porsche, we hebben het allemaal! Kom een keer langs in onze showroom. Verder is dit opvultekst zonder enige nuttige betekenis!"
	}
];

$(document).ready(function() {
	$(".quickmenu").children("li").each(function(i) {
		$(this).css("cursor", "pointer");
		$(this).on("click", function() {
			$(this).parents(".quickmenu").children("li").removeClass("active");
			$(this).addClass("active");
			$(".quickmenu-target").fadeOut(function() {
				$(this).html("<h3>"+ quickmenu_pages[i].title +"</h3>\n<p>"+ quickmenu_pages[i].text +"</p>");
				$(this).fadeIn();
			});
		});
	});
});