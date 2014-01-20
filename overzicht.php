<?php
	require_once("inc/config.php");
	
	//Toegestane $_GET["cat"] opties
	$allowed = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek");
	
	//Check of de gebruiker ingelogd is / een geldige categorie is ingevuld
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $allowed)) {
		header("Location: /automate/");
	}
	
	//Check of er een limiet is opgegeven en of deze geldig is
	$_GET["lim"] = (isset($_GET["lim"]) && is_numeric($_GET["lim"])) ? (int)$_GET["lim"] : 15;
	
	//Haal de weergave instellingen op voor deze categorie
	$weergave_inst = json_decode(file_get_contents(BESTAND_WEERGAVE_INSTELLINGEN), true)[$_GET["cat"]];
	$kolommen = array();
	
	//Vul een array met kolommen die "aan" staan in de weergave instellingen
	foreach($weergave_inst as $k => $v) {
		if($v == 1) {
			$kolommen[] = $k;
		}
	}
	
	/* Check of er een sorteerkolom is opgegeven en of deze geldig is
	   Check of er een sorteerrichting is opgegeven en of deze geldig is */
	$_GET["sort"] = isset($_GET["sort"]) ? (in_array($_GET["sort"], $kolommen) ? $_GET["sort"] : $kolommen[0]) : $kolommen[0];
	$_GET["dir"] = isset($_GET["dir"]) ? ($_GET["dir"] == "op" ? "ASC" : "DESC") : "ASC";
	
	//Haal gegevens op uit de database
	$data = db_get($kolommen, $_GET["cat"], array(), $_GET["lim"], array($_GET["sort"], $_GET["dir"]));
	
	//Check of er uberhaupt gegevens opgehaald zijn
	if(count($data) > 0) {
		$presenteerbare_titels = array();
		
		//Vul een array met kolomtitels die voor de gebruiker leesbaar zijn gemaakt
		foreach($kolommen as $kolom) {
			$presenteerbare_titels[] = ucfirst(str_replace("_", " ", $kolom));
		}
		
		/* Stuur de huidige:
		 *  - categorie
		 *  - sorteerrichting
		 *  - voor gebruikers leesbaar gemaakte titel van de geselecteerde sorteerkolom
		 *  - de array met kolomtitels zoals ze in de database staan
		 *  - de array met kolomtitels die voor de gebruiker leesbaar gemaakt zijn
		 *  - uit de database gehaalde gegevens
		 */
		$smarty->assign("categorie", ucfirst($_GET["cat"]));
		$smarty->assign("sorteer_richting", $_GET["dir"] == "ASC" ? "Oplopend" : "Aflopend");
		$smarty->assign("sorteer_titel", ucfirst(str_replace("_", " ", $_GET["sort"])));
		$smarty->assign("kolom_titels", $kolommen);
		$smarty->assign("presenteerbare_titels", $presenteerbare_titels);
		$smarty->assign("resultaten", $data);
	}
	
	//Laat het overzicht zien
	$smarty->display("overzicht.tpl");
?>