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
	}

	#************************************************#
	#************* Includes und Imports *************#
	#************************************************#

	require_once("include/config.inc.php");
	require_once("include/form.inc.php");
	require_once("include/db.inc.php");

	#*************************************#
	#************* Variablen *************#
	#*************************************#

	$errorLogin = NULL;

	#*********************************#
	#************* Login *************#
	#*********************************#

	// Post Array prüfen
	if (isset($_POST["login"])) {

		if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Postarray wurde gefunden und die Formularverarbeitung kann beginnen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

//		if (DEBUG) echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//		if (DEBUG) print_r($_POST);
//		if (DEBUG) echo "</pre>";

		// Eingabefelder lesen und entschärfen
		$email = cleanString($_POST["email"]);
		$password = cleanString($_POST["password"]);

		if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$email $email <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$password $password <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Eingabefelder validieren
		$errorEmail = checkEmail($email);
		$errorPassword = checkInputString($password, 4);

		if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorEmail $errorEmail <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorPassword $errorPassword <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Finale Validierung mit ggf. Rückmeldung an den User
		if ($errorLogin or $errorPassword) {
			// Fehler
			if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Eines der beiden Felder wurde nicht ausgefüllt oder die Email ist keine gültige Email. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			$errorLogin = "Benutzername oder Passwort falsch!";

		} else {
			// Erfolg
			if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Beide Felder enthalten gültige Werte und können weiter verarbeitet werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";


			#**************************************************#
			#************* Login Datenbankabfrage *************#
			#**************************************************#

			$pdo = dbConnect();

			$statement = $pdo->prepare("
				SELECT * FROM users WHERE usr_email = :ph_email
			");
			$statement->execute(array("ph_email" => $email));
			if (DEBUG) if ($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			$row = $statement->fetch(PDO::FETCH_ASSOC);

//			if (DEBUG) echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//			if (DEBUG) print_r($row);
//			if (DEBUG) echo "</pre>";

			// Daten aus der Datenbank weiterverarbeiten

			if (!$row) {
				// Fehler
				if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Email: $email existiert NICHT in der Datenbank. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				$errorLogin = "Benutzername oder Passwort falsch!";

			} else {
				// Erfolg
				if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Email ist in der Datenbank vorhanden und die Daten können weiter verarbeitet werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				#*************************************************#
				#************* Passwort und Session  *************#
				#*************************************************#

				// Passwort überprüfen
				if (!password_verify($password, $row["usr_password"])) {
					// Fehler
					if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Passwörter stimmen NICHT überein. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					$errorLogin = "Benutzername oder Passwort falsch!";

				} else {
					// Erfolg
					if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Passwörter stimmen überein und die Session kann gestartet werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					//Session starten

					session_name("blog");
					session_start();

					$isLoggedIn = true;

					$_SESSION["usr_id"] = $row["usr_id"];
					$_SESSION["usr_firstname"] = $row["usr_firstname"];
					$_SESSION["usr_lastname"] = $row["usr_lastname"];
					$_SESSION["usr_city"] = $row["usr_city"];

					// Weiterleitung auf das Dashboard
					header("Location: dashboard.php");

					if (DEBUG) echo "<pre class='debug'>Session - Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
					if (DEBUG) print_r($_SESSION);
					if (DEBUG) echo "</pre>";

				} // ENDE Passwort überprüfen

			} // ENDE Daten aus der Datenbank weiterverarbeiten

		} // ENDE Finale Validierung mit ggf. Rückmeldung an den User

	} // ENDE Post Array prüfen


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

			// Neuladen der Index.php, da action nicht mehr verfügbar ist
			header("Location: index.php");

		} // ENDE Prüfe, dass der Parameter den Wert Logout enthält und führe dann Logout aus.

	} // ENDE Prüfe, dass der Parameter Action in der URL vorhanden ist


?>


<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Willkommen auf meinem Blog</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/debug.css">
</head>

<body>

<header class="fright loginheader">

	<?php if (!isset($_SESSION["usr_id"])): ?>
		<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
			<input type="hidden" name="login">
			<fieldset>
				<legend>Login</legend>
				<span class='error'><?= $errorLogin ?></span><br>
				<input class="short" type="text" name="email" placeholder="Email">
				<input class="short" type="password" name="password" placeholder="Passwort">
				<input class="short" type="submit" value="Anmelden">
			</fieldset>
		</form>
	<?php else: ?>

		<p>Hallo <b><?= $_SESSION["usr_firstname"] ?> <?= $_SESSION["usr_lastname"] ?></b></p>
		<p><a href="?action=logout">Logout</a> || <a href="dashboard.php">Dashboard</a></p>

	<?php endif ?>

</header>
<div class="clearer"></div>

<h1>Willkommen!</h1>
</body>
</html>