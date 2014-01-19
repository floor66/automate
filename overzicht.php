<?php
	require_once("inc/config.php");
	
	$allowed = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek");
	
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $allowed)) {
		header("Location: /automate/");
	}
	
	$smarty->assign("categorie", ucfirst($_GET["cat"]));
	
	$weergave = json_decode(file_get_contents(BESTAND_WEERGAVE_INSTELLINGEN), true)[$_GET["cat"]];
	$kolommen = array();
	
	foreach($weergave as $k => $v) {
		if($v == 1) {
			$kolommen[] = $k;
		}
	}
	
	$row = db_get($kolommen, $_GET["cat"], array(), 15);
	
	$treated_rows = array();
	if(count($row) > 0) {
		$i = 0;
		foreach($row as $res) {
			foreach($res as $key => $val) {
				if($key == $_GET["cat"] ."_id") {
					$key = "#";
				}
				if(strstr($key, "datum")) {
					$val = strftime("%d %B %Y", $val);
				}
				$nkey = ucfirst(str_replace("_", " ", $key));
				
				$treated_rows[$i][$nkey] = $val;
			}
			$i++;
		}
		
		$smarty->assign("data_arr", $treated_rows);
	}
	$smarty->display("overzicht.tpl");
?>