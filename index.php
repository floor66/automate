<?php
	require_once("inc/config.php");
	
	if(empty($_SESSION["gebruiker"])) {
		if($_POST) {
			$stmt = $db->prepare("SELECT `wachtwoord`, `klant_id` FROM `gebruiker` WHERE `gebruikersnaam` = ?");
			$stmt->bind_param("s", $_POST["gebruikersnaam"]);
			
			if($stmt->execute()) {
				$stmt->bind_result($wachtwoord, $klant_id);
				$stmt->fetch();
				
				if($wachtwoord == sha1(sha1($_POST["wachtwoord"]))) {
					$_SESSION["gebruiker"] = $_POST["gebruikersnaam"];
					$_SESSION["klant_id"] = $klant_id;
					header("Location: /automate/");
				} else {
					$smarty->assign("fout", "Verkeerde gebruikersnaam/wachtwoord!");
				}
			}
		}
		
		$smarty->assign("nav", false);
		$smarty->display("login.tpl");
	} else {
		if(isset($_SESSION["klant_id"])) {
			$voornaam = db_get(array("voornaam"), "klant", array("klant_id" => $_SESSION["klant_id"]), 1);
			$smarty->assign("naam", $voornaam);
		} else {
			$smarty->assign("naam", $_SESSION["gebruiker"]);
		}
		
		$smarty->assign("nav", true);
		$smarty->assign("vandaag", strftime("%d %B %Y"));
		
		$smarty->display("dashboard.tpl");
	}
?>