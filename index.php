<?php
	require_once("inc/config.php");
	
	//Check of geen gebruiker ingelogd is
	if(empty($_SESSION["gebruiker"])) {
		//Check of het inlogforumulier verstuurd is
		if($_POST) {
			$gebruiker = db_get(array(
				"kolommen" => array(
					"wachtwoord", "klant_id"
				),
				"tabel" => "gebruiker",
				"voorwaarden" => array(
					"gebruikersnaam" => $_POST["gebruikersnaam"]
				),
				"limiet" => 1
			))[0];
			
			//Check het ingevoerde wachtwoord tegen het wachtwoord in de database
			if($gebruiker["wachtwoord"] == sha1(sha1($_POST["wachtwoord"]))) {
				$_SESSION["gebruiker"] = clean($_POST["gebruikersnaam"]);
				$_SESSION["klant_id"] = $gebruiker["klant_id"];
				
				//Gebruiker is ingelogd, stuur door naar het dashboard
				header("Location: /automate/");
			} else {
				$smarty->assign("fout", "Verkeerde gebruikersnaam/wachtwoord!");
			}
		}
		
		//Laat de inlogpagina zien
		$smarty->display("login.tpl");
	} else {
		//Haal enkele gegevens over de ingelogde gebruiker uit de database, indien toepasselijk
		if(isset($_SESSION["klant_id"])) {
			$gebruiker_klant = db_get(array(
				"kolommen" => array(
					"voornaam"
				),
				"tabel" => "klant",
				"voorwaarden" => array(
					"klant_id" => $_SESSION["klant_id"]
				),
				"limiet" => 1
			))[0];
			
			$smarty->assign("voornaam", $gebruiker_klant["voornaam"]);
		} else {
			$smarty->assign("voornaam", $_SESSION["gebruiker"]);
		}
		
		//Laat het dashboard zien
		$smarty->display("dashboard.tpl");
	}
?>