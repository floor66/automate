<?php
	require_once("inc/config.php");
	
	if(empty($_SESSION["gebruiker"])) {
		if($_POST) {
			$gebruiker = db_get(array("wachtwoord", "klant_id"), "gebruiker", array("gebruikersnaam" => $_POST["gebruikersnaam"]));
			
			if($gebruiker["wachtwoord"] == sha1(sha1($_POST["wachtwoord"]))) {
				$_SESSION["gebruiker"] = clean($_POST["gebruikersnaam"]);
				$_SESSION["klant_id"] = $gebruiker["klant_id"];
				
				header("Location: /automate/");
			} else {
				$smarty->assign("fout", "Verkeerde gebruikersnaam/wachtwoord!");
			}
		}
		
		$smarty->display("login.tpl");
	} else {
		if(isset($_SESSION["klant_id"])) {
			$voornaam = db_get(array("voornaam"), "klant", array("klant_id" => $_SESSION["klant_id"]), 1);
			$smarty->assign("naam", $voornaam);
		} else {
			$smarty->assign("naam", $_SESSION["gebruiker"]);
		}
		
		$smarty->assign("vandaag", strftime("%d %B %Y"));
		$smarty->display("dashboard.tpl");
	}
?>