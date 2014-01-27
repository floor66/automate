var pages = ["werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek", "contract"];

var curr_page = "dashboard";
var loc = window.location.pathname;
for(var i = 0; i < pages.length; i++) {
	var base = "/automate/";
	var tmp = base + pages[i];
	if(loc.indexOf(tmp) > -1) {
		curr_page = loc.substring(base.length, tmp.length);
		break;
	}
}

$(":contains('"+ (curr_page.charAt(0).toUpperCase() + curr_page.slice(1)) +"')").addClass("active");
