<?php



	/**
	 *	Stellt eine Verbindung zu einer Datenbank mittels PDO her
	 *	@param [String $dbname		Name der zu verbindenden Datenbank]
	 *	@return Object					DB-Verbindungsobjekt
	 */
	function dbConnect($dbname=DB_NAME) {
		if(DEBUG_DB)	echo "<p class='debugDb'><b>Line " . __LINE__ . ":</b> Versuche mit der DB <b>$dbname</b> zu verbinden... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// EXCEPTION-HANDLING (Umgang mit Fehlern)
		// Versuche, eine DB-Verbindung aufzubauen
		try {
			// wirft, falls fehlgeschlagen, eine Fehlermeldung "in den leeren Raum"

			// $pdo = new PDO("mysql:host=localhost; dbname=market; charset=utf8mb4", "root", "");
			$pdo = new PDO(DB_SYSTEM . ":host=" . DB_HOST . "; dbname=$dbname; charset=utf8mb4", DB_USER, DB_PWD);

			// falls eine Fehlermeldung geworfen wurde, wird sie hier aufgefangen
		} catch(PDOException $error) {
			// Ausgabe der Fehlermeldung
			if(DEBUG_DB)		echo "<p class='error'><b>Line " . __LINE__ . ":</b> <i>FEHLER: " . $error->GetMessage() . " </i> <i>(" . basename(__FILE__) . ")</i></p>\r\n";
			// Skript abbrechen
			exit;
		}
		// Falls das Skript nicht abgebrochen wurde (kein Fehler), geht es hier weiter
		if(DEBUG_DB)	echo "<p class='debugDb ok'><b>Line " . __LINE__ . ":</b> Erfolgreich mit der DB <b>$dbname</b> verbunden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// DB-Verbindungsobjekt zurückgeben
		return $pdo;
	}



	/**
	 * Liest alle Daten aus der gewünschten Tabelle und gibt bei Erfolg den Array mit den Daten zurück.
	 * Sonst einen String mit einer Fehlermeldung
	 *
	 * @return array|string Success is Array | Error is String
	 */
	function readTableFromDb($table) {

		$pdo = dbConnect();

		$statement = $pdo->prepare("SELECT * FROM $table");
		$statement->execute();
		if(DEBUG_F) if($statement->errorInfo()[2]) echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

		// Überprüfe dass Array aus der Datenbank
		if ( !isset($categories[0]["cat_name"])) {
			// Fehler
			if (DEBUG_F) echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: Die Kategorien konnten nicht von der Datenbank geladen werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
			$categories = "Fehler beim lesen der Kategorien.";

		} else {
			// Erfolg
			if (DEBUG_F) echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: Die Kategorien wurden erfolgreich von der Datenbank geladen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		} // ENDE Überprüfe dass Array aus der Datenbank

		return $categories;
	}



	/**
	 * Liest alle Artikel sortiert nach Datum beginnend mit dem neuesten Artikel aus der
	 * Datenbank. Die Artikel können nach Kategorien gefiltert werden.
	 *
	 * @param null $categorie
	 * @return array|string Success is Array | Error is String
	 */
	function getBlogPost($categorie=NULL) {

		$posts = NULL;
		$pdo = dbConnect();


		if (!$categorie) {

			$statement = $pdo->prepare("
				SELECT * FROM `blogs`
				LEFT JOIN categories USING (cat_id)
				INNER JOIN users USING (usr_id)
				ORDER BY blog_date DESC
			");

			$statement->execute();

		} else {

			$statement = $pdo->prepare("
				SELECT * FROM `blogs`
				LEFT JOIN categories USING (cat_id)
				INNER JOIN users USING (usr_id)
				WHERE cat_id = :ph_catId
				ORDER BY blog_date DESC
			");

			$statement->execute(array("ph_catId"=>$categorie));

		}

		if (DEBUG_F) if ($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

		// Überprüfe dass Array aus der Datenbank
		if (!isset($posts[0]["cat_id"])) {
			// Fehler
			if (DEBUG_F) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Die Artikel konnten nicht von der Datenbank geladen werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
			$posts = "Fehler beim lesen der Artikel.";

		} else {
			// Erfolg
			if (DEBUG_F) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Die Artikel wurden erfolgreich von der Datenbank geladen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		} // ENDE Überprüfe dass Array aus der Datenbank

		return $posts;
	}

?>