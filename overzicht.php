<?php
	require_once("inc/config.php");
	
	$allowed = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek");
	
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $allowed)) {
		header("Location: /automate/");
	}
	
	$smarty->assign("categorie", ucfirst($_GET["cat"]));
	$row = db_get(array("*"), $_GET["cat"], array(), 15);
	$smarty->assign("data_arr", $row);
	$smarty->display("overzicht.tpl");
?>