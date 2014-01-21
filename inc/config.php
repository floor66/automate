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
	
	/* function db_get($settings) 
	 * Simpele functie om dyamische prepared SELECT statements te maken
	 * Parameters ($settings assoc. array):
	 * "kolommen"		Welke kolommen op te vragen
	 * "tabel"			Uit welke tabel deze te halen
	 * "voorwaarden"	Onder welke voorwaarden (WHERE)
	 * "sorteer_op"		Sorteer (ORDER BY) op deze kolom
	 * "limiet"			Met welke limit (LIMIT)
	 */
	function db_get($settings) {
		global $pdo;
		
		if(empty($settings["kolommen"]) || empty($settings["tabel"])) {
			return NULL;
		}
		
		if(gettype($settings["kolommen"]) == "array") {
			$kolommen = implode(", ", tick($settings["kolommen"]));
		} else {
			$kolommen = "*";
		}
		$tabel = tick($settings["tabel"]);
		$query = "SELECT ". $kolommen ." FROM ". $tabel;
		
		if(isset($settings["voorwaarden"]) && count($settings["voorwaarden"]) > 0) {
			$voorwaarden = array();
			
			foreach($settings["voorwaarden"] as $kolom => $waarde) {
				$voorwaarden[] = tick($kolom) ." = :". $kolom;
			}
			
			$voorwaarden = implode(", ", $voorwaarden);
			$query .= " WHERE ". $voorwaarden;
		}
		
		if(isset($settings["sorteer_op"])) {
			$query .= " ORDER BY ". $settings["sorteer_op"]["kolom"] ." ". $settings["sorteer_op"]["richting"];
		}
		
		if(gettype($settings["limiet"]) == "array") {
			$query .= " LIMIT ". $settings["limiet"]["offset"] .", ". $settings["limiet"]["aantal"];
		} elseif($settings["limiet"] > 0) {
			$query .= " LIMIT ". $settings["limiet"];
		}
		
		try {
			$stmt = $pdo->prepare($query);
			
			if(isset($voorwaarden)) {
				$stmt->execute($settings["voorwaarden"]);
			} else {
				$stmt->execute();
			}
			
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return count($row) > 0 ? $row : NULL;
		} catch(PDOException $e) {
			echo "Error: ". $e->getMessage();
		}
		
		return NULL;
	}
	
	/* Overige configuratie */
	
	/* function clean($str)
	 * Maakt input string schoon
	 */
	function clean($str) {
		return htmlentities(strip_tags($str));
	}
	
	setlocale(LC_ALL, "nld_nld");
	define("GEBRUIKER_NORMAAL", 0);
	define("GEBRUIKER_BEHEERDER", 1);
	define("BESTAND_WEERGAVE_INSTELLINGEN", "inc/weergave.json");
	session_start();
?>