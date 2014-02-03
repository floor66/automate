<?php
	/* Smarty configuratie */
	require_once("Smarty/libs/Smarty.class.php");
	$smarty = new Smarty();
	
	$smarty->setCompileDir("inc/Smarty/templates_c/");
	$smarty->setConfigDir("inc/Smarty/configs/");
	$smarty->setCacheDir("inc/Smarty/cache/");
	
	/* PDO Configuratie */
	define("DATABASE_NAAM", "auto_mate");
	try {
		$pdo = new PDO("mysql:host=localhost;dbname=". DATABASE_NAAM, "root", "");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "Error: ". $e->getMessage();
	}
	
	/* Overige configuratie */
	
	/* function clean($str)
	 * Maakt input string schoon
	 */
	 
	/* function tick($v) 
	 * Omringt variabelen met accent graves (`)
	 */
	function tick($v) {
		if(gettype($v) == "array") {
			$ret = array();
			
			foreach($v as $q) {
				$ret[] = "`". $q ."`";
			}
			
			return $ret;
		} else {
			return "`". $v ."`";
		}
	}
		
	/* function clean($str) 
	 * Maak input schoon
	 */
	function clean($str) {
		return htmlentities(strip_tags($str));
	}
	
	/* function geef_kolommen($categorie) 
	 * Geef de kolomnamen van de gegeven tabel
	 */
	function geef_kolommen($categorie) {
		global $pdo;
		
		$tmp = array();
		
		$stmt = $pdo->prepare("SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA` = 'auto_mate' AND `TABLE_NAME` = ?");
		$stmt->execute(array($categorie));
		
		$rij = $stmt->fetchAll();
		
		foreach($rij as $kolom) {
			$tmp[] = $kolom["COLUMN_NAME"];
		}
	
		return $tmp;
	}
	
	setlocale(LC_ALL, "nld_nld");
	define("GEBRUIKER_NORMAAL", 0);
	define("GEBRUIKER_BEHEERDER", 1);
	define("INSTELLINGEN_BESTAND", "inc/instellingen.json");
	define("STATIC_FOLDER", "/automate/static");
	$cat_toegestaan = array(
		"werkorder",
		"klant",
		"auto",
		"factuur",
		"inventaris",
		"leverancier",
		"gebruiker",
		"logboek",
		"contract",
		"product"
	);
	$acties_toegestaan = array(
		"overzicht",
		"zoeken"
	);
	session_start();
?>