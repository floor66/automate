<?php
	require_once("inc/config.php");
	
	if(empty($_SESSION["gebruiker"])) {
		if($_POST) {
			$stmt = $db->prepare("SELECT `wachtwoord` FROM `gebruiker` WHERE `gebruikersnaam` = ?");
			$stmt->bind_param("s", $_POST["gebruikersnaam"]);
			
			if($stmt->execute()) {
				$stmt->bind_result($wachtwoord);
				$stmt->fetch();
				
				if($wachtwoord == sha1(sha1($_POST["wachtwoord"]))) {
					$_SESSION["gebruiker"] = $_POST["gebruikersnaam"];
					header("Location: index.php");
				} else {
					$smarty->assign("fout", "Verkeerde gebruikersnaam/wachtwoord!");
				}
			}
		}
		
		$smarty->assign("nav", false);
		$smarty->display("login.tpl");
	} else {
		$smarty->assign("nav", true);
		$smarty->display("dashboard.tpl");
	}
?>