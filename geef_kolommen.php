<?php
	require_once("inc/config.php");
	
	//Toegestane $_GET["cat"] opties
	$cat_toegestaan = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek", "contract", "product");
	
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $cat_toegestaan)) {
		header("Location: /automate/");
	}

	$res = array();

	$rij = db_get(array(
		"kolommen" => "*",
		"tabel" => $_GET["cat"],
		"limiet" => 1
	))[0];

	foreach($rij as $kolom => $waarde) {
		$res[] = $kolom;
	}
	
	echo json_encode($res);
?>