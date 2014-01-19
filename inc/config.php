<?php
	/* Smarty configuratie */
	require_once("Smarty/libs/Smarty.class.php");
	$smarty = new Smarty();
	
	$smarty->setCompileDir("inc/Smarty/templates_c/");
	$smarty->setConfigDir("inc/Smarty/configs/");
	$smarty->setCacheDir("inc/Smarty/cache/");
	
	/* PDO Configuratie */
	try {
		$pdo = new PDO("mysql:host=localhost;dbname=auto_mate", "root", "");
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
	
	/* function db_get($_cols, $_table, $_conditions, $_limit) 
	 * Simpele functie om dyamische prepared SELECT statements te maken
	 * Parameters:
	 * $_cols			Welke kolommen op te vragen
	 * $_table			Uit welke tabel deze te halen
	 * $_conditions		Onder welke voorwaarden (WHERE)
	 * $_limit			Met welke limit (LIMIT)
	 */
	function db_get($_cols, $_table, $_conditions, $_limit) {
		global $pdo;
		
		if(empty($_cols) || empty($_table)) {
			return NULL;
		}
		
		if($_cols[0] != "*") {
			$cols = implode(", ", tick($_cols));
		}
		$table = tick($_table);
		$query = "SELECT ". $cols ." FROM ". $table;
		
		if(isset($_conditions)) {
			$tmp_arr = array();
			
			foreach($_conditions as $key => $var) {
				$tmp_arr[] = tick($key) ." = :". $key;
			}
			
			$conditions = implode(", ", $tmp_arr);
			$query .= " WHERE ". $conditions;
		}
		
		if($_limit > 0) {
			$query .= " LIMIT ". $_limit;
		}
		
		try {
			$stmt = $pdo->prepare($query);
			$stmt->execute($_conditions);
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($row) > 0) {
				if(count($row) == 1) {
					if(count($row[0]) == 1) {
						if($_cols[0] != "*") {
							return $row[0][$_cols[0]];
						}
					}
					
					return $row[0];
				}
				return $row;
			}
		} catch(PDOException $e) {
			echo "Error: ". $e->getMessage();
		}
		
		return NULL;
	}
	
	/* Overige configuratie */
	setlocale(LC_ALL, "nld_nld");
	define("GEBRUIKER_NORMAAL", 0);
	define("GEBRUIKER_BEHEERDER", 1);
	session_start();
?>