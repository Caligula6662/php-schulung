<?php

	require_once ("include/config.inc.php");
	require_once ("include/form.inc.php");
	require_once ("include/db.inc.php");


	$firstname 		= NULL;
	$lastname 		= NULL;
	$email 			= NULL;
	$accountname 	= NULL;

	$errorFirstname 		= NULL;
	$errorLastname 			= NULL;
	$errorEmail 			= NULL;
	$errorAccountname 		= NULL;
	$errorPassword 			= NULL;
	$errorPasswordCheck		= NULL;

	$dbMessage = NULL;
	$showForm = true;

	//region Formularverarbeitung
	//Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde

	/*
	if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
	if(DEBUG)	print_r($_POST);
	if(DEBUG)	echo "</pre>";
	*/

	if( isset($_POST["formsentRegistration"]) ) {

		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Formular 'formsentRegistration' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		//Schritt 2 FORM: Werte auslesen

		$firstname 		= cleanString($_POST["firstname"]);
		$lastname 		= cleanString($_POST["lastname"]);
		$email 			= cleanString($_POST["email"]);
		$accountname 	= cleanString($_POST["accountname"]);
		$password 		= cleanString($_POST["password"]);
		$passwordCheck 	= cleanString($_POST["passwordCheck"]);

		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$firstname: $firstname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$lastname: $lastname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$email: $email <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$accountname: $accountname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$password: $password <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$passwordCheck: $passwordCheck <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		//Schritt 3 FORM: Werte Validieren

		$errorFirstname 		= checkInputString($firstname);
		$errorLastname 			= checkInputString($lastname);
		$errorEmail 			= checkEmail($email);
		$errorAccountname 		= checkInputString($accountname, 4, 20);
		$errorPassword 			= checkInputString($password,4);
		$errorPasswordCheck 	= checkInputString($passwordCheck,4);

		//Passwort validieren

		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Passwort wird validiert... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		if (!$errorPassword) {

			if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Passwort entspricht den Mindestanforderungen <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// WICHTIG: 'BUG' in PHP! Wenn $password 1234 lautet und $passwordCheck 01234
			// erkennt der != Operator beide Werte als gleich! Daher unbedingt MIT Typprüfung !==
			// vergleichen

			if( $password !== $passwordCheck ) {

				if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Passwörter stimmen nicht überein <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				$errorPassword = "Die Passwörter stimmen nicht überein";

			} else {

				if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Passwörter stimmen überein <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				$passwordHash = password_hash($password, PASSWORD_DEFAULT);

				if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>:\$passwordHash: $passwordHash <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			}

		}

		//Finale Formularvalidierung

		if( $errorFirstname OR $errorLastname OR $errorEmail OR $errorAccountname OR $errorPassword ) {

			if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Formular enthält noch Fehler. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		} else {

			if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist fehlerfrei und wird nun verarbeitet...<i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Schritt 4 FORM: Daten weiterverarbeiten

			// Schritt 1 DB: Datenbankverbindung öffnen

			$pdo = dbConnect();

			// Schritt 2 DB: SQL-Statement vorbereiten

			$statement = $pdo->prepare("SELECT COUNT(usr_email) FROM users WHERE usr_email = :ph_email");

			// Schritt 3 DB: SQL-Statement ausführen

			$statement->execute(
					array( "ph_email" => $email )
			);
			if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Schritt 4 DB: Daten weiterverarbeiten

			$anzahl = $statement->fetchColumn();
			if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>\$emailCount: $anzahl<i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Prüfe dass Email noch nicht existiert

			if( $anzahl ) {
				//Fehler

				if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>Email ist bereits vergeben<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				$errorEmail = "Die Email-Adresse ist bereits vergeben";

			} else {
				//Erfolg

				if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>Email ist noch nicht in der Datenbank.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				// Prüfe dass Accountname noch nicht existiert







				// Schritt 2 DB: SQL-Statement vorbereiten

				$statement = $pdo->prepare("SELECT COUNT(acc_name) FROM accounts WHERE acc_name = :ph_acc_name");

				// Schritt 3 DB: SQL-Statement ausführen

				$statement->execute(
					array( "ph_acc_name" => $accountname )
				);
				if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				// Schritt 4 DB: Daten weiterverarbeiten

				$anzahl = $statement->fetchColumn();
				if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>\$accountname: $anzahl<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				// Prüfe dass Email noch nicht existiert

				if( $anzahl ) {
					//Fehler

					if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>Accountname ist bereits vergeben<i>(" . basename(__FILE__) . ")</i></p>\r\n";

					$errorAccountname = "Die Accountname ist bereits vergeben";

				} else {
					//Erfolg

					if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>Accountname ist noch nicht in der Datenbank.<i>(" . basename(__FILE__) . ")</i></p>\r\n";







					// Daten in der Datenbank speichern
					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("INSERT INTO users (usr_firstname, usr_lastname, usr_email) VALUES (:ph_usr_firstname, :ph_usr_lastname, :ph_usr_email)");


					// Schritt 3 DB: SQL-Statement ausführen
					$statement->execute( array(
							"ph_usr_firstname" => $firstname,
							"ph_usr_lastname" => $lastname,
							"ph_usr_email" => $email
					));
					if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					//Schritt 4 DB: Daten weiterverarbeiten
					//Bei schreibendem Zugriff: Schreiberfolg prüfen
					$rowCount = $statement->rowCount();
					if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>\$rowCount: $rowCount<i>(" . basename(__FILE__) . ")</i></p>\r\n";


					if( !$rowCount ) {
						// Fehler

						if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>Fehler beim Speichern des Userdatensatzes in die Datenbank<i>(" . basename(__FILE__) . ")</i></p>\r\n";

						$dbMessage = "<h3 class='error'>Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.</h3>";

					} else {
						// Erfolg
						// User-ID auslesen

						$lastInsertId = $pdo->lastInsertId();

						if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>Erfolg beim Schreiben des Userdatensatzes in die Datenbank. Unter ID: $lastInsertId in DB gespeichert.<i>(" . basename(__FILE__) . ")</i></p>\r\n";



// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare("INSERT INTO accounts (acc_name, acc_password, usr_id) VALUES (:ph_acc_name, :ph_acc_password, :ph_usr_id)");


						// Schritt 3 DB: SQL-Statement ausführen
						$statement->execute( array(
							"ph_acc_name" => $accountname,
							"ph_acc_password" => $passwordHash,
							"ph_usr_id" => $lastInsertId
						));
						if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

						//Schritt 4 DB: Daten weiterverarbeiten
						//Bei schreibendem Zugriff: Schreiberfolg prüfen
						$rowCount = $statement->rowCount();
						if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>\$rowCount: $rowCount<i>(" . basename(__FILE__) . ")</i></p>\r\n";


						if( !$rowCount ) {
							// Fehler

							if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>Fehler beim Speichern des Accountdatensatzes in die Datenbank<i>(" . basename(__FILE__) . ")</i></p>\r\n";

							$dbMessage = "<h3 class='error'>Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.</h3>";

							// TODO: Verwaisten Userdatensatz wieder löschen

						} else {
							// Erfolg
							// Account-ID auslesen

							$lastInsertId = $pdo->lastInsertId();

							if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>Erfolg beim Schreiben des Accountdatensatzes in die Datenbank. Unter ID: $lastInsertId in DB gespeichert.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

							$dbMessage = "<h3 class='success'>Sie haben sich erfolgreich registriert und können sich nun einloggen.</h3>";

							$showForm = false;

							// Bestätigungsmail generieren
							// PHP-Funktion zum Erzeugen und Versenden einer Email:
							// mail(String Empfängeradresse, String Betreff, String Inhalt, String Header)

							$to = $email;
							$subject = "Ihre Registrierung auf www.meineseite.de (äöüßÄÖÜẞ)";

							//Betreffzeile codieren mit BASE64
							$subjectEncoded = "=?UTF-8?B?" . base64_encode($subject) . "?=";

							// Der Header folgt einem fest vorgeschriebenen Aufbau:
							$header = "FROM: PHP-Kurs <phpkurs@gmx.net>\n";
							// Adresse für den Antworten-Button:
							$header .= "Reply-to: phpkurs@gmx.net\n";
							// Für Text-Emails: "Content-Type: text/plain; charset=utf-8\r\n"
							// Für HTML-Emails:
							$header .= "Content-Type: text/html; charset=utf-8\n";
							$header .= "MIME-Version: 1.0\n";
							$header .= "X-Mailer: PHP " . phpversion();

							$content = "<h4>Hallo $firstname $lastname,</h4>
										<p>Sie haben sich am " . date("d.m.Y") . " um " . date("H:i") . " Uhr 
										auf unserer Webseite registriert.</p>
										<p>Zur Erinnerung: Ihr Accountname lautet <strong>$accountname</strong></p>
										<p>Wir wünschen Ihnen viel Spaß beim Stöbern in unseren Angeboten.</p>
										<br>
										<p>Viele Grüße<br>
										Ihr www.meineseite.de-Team</p>";

							if(DEBUG) echo "<br>";
							if(DEBUG) echo "<hr>";
							if(DEBUG) echo "<p>Header: " . nl2br($header, false) . "</p>";
							if(DEBUG) echo "<p>To: $to</p>";
							if(DEBUG) echo "<p>Subject: $subject</p>";
							if(DEBUG) echo "$content";
							if(DEBUG) echo "<hr>";
							if(DEBUG) echo "<br>";


							// Bestätigungsmail senden
							if( !@mail($to, $subject, $content, $header) ) {
								// Fehlerfall

								if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: bei Übergabe der Email an $email an den Mailserver! <i>(" . basename(__FILE__) . ")</i></p>\r\n";






							} else {
								// Erfolgsfall

								if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Email an $email erfolgreich an den Mailserver übergeben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";



							}

						}
					}
				}
			}
		}
	}

	//endregion

?>



<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Benutzerverwaltung - Registrierung</title>

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/debug.css">
</head>

<body>
<!-- -------- PAGE HEADER START -------- -->
<header class="loginheader">
	<p><a href="index.php"><< Zum Login</a></p>
</header>
<div class="clearer"></div>

<hr>
<!-- -------- PAGE HEADER END -------- -->


<h1>Benutzerverwaltung - Registrierung</h1>
<?= $dbMessage ?>
<?php if($showForm): ?>
<form action="" method="POST">

	<input type="hidden" name="formsentRegistration">



	<fieldset>

		<legend>Userdaten</legend>

		<input type="text" name="firstname" placeholder="Vorname" value="<?= $firstname ?>"><span class="marker">*</span><br>
		<span class="error"><?= $errorFirstname ?></span>

		<input type="text" name="lastname" placeholder="Nachname" value="<?= $lastname ?>"><span class="marker">*</span><br>
		<span class="error"><?= $errorLastname ?></span>

		<input type="text" name="email" placeholder="Email-Adresse" value="<?= $email ?>"><span class="marker">*</span><br>
		<span class="error"><?= $errorEmail ?></span>

	</fieldset>

	<fieldset>

		<legend>Accountdaten</legend>

		<small><i>Der Accountname soll frei ausgedacht werden (4 bis 20 Zeichen).</i></small>

		<input type="text" name="accountname" placeholder="Bitte wählen Sie einen Accountnamen..." value="<?= $accountname ?>"><span class="marker">*</span><br>
		<span class="error"><?= $errorAccountname ?></span>

		<input type="password" name="password" placeholder="Bitte wählen Sie ein Passwort..."><span class="marker">*</span><br>
		<span class="error"><?= $errorPassword ?></span>

		<input type="password" name="passwordCheck" placeholder="Bitte Passwort wiederholen..."><span class="marker">*</span><br>
		<span class="error"><?= $errorPasswordCheck ?></span>

	</fieldset>





	<input type="submit" value="Jetzt registrieren">

</form>
<?php endif ?>

</body>
</html>