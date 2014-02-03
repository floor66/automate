<?php
	require_once("inc/config.php");
	
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $cat_toegestaan)) {
		header("Location: /automate/");
	}

	echo json_encode(geef_kolommen($_GET["cat"]));
?>