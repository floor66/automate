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
					header("Location: index.php");
				} else {
					$smarty->assign("fout", "Verkeerde gebruikersnaam/wachtwoord!");
				}
			}
		}
		
		$smarty->assign("nav", false);
		$smarty->display("login.tpl");
	} else {
		if(isset($_SESSION["klant_id"])) {
			$stmt = $db->prepare("SELECT `voornaam` FROM `klant` WHERE `klant_id` = ?");
			$stmt->bind_param("i", $_SESSION["klant_id"]);
			
			if($stmt->execute()) {
				$stmt->bind_result($voornaam);
				$stmt->fetch();
				
				$smarty->assign("naam", $voornaam);
			}
		} else {
			$smarty->assign("naam", $_SESSION["gebruiker"]);
		}
		
		$smarty->assign("nav", true);
		$smarty->assign("vandaag", date("d F Y"));
		
		$smarty->display("dashboard.tpl");
	}
?>