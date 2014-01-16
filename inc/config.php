<?php
	/* Smarty configuratie */
	require_once("Smarty/libs/Smarty.class.php");
	$smarty = new Smarty();
	
	$smarty->setCompileDir("inc/Smarty/templates_c/");
	$smarty->setConfigDir("inc/Smarty/configs/");
	$smarty->setCacheDir("inc/Smarty/cache/");
	
	/* MySQLi Configuratie */
	$db = new mysqli("localhost", "root", "", "automate");
	if($db->connect_errno > 0) {
		die("Couldn't connect to the database: [". $db->connect_error() ."]");
	}
	
	/* Overige configuratie */
	session_start();
?>