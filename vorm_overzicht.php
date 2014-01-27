<?php
	require_once("inc/config.php");

	//Om aan het einde terug te geven aan Smarty
	$data = array();

	//Toegestane $_GET["cat"] opties
	$cat_toegestaan = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek");
	$acties_toegestaan = array("overzicht", "zoeken");
	
	//Check of de gebruiker ingelogd is / een geldige categorie is ingevuld
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $cat_toegestaan) || !in_array($_GET["actie"], $acties_toegestaan)) {
		header("Location: /automate/");
	}
	
	$data["categorie"] = $_GET["cat"];
	$data["actie"] = $_GET["actie"];

	//Als er geen formulier verstuurd is, dus geen zoekopdracht, herleiden naar het overzicht
	if($data["actie"] == "zoeken" && !$_POST) {
		header("Location: /automate/". $_GET["cat"] ."/overzicht/");
	}
	
	foreach($_POST as $key => $var) {
		if(isset($var) && empty($var)) {
			unset($_POST[$key]);
		}
	}
	
	$data["subtitel"] = ucfirst($data["actie"]); //twijfelgeval refactor
	$data["limiet"] = (isset($_POST["limiet"]) && is_numeric($_POST["limiet"]) && $_POST["limiet"] > 0) ? (int)$_POST["limiet"] : 15;
	$data["zoek_term"] = isset($_POST["zoek_term"]) ? clean($_POST["zoek_term"]) : "";
	
	$data["kolom_titels"] = geef_kolommen($data["categorie"], ($data["actie"] == "overzicht"));
	$data["presenteerbare_kolommen"] = array();
	
	foreach($data["kolom_titels"] as $kolom) {
		$data["presenteerbare_kolommen"][] = ucfirst(str_replace("_", " ", $kolom));
	}
	
	$data["sorteer_kolom"] = isset($_POST["sorteer_kolom"]) ? (in_array($_POST["sorteer_kolom"], $data["kolom_titels"]) ? $_POST["sorteer_kolom"] : $data["kolom_titels"][0]) : $data["kolom_titels"][0];
	$data["sorteer_kolom_leesbaar"] = ucfirst(str_replace("_", " ", $data["sorteer_kolom"]));
	$data["zoek_kolom"] = isset($_POST["zoek_kolom"]) ? clean($_POST["zoek_kolom"]) : $data["sorteer_kolom"];
	$data["zoek_kolom_leesbaar"] = ucfirst(str_replace("_", " ", $data["zoek_kolom"]));
	$data["richting"] = isset($_POST["richting"]) ? ($_POST["richting"] == "ASC" ? $_POST["richting"] : "DESC") : "ASC";
	$data["sorteer_richting_text"] = $data["richting"] == "ASC" ? "Oplopend" : "Aflopend";
	$data["sorteer_richting_icoon"] = "fa-sort-amount-". strtolower($data["richting"]);
	$data["pagina"] = (isset($_POST["pagina"]) && is_numeric($_POST["pagina"]) && $_POST["pagina"] > 0) ? $_POST["pagina"] : 1;
	
	$query = "SELECT ". implode(", ", tick($data["kolom_titels"])) ." ".
			 "FROM ". tick($data["categorie"]) ." ".
			 "WHERE ". tick($data["zoek_kolom"]) ." LIKE :zoek_term ".
			 "ORDER BY ". tick($data["sorteer_kolom"]) ." ". $data["richting"];
	
	$data["resultaten"] = array();
	//Voer de query daadwerkelijk uit
	try {
		$stmt = $pdo->prepare($query);
		$stmt->execute(array(
			"zoek_term" => "%". $data["zoek_term"] ."%"
		));
		
		$data["resultaten"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
		$data["fout"] = $e->getMessage();
	}

	//Check of er gegevens opgehaald zijn
	if(count($data["resultaten"]) > 0) {
		$data["aantal_rijen"] = count($data["resultaten"]);
		$data["aantal_paginas"] = ceil($data["aantal_rijen"] / $data["limiet"]);
		$data["pagina"] = ($data["pagina"] > $data["aantal_paginas"] && $data["aantal_paginas"] > 0) ? $data["aantal_paginas"] : $data["pagina"];
		
		//Knip de resultaten af met een bepaalde offset en limiet voor paginatie
		$data["resultaten"] = array_splice($data["resultaten"], (($data["pagina"] - 1) * $data["limiet"]), $data["limiet"]);
	}
	
	//Laat het overzicht zien
	$smarty->assign("data", $data);
	$smarty->display("overzicht.tpl");
?>