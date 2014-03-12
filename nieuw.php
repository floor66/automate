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
		//NIET LOSER-PROOF
		unset($_POST["nieuw"]);
		$kolommen = implode(", ", array_keys($_POST));
		$kolommen_ex = ":". implode(", :", array_keys($_POST));

		try {
			$stmt = $pdo->prepare("INSERT INTO `". $data["categorie"] ."` (". $kolommen .") VALUES (". $kolommen_ex .")");
			$stmt->execute($_POST);
			
			$data["gelukt"] = "Gelukt!";
		} catch(PDOException $e) {
			$data["fout"] = $e->getMessage();
		}
	}
	
	//Laat het overzicht zien
	$smarty->assign("data", $data);
	$smarty->display("nieuw.tpl");
?>