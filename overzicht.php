<?php
	require_once("inc/config.php");
	
	//Om aan het einde terug te geven aan Smarty
	$data = array();

	//Toegestane $_GET["cat"] opties
	$overzicht_toegestaan = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek");
	
	//Check of de gebruiker ingelogd is / een geldige categorie is ingevuld
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $overzicht_toegestaan)) {
		header("Location: /automate/");
	}
	
	//Stuur de huidige categorie straks naar het template
	$data["categorie"] = $_GET["cat"];
	
	//Check of er een limiet is opgegeven en of deze geldig is
	$data["limiet"] = (isset($_POST["limiet"]) && is_numeric($_POST["limiet"]) && $_POST["limiet"] > 0) ? (int)$_POST["limiet"] : 15;
	
	//Haal de weergave instellingen op voor deze categorie
	$weergave_inst_bestand = json_decode(file_get_contents(BESTAND_WEERGAVE_INSTELLINGEN), true)[$_GET["cat"]];
	$data["kolom_titels"] = array();
	
	//Vul een array met kolommen die "aan" staan in de weergave instellingen
	foreach($weergave_inst_bestand as $kolom => $status) {
		if($status == 1) {
			$data["kolom_titels"][] = $kolom;
		}
	}
	
	/* Check of er een sorteerkolom is opgegeven en of deze geldig is
	 * Check of er een sorteerrichting is opgegeven en of deze geldig is
	 * Check of er een paginanummer is opgegeven en of deze geldig is */
	$data["sorteer_kolom"] = isset($_POST["sorteer_kolom"]) ? (in_array($_POST["sorteer_kolom"], $data["kolom_titels"]) ? $_POST["sorteer_kolom"] : $data["kolom_titels"][0]) : $data["kolom_titels"][0];
	$data["richting"] = isset($_POST["richting"]) ? ($_POST["richting"] == "ASC" ? $_POST["richting"] : "DESC") : "ASC";
	$data["pagina"] = (isset($_POST["pagina"]) && is_numeric($_POST["pagina"]) && $_POST["pagina"] > 0) ? $_POST["pagina"] : 1;
	
	//Haal (ongeveer) het totaal aantal rijen van de opgevraagde categorie uit de database
	try {
		$stmt = $pdo->prepare("SELECT `TABLE_NAME`, `AUTO_INCREMENT` FROM `information_schema`.`tables` WHERE `TABLE_SCHEMA` = :db AND `TABLE_NAME` = :table");
		$stmt->execute(array(
			"db" => DATABASE_NAAM,
			"table" => $data["categorie"]
		));
	} catch(PDOException $e) {
		echo "Error: ". $e->getMessage();
	}
	
	$data["aantal_rijen"] = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["AUTO_INCREMENT"] - 1;
	$data["aantal_paginas"] = ceil($data["aantal_rijen"] / $data["limiet"]);
	$data["pagina"] = ($data["pagina"] > $data["aantal_paginas"] && $data["aantal_paginas"] > 0) ? $data["aantal_paginas"] : $data["pagina"];
	
	//Haal gegevens op uit de database
	$rijen = db_get(array(
		"kolommen" => $data["kolom_titels"],
		"tabel" => $data["categorie"],
		"sorteer_op" => array(
			"kolom" => $data["sorteer_kolom"],
			"richting" => $data["richting"]
		),
		"limiet" => array(
			"offset" => ($data["pagina"] - 1) * $data["limiet"],
			"aantal" => $data["limiet"]
		)
	));
	
	//Check of er uberhaupt gegevens opgehaald zijn
	if(count($rijen) > 0) {
		$data["presenteerbare_kolommen"] = array();
		
		//Vul een array met kolomtitels die voor de gebruiker leesbaar zijn gemaakt
		foreach($data["kolom_titels"] as $kolom) {
			$data["presenteerbare_kolommen"][] = ucfirst(str_replace("_", " ", $kolom));
		}
		
		/* Stuur de huidige:
		 *  - sorteerrichting
		 *  - css icoon class die bij deze richting hoort
		 *  - voor gebruikers leesbaar gemaakte titel van de geselecteerde sorteerkolom
		 *  - uit de database gehaalde gegevens
		 * naar het template */
		$data = array_merge($data, array(
			"sorteer_richting_text" => $data["richting"] == "ASC" ? "Oplopend" : "Aflopend",
			"sorteer_richting_icoon" => "fa-sort-amount-". strtolower($data["richting"]),
			"sorteer_kolom_leesbaar" => ucfirst(str_replace("_", " ", $data["sorteer_kolom"])),
			"resultaten" => $rijen
		));
	}
	
	//Laat het overzicht zien
	$smarty->assign("data", $data);
	$smarty->display("overzicht.tpl");
?>