<?php
	require_once("inc/config.php");
	
	//Check of geen gebruiker ingelogd is
	if(empty($_SESSION["gebruiker"])) {
		//Check of het inlogforumulier verstuurd is
		if($_POST) {
			$stmt = $pdo->prepare("SELECT `wachtwoord`, `klant_id` FROM `gebruiker` WHERE `gebruikersnaam` = ? LIMIT 1");
			$stmt->execute(array($_POST["gebruikersnaam"]));
			$gebruiker = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

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
			$stmt = $pdo->prepare("SELECT `voornaam` FROM `klant` WHERE `klant_id` = ? LIMIT 1");
			$stmt->execute(array($_SESSION["klant_id"]));
			$klant = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

			$smarty->assign("voornaam", $klant["voornaam"]);
		} else {
			$smarty->assign("voornaam", $_SESSION["gebruiker"]);
		}
		
		//Laat het dashboard zien
		$smarty->display("dashboard.tpl");
	}
?>