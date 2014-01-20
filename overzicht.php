<?php
	require_once("inc/config.php");
	
	//Toegestane $_GET["cat"] opties
	$allowed = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek");
	
	//Check of de gebruiker ingelogd is / een geldige categorie is ingevuld
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $allowed)) {
		header("Location: /automate/");
	}
	
	//Check of er een limiet is opgegeven en of deze geldig is
	$_POST["limit"] = (isset($_POST["limit"]) && is_numeric($_POST["limit"])) ? (int)$_POST["limit"] : 15;
	
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
	 * Check of er een sorteerrichting is opgegeven en of deze geldig is */
	$_POST["sorteer_kolom"] = isset($_POST["sorteer_kolom"]) ? (in_array($_POST["sorteer_kolom"], $kolommen) ? $_POST["sorteer_kolom"] : $kolommen[0]) : $kolommen[0];
	$_POST["richting"] = isset($_POST["richting"]) ? ($_POST["richting"] == "op" ? "ASC" : "DESC") : "ASC";
	
	//Haal gegevens op uit de database
	$data = db_get($kolommen, $_GET["cat"], array(), $_POST["limit"], array($_POST["sorteer_kolom"], $_POST["richting"]));
	
	//Check of er uberhaupt gegevens opgehaald zijn
	if(count($data) > 0) {
		$presenteerbare_titels = array();
		
		//Vul een array met kolomtitels die voor de gebruiker leesbaar zijn gemaakt
		foreach($kolommen as $kolom) {
			$presenteerbare_titels[] = ucfirst(str_replace("_", " ", $kolom));
		}
		
		/* Stuur de huidige:
		 *  - sorteerrichting
		 *  - css icoon class die bij deze richting hoort
		 *  - sorteerkolom
		 *  - voor gebruikers leesbaar gemaakte titel van de geselecteerde sorteerkolom
		 *  - de array met kolomtitels zoals ze in de database staan
		 *  - de array met kolomtitels die voor de gebruiker leesbaar gemaakt zijn
		 *  - uit de database gehaalde gegevens
		 * naar het template */
		$smarty->assign("sorteer_richting", $_POST["richting"] == "ASC" ? "Oplopend" : "Aflopend");
		$smarty->assign("sorteer_richting_icoon", $_POST["richting"] == "ASC" ? "fa-toggle-up" : "fa-toggle-down");
		$smarty->assign("sorteer_kolom_leesbaar", ucfirst(str_replace("_", " ", $_POST["sorteer_kolom"])));
		$smarty->assign("sorteer_kolom", $_POST["sorteer_kolom"]);
		$smarty->assign("kolom_titels", $kolommen);
		$smarty->assign("presenteerbare_kolommen", $presenteerbare_titels);
		$smarty->assign("resultaten", $data);
	}
	
	//Stuur de huidige categorie naar het template
	$smarty->assign("categorie", $_GET["cat"]);
	
	//Laat het overzicht zien
	$smarty->display("overzicht.tpl");
?>