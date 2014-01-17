<?php
	require_once("inc/config.php");
	
	/*if(empty($_SESSION["user"])) {
		$smarty->assign("nav", false);
		$smarty->display("login.tpl");
	} else {
		$smarty->assign("nav", true);
		$smarty->display("overzicht.tpl");
	}*/
		$smarty->assign("nav", true);
		$smarty->display("overzicht.tpl");
?>