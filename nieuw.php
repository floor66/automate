<?php
	require_once("inc/config.php");

	//Om aan het einde terug te geven aan Smarty
	$data = array();

	//Check of de gebruiker ingelogd is / een geldige categorie is ingevuld
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $cat_toegestaan)) {
		header("Location: /automate/");
	}
	
	$data["categorie"] = $_GET["cat"];
	
	if(isset($_POST["nieuw"])) {
		//handle saving to db
	}
	
	//Laat het overzicht zien
	$smarty->assign("data", $data);
	$smarty->display("nieuw.tpl");
?>