<?php

	require_once("include/config.inc.php");
	require_once("include/form.inc.php");
	require_once("include/db.inc.php");

	$errorLogin = NULL;
	$accountname = NULL;
	$password = NULL;
	$errorAccountname = NULL;
	$errorPassword = NULL;

	if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
	if(DEBUG)	print_r($_POST);
	if(DEBUG)	echo "</pre>";



	//Formularverarbeitung

	// Schritt 1 Form: Prüfen, ob Formular abgeschickt wurde

	if ( isset( $_POST["formsentLogin"] )) {
		if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Formular 'formsentLogin' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Schritt 2 Form: Werte auslesen, entschärfen

		$accountname = $_POST["accountname"];
		$password = $_POST["password"];

		$errorAccountname = cleanString($accountname);
		$errorPassword = cleanString($password);

		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$accountname: $accountname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$password: $password <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$errorAccountname = checkInputString($accountname, 4, 20);
		$errorPassword = checkInputString($password, 4);


		//Schritt 3 Form: Werte validieren

		if ($errorAccountname OR $errorPassword) {

			//Fehler

			if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Eine der beiden Felder wurde nicht ausgefüllt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			$errorLogin = "Logindaten sind ungültig.";

		} else {

			//Erfolg

			if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Beide Felder OK. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Daten weiterverarbeiten

			// Schritt 1 DB: Datenbankverbindung herstellen

			$pdo = dbConnect();

			// Datensatz zum Accountnamen auslesen

			// Schritt 2 DB: SQL-Statement vorbereiten

			$statement = $pdo->prepare("	SELECT acc_name, acc_password, sta_id, acc_id 
													FROM accounts 
													WHERE acc_name = :ph_acc_name");

			// Schritt 3 DB: SQL-Statement ausführen

			$statement->execute( array(
				"ph_acc_name" => $accountname
			) );

			if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Schritt 4 DB: Daten weiterverarbeiten
			// Bei lesendem Zugriff Datensätze abholen

			$row = $statement->fetch(PDO::FETCH_ASSOC);

//			if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//			if(DEBUG)	print_r($row);
//			if(DEBUG)	echo "</pre>";

			//echo gettype($row);

			//Wenn $row nicht leer ist wurde ein Account mit dem Accountnamen gefunden
			if(!$row) {
				//Fehler

				if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Accountname: $accountname existiert NICHT in der Datenbank. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				$errorLogin = "Logindaten sind ungültig.";

			} else {
				//Erfolg

				if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Accountname: $accountname existiert in der Datenbank. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				// Passwort prüfen

				if( !password_verify($password, $row["acc_password"])) {
					// Fehler
					if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Die Passwörter stimmen NICHT überein. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					$errorLogin = "Logindaten sind ungültig.";

				} else {
					// Erfolg

					if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Die Passwörter stimmen überein. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					// Accountstatus prüfen

					$sta_id = $row["sta_id"];
					if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$sta_id: $sta_id <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					// sta_id = 1 (open);
					// sta_id = 2 (closed);


					if ( $sta_id == 2 ) {

						// Account closed
						if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Der Accountstatus ist closed. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						$errorLogin = "Ihr Account ist gesperrt. Bitte überprüfen Sie Ihre Emails für weitere Informationen.";

					} elseif ( $sta_id == 1) {

						// Account open
						if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Der Accountstatus ist open. <i>(" . basename(__FILE__) . ")</i></p>\r\n";


						// Login verarbeiten
						if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Login wird durchgeführt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

						//Session starten

						session_name("benutzerverwaltung");
						session_start();

						$_SESSION["acc_id"] = $row["acc_id"];

						header("Location: profile.php");

//						if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//						if(DEBUG)	print_r($_SESSION);
//						if(DEBUG)	echo "</pre>";



					}

				}

			}

		}

	}



?>




<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Benutzerverwaltung - Startseite</title>

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/debug.css">
</head>

<body>

<!-- -------- PAGE HEADER -------- -->
<br>
<header class="fright loginheader">

	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
		<input type="hidden" name="formsentLogin">
		<fieldset>
			<legend>Login</legend>
			<span class='error'><?= $errorLogin ?></span><br>
			<input class="short" type="text" name="accountname" placeholder="Accountname">
			<input class="short" type="password" name="password" placeholder="Passwort">
			<input class="short" type="submit" value="Anmelden">
		</fieldset>
	</form>

	<p class="fright"><a href="registration.php">Sie haben noch keinen Account? Registrieren Sie sich einfach.</a></p>

</header>
<div class="clearer"></div>

<hr>
<!-- -------- PAGE HEADER END -------- -->
<h1>Benutzerverwaltung - Startseite</h1>

<p>
	Hallo Besucher, bitte loggen Sie sich über obiges Formular ein, um die Inhalte für registrierte
	Benutzer sehen zu können.<br>
	<br>
	Auf der Folgeseite können Sie dann Ihre persönlichen Daten sowie Ihre
	Accountdaten verwalten, ein Avatarbild hochladen oder Ihr Passwort ändern.
</p>

<p>
	Sollten Sie sich noch nicht auf unserer Seite registriert haben, können Sie das über den
	Link unter dem Anmeldeformular nachholen. Oder klicken Sie einfach <a href="registration.php">hier</a>.
</p>

</body>
</html>