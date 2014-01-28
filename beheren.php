<?php
	require_once("inc/config.php");
	
	//Toegestane $_GET["cat"] opties
	$cat_toegestaan = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek", "contract");
	
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $cat_toegestaan)) {
		header("Location: /automate/");
	}
	
	$data["categorie"] = $_GET["cat"];
	$instellingen = json_decode(file_get_contents(INSTELLINGEN_BESTAND), true);
	
	$rij = db_get(array(
		"kolommen" => "*",
		"tabel" => $data["categorie"],
		"limiet" => 1
	))[0];

	foreach($rij as $kolom => $waarde) {
		$data["kolommen"][$kolom] = array(
			"titel" => $kolom,
			"titel_net" => ucfirst(str_replace("_", " ", $kolom)),
			"weergeven_in_overzicht" => 1,
			"weergeven_als_vreemd" => 1
		);
	}
	
	if(isset($_POST["opslaan"])) {
		$instellingen["overzicht_kolommen"][$data["categorie"]] = array($data["categorie"] ."_id");
		$instellingen["vreemde_weergaven"][$data["categorie"]] = array();
		
		foreach($data["kolommen"] as $kolom) {
			if(isset($_POST["overzicht_kolommen"][$kolom["titel"]])) {
				$instellingen["overzicht_kolommen"][$data["categorie"]][] = $kolom["titel"];
			}
			
			if(isset($_POST["vreemde_weergaven"][$kolom["titel"]])) {
				$instellingen["vreemde_weergaven"][$data["categorie"]][] = $kolom["titel"];
			}
		}
		
		if(file_put_contents(INSTELLINGEN_BESTAND, json_encode($instellingen))) {
			$data["bericht"] = array(
				"type" => "gelukt",
				"text" => "Weergave instellingen succesvol bijgewerkt!"
			);
		} else {
			$data["bericht"] = array(
				"type" => "fout",
				"text" => "WeergEr is iets fout gegaan bij het opslaan van de instellingen. Raadpleeg de systeembeheerder."
			);
		}
	}

	foreach($data["kolommen"] as $kolom) {
		if(!@in_array($kolom["titel"], $instellingen["overzicht_kolommen"][$data["categorie"]])) {
			$data["kolommen"][$kolom["titel"]]["weergeven_in_overzicht"] = 0;
		}
		
		if(!@in_array($kolom["titel"], $instellingen["vreemde_weergaven"][$data["categorie"]])) {
			$data["kolommen"][$kolom["titel"]]["weergeven_als_vreemd"] = 0;
		}
	}
	
	$smarty->assign("data", $data);
	$smarty->display("beheren.tpl");
?>