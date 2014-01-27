<?php
	require_once("inc/config.php");
	
	//Toegestane $_GET["cat"] opties
	$cat_toegestaan = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek", "contract");
	
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $cat_toegestaan)) {
		header("Location: /automate/");
	}
	
	$data["categorie"] = $_GET["cat"];
	$data["weergave_instellingen"] = json_decode(file_get_contents(BESTAND_WEERGAVE_INSTELLINGEN), true);

	if(isset($_POST["opslaan"])) {
		$inst = array();
		
		foreach($data["weergave_instellingen"][$data["categorie"]] as $kolom => $status) {
			$inst[$kolom] = isset($_POST[$kolom]) ? 1 : 0;
		}
		$inst[$data["categorie"] ."_id"] = 1;
		
		$data["weergave_instellingen"][$data["categorie"]] = $inst;
		if(file_put_contents(BESTAND_WEERGAVE_INSTELLINGEN, json_encode($data["weergave_instellingen"]))) {
			$data["bericht"]["type"] = "gelukt";
			$data["bericht"]["text"] = "Weergave instellingen succesvol bijgewerkt!";
		} else {
			$data["bericht"]["type"] = "fout";
			$data["bericht"]["text"] = "Er is iets fout gegaan bij het opslaan van de instellingen. Raadpleeg de systeembeheerder.";
		}
	}
	
	$data["weergave_instellingen"] = $data["weergave_instellingen"][$data["categorie"]];
	$smarty->assign("data", $data);
	$smarty->display("beheren.tpl");
?>