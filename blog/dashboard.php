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
	if( isset($_POST["addCategory"])) {

		if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular für eine neue Kategorie wurde abgesendet. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$category = cleanString($_POST["cat_name"]);
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$category: $category <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$errorCategory = checkInputString($category);
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorCategory: $errorCategory <i>(" . basename(__FILE__) . ")</i></p>\r\n";

	} // ENDE Prüfe, dass das Formular für eine neue Kategorie abgesendet wurde


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
				<select name="cat_id">
					<option>Alle Optionen aus der DB auslesen</option>
				</select>
				<input type="text" name="blog_headline" placeholder="Überschrift">

				<p>Bild hochladen</p>
				<div>
					<div class="fleft">
						<input type="file" name="blog_imagePath">
					</div>
					<div class="fright">
						<select name="blog_imageAlignment">
							<option value="left">Links ausrichten</option>
							<option value="right">Rechts ausrichten</option>
						</select>
					</div>
				</div>

				<textarea name="blog_content"></textarea>

				<input type="submit" value="Veröffentlichen">
			</form>

		</div>
		<div class="fright">
			<h3>Neue Kategorie anlegen</h3>

			<form method="post" action="">
				<input type="hidden" name="addCategory">
				<input type="text" name="cat_name" placeholder="Name der Kategorie">
				<input type="submit" value="Neue Kategorie anlegen">
			</form>

		</div>
		<div class="clearer"></div>

	</body>
</html>