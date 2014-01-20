<?php
	require_once("inc/config.php");
	
	$allowed = array("werkorder", "klant", "auto", "factuur", "inventaris", "leverancier", "gebruiker", "logboek");
	
	if(empty($_SESSION["gebruiker"]) || empty($_GET["cat"]) || !in_array($_GET["cat"], $allowed)) {
		header("Location: /automate/");
	}
	
	$smarty->assign("categorie", ucfirst($_GET["cat"]));
	
	$_GET["lim"] = (isset($_GET["lim"]) && is_numeric($_GET["lim"])) ? (int)$_GET["lim"] : 15;
	
	$weergave_inst = json_decode(file_get_contents(BESTAND_WEERGAVE_INSTELLINGEN), true)[$_GET["cat"]];
	$kolommen = array();
	
	foreach($weergave_inst as $k => $v) {
		if($v == 1) {
			$kolommen[] = $k;
		}
	}
	
	$_GET["sort"] = isset($_GET["sort"]) ? (in_array($_GET["sort"], $kolommen) ? $_GET["sort"] : $kolommen[0]) : $kolommen[0];
	$_GET["dir"] = isset($_GET["dir"]) ? ($_GET["dir"] == "ASC" ? "ASC" : "DESC") : "ASC";

	$data = db_get($kolommen, $_GET["cat"], array(), $_GET["lim"], array($_GET["sort"], $_GET["dir"]));
	
	if(count($data) > 0) {
		$presenteerbare_titels = array();
		
		foreach($kolommen as $kolom) {
			$presenteerbare_titels[] = ucfirst(str_replace("_", " ", $kolom));
		}
		
		$smarty->assign("sorteer_richting", $_GET["dir"] == "ASC" ? "Oplopend" : "Aflopend");
		$smarty->assign("sorteer_titel", ucfirst(str_replace("_", " ", $_GET["sort"])));
		$smarty->assign("kolom_titels", $kolommen);
		$smarty->assign("presenteerbare_titels", $presenteerbare_titels);
		$smarty->assign("resultaten", $data);
	}
	
	$smarty->display("overzicht.tpl");
?>