<?php
	require_once("inc/config.php");
	
	$allowed = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek");
	
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $allowed)) {
		header("Location: /automate/");
	}
	
	$smarty->assign("categorie", ucfirst($_GET["cat"]));
	$weergave = json_decode(file_get_contents("inc/weergave.json"), true);
	
	$smarty->assign("weergave_instellingen", $weergave[$_GET["cat"]]);
	$smarty->display("beheren.tpl");
?>