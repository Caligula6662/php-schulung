<?php


	#**************************************#
	#********** CONTINUE SESSION **********#
	#**************************************#

	// Session fortführen
	session_name("blog");
	session_start();

	// Secure Page

	if (!isset($_SESSION["usr_id"])) {
		session_destroy();
		header("Location: index.php");
		exit;
	}



	#************************************************#
	#************* Includes und Imports *************#
	#************************************************#

	require_once("include/config.inc.php");
	require_once("include/form.inc.php");
	require_once("include/db.inc.php");



	#***********************************************************#
	#************* Variablen und Initialisierungen *************#
	#***********************************************************#

	$pdo = dbConnect();

	$usrMsgCategory = NULL;
	$categories = NULL;



	#****************************#
	#********** Logout **********#
	#****************************#

	// Prüfe, dass der Parameter Action in der URL vorhanden ist
	if (isset($_GET['action'])) {

		if (DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: URL-Parameter 'action' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$action = cleanString($_GET['action']);
		// Prüfe, dass der Parameter den Wert Logout enthält und führe dann Logout aus.
		if ($action == "logout") {
			if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Logout wird durchgeführt... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			session_destroy();
			header("Location: index.php");
			exit;

		} // ENDE Prüfe, dass der Parameter den Wert Logout enthält und führe dann Logout aus.

	} // ENDE Prüfe, dass der Parameter Action in der URL vorhanden ist



	#***************************************#
	#********** Kategorie anlegen **********#
	#***************************************#

	// Prüfe, dass das Formular für eine neue Kategorie abgesendet wurde
	if (isset($_POST["addCategory"])) {

		if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular für eine neue Kategorie wurde abgesendet. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$category = cleanString($_POST["cat_name"]);
		if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$category: $category <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$usrMsgCategory = checkInputString($category);
		//$usrMsgCategory = "<span class='error'>" . $usrMsgCategory . "</span>";

		if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorCategory: $usrMsgCategory <i>(" . basename(__FILE__) . ")</i></p>\r\n";


		// Finale Prüfung des Eingabefeldes Kategorie
		if ( $usrMsgCategory ) {
			// Fehler
			if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Der Input für die Kategorie entspricht nicht den Vorgaben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		} else {
			// Erfolg
			if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Der Input für die Kategorie entspricht Vorgaben. Weiterverbeitung beginnt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			#************************************************#
			#********** Kategorie in DB überprüfen **********#
			#************************************************#

			$statement = $pdo->prepare("SELECT COUNT(cat_name) FROM categories WHERE cat_name = :ph_cat_name");
			$statement->execute(array("ph_cat_name"=> $category));
			if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			$existCategory = $statement->fetchColumn();

			if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$existCategory: $existCategory <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Finale Prüfung der Existenz der Kategorie
			if ( $existCategory ) {
				// Fehler
				if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Die Kategorie ist bereits vorhanden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				$usrMsgCategory = "<span class='error'>Die Kategorie ist bereits vorhanden.</span>";

			} else {
				// Erfolg

				if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Kategorie kann in der Datenbank angelegt werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				#*********************************************#
				#********** Kategorie in DB anlegen **********#
				#*********************************************#

				$statement = $pdo->prepare("INSERT INTO categories (cat_name) VALUES (:ph_cat_name)");
				$statement->execute(array("ph_cat_name"=>$category));

				if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				$rowCount = $statement->rowCount();
				if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>\$rowCount: $rowCount<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				// User über das Anlegen der Kategorie in der DB informieren
				if( !$rowCount ) {
					// Fehler

					if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>Fehler beim Speichern der Kategorie in die Datenbank<i>(" . basename(__FILE__) . ")</i></p>\r\n";
					$usrMsgCategory = "<span class='error'>Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.</span>";

				} else {
					// Erfolg

					if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Kategorie wurde erfolgreich in der Datenbank angelegt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					$usrMsgCategory = "<span class='success'>Die Kategorie <b>$category</b> wurde erfolgreich in der Datenbank angelegt.</span>";

				} // User über das Anlegen der Kategorie in der DB informieren

			} // ENDEFinale Prüfung der Existenz der Kategorie

		} // ENDE Finale Prüfung des Eingabefeldes Kategorie

	} // ENDE Prüfe, dass das Formular für eine neue Kategorie abgesendet wurde



	#****************************************************#
	#********** Vorhandene Kategorien ausgeben **********#
	#****************************************************#

	$statement = $pdo->prepare("SELECT * FROM categories");
	$statement->execute();
	if(DEBUG) if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

	$categoriesArray = $statement->fetchAll(PDO::FETCH_ASSOC);

	// Überprüfe dass Array aus der Datenbank
	if ( !isset($categoriesArray[0]["cat_name"])) {
		// Fehler

		if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Die Kategorien konnten nicht von der Datenbank geladen werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

	} else {
		// Erfolg

		if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Die Kategorien wurden erfolgreich von der Datenbank geladen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

	} // ENDE Überprüfe dass Array aus der Datenbank



	#********************************************************#
	#********** Blogbeitrag auslesen und speichern **********#
	#********************************************************#

	if ( isset($_POST["addBlog"]) ) {

		if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Der Post-Array <b>addBlog</b> wurde gefunden und die Verarbeitung kann beginnen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";




	}





?>


<!doctype html>

<html>



<head>
	<meta charset="utf-8">
	<title>Dashboard</title>

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/debug.css">
</head>



<body>

	<header class="fright loginheader">
		<p>Hallo <b><?= $_SESSION["usr_firstname"] ?> <?= $_SESSION["usr_lastname"] ?></b></p>
		<p><a href="?action=logout">Logout</a> || <a href="index.php">Startseite</a></p>
	</header>
	<div class="clearer"></div>

	<h1>Dashboard</h1>

	<div class="fleft">
		<h3>Neuen Blogeintrag verfassen</h3>

		<form method="post" action="">
			<input type="hidden" name="addBlog">
			<fieldset>
				<select name="cat_id">
					<?php foreach ($categoriesArray AS $categorieResults): ?>
						<option value="<?= $categorieResults["cat_id"] ?>"><?= $categorieResults["cat_name"] ?></option>
					<?php endforeach; ?>
				</select>
				<input type="text" name="blog_headline" placeholder="Überschrift">

				<p>Bild hochladen</p>
				<div>
					<div class="fleft">
						<input type="file" name="blog_imagePath">
					</div>
					<div class="fright">
						<select name="blog_imageAlignment">
							<option value="1">Links ausrichten</option>
							<option value="2">Rechts ausrichten</option>
						</select>
					</div>
				</div>

				<textarea name="blog_content"></textarea>

				<input type="submit" value="Veröffentlichen">
			</fieldset>
		</form>

	</div>
	<div class="fright">
		<h3>Neue Kategorie anlegen</h3>

		<form method="post" action="">
			<fieldset>
				<input type="hidden" name="addCategory">
				<?= $usrMsgCategory ?>
				<input type="text" name="cat_name" placeholder="Name der Kategorie">
				<input type="submit" value="Neue Kategorie anlegen">
			</fieldset>
		</form>

	</div>
	<div class="clearer"></div>

</body>



</html>