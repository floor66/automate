<?php
	require_once("inc/config.php");
	
	$allowed = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek");
	
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $allowed)) {
		header("Location: /automate/");
	}
	
	if(isset($_POST["opslaan"])) {
		$weergave = json_decode(file_get_contents(BESTAND_WEERGAVE_INSTELLINGEN), true);
		$curr = $weergave[$_GET["cat"]];
		
		foreach($curr as $kolom => $status) {
			$inst[$kolom] = isset($_POST[$kolom]) ? 1 : 0;
		}
		$inst[$_GET["cat"] ."_id"] = 1;
		
		$weergave[$_GET["cat"]] = $inst;
		if(file_put_contents(BESTAND_WEERGAVE_INSTELLINGEN, json_encode($weergave))) {
			$smarty->assign("bericht", array("type" => "gelukt", "text" => "Weergave instellingen succesvol bijgewerkt!"));
		} else {
			$smarty->assign("bericht", array("type" => "fout", "text" => "Er is iets fout gegaan bij het opslaan van de instellingen. Raadpleeg de systeembeheerder."));
		}
	}
	
	$smarty->assign("categorie", ucfirst($_GET["cat"]));
	$weergave = json_decode(file_get_contents(BESTAND_WEERGAVE_INSTELLINGEN), true);
	
	$smarty->assign("weergave_instellingen", $weergave[$_GET["cat"]]);
	$smarty->display("beheren.tpl");
?>