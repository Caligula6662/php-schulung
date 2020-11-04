<?php


	#**********************************************************************************#


	#**************************************#
	#********** CONTINUE SESSION **********#
	#**************************************#

	// Session fortführen
	// session_start() legt eine neue Session an, ODER führt eine bestehende Session fort
	// session_start() holt sich das Session-Cookie vom Browser und vergleicht, ob es eine
	// passende Session dazu auf dem Server gibt. Falls ja, wird diese Session fortgeführt;
	// falls nein (Cookie existiert nicht/Session existiert nicht), wird eine neue Session angelegt
	session_name("benutzerverwaltung");
	session_start();





	// Secure Page

	if ( !isset($_SESSION["acc_id"])) {
		//Leere Session löschen
		session_destroy();
		//Umleiten auf die index.php
		header("Location: index.php");
		exit;
	}

	require_once("include/config.inc.php");
	require_once("include/db.inc.php");
	require_once("include/form.inc.php");

//	$accountname = NULL;
//	$stateLabel = NULL;
//	$roleLabel = NULL;
//	$firstname = NULL;
//	$lastname = NULL;

	$passwordChange = false;

	$dbMessage = NULL;
	$deleteCheckMessage = NULL;
	$errorFirstname = NULL;
	$errorLastname = NULL;
	$errorEmail = NULL;
	$errorBirthdate = NULL;
	$errorImageUpload = NULL;
	$errorPassword = NULL;

	$monthsArray = array("01"=>"Januar", "02"=>"Februar", "03"=>"März", "04"=>"April", "05"=>"Mai", "06"=>"Juni", "07"=>"Juli", "08"=>"August", "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Dezember");



//	if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//	if(DEBUG)	print_r($_SESSION);
//	if(DEBUG)	echo "</pre>";

	// Schritt 1 URL: Prüfen, ob URL-Parameter übergeben wurde

	if( isset($_GET['action']) ) {
		if (DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: URL-Parameter 'action' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe

		$action = cleanString($_GET['action']);

		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$action: $action <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Schritt 3 URL: i.d.R. Verzweigen

		if( $action == "logout" ) {
			if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Im Zweig Logout gelandet  <i>(" . basename(__FILE__) . ")</i></p>\r\n";


			// Schritt 4 URL Daten verarbeiten
			//Leere Session löschen
			session_destroy();
			//Umleiten auf die index.php
			header("Location: index.php");
			exit;

		}

	}


	// User- und Accountdaten von der Datenbank abholen

	if(DEBUG)	echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Profildaten werden aus DB gelesen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

	// Schritt 1 DB: Verbindung herstellen

	$pdo = dbConnect();

	// Schritt 2 DB: SQL Statement vorbereiten

	$statement = $pdo->prepare("	
			SELECT * 
			FROM accounts 
			INNER JOIN states USING(sta_id)
			INNER JOIN roles USING(rol_id)
			INNER JOIN users USING(usr_id)
			WHERE acc_id = :ph_acc_id
		");

	// Schritt 3 DB: SQL-Statement ausführen

	$statement->execute( array("ph_acc_id" => $_SESSION["acc_id"]) );

	if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

	// Schritt 4 DB: Daten weiterverarbeiten
	// Bei lesendem Zugriff Datensätze abholen

	$row = $statement->fetch(PDO::FETCH_ASSOC);

//	if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//	if(DEBUG)	print_r($row);
//	if(DEBUG)	echo "</pre>";

	// Daten aus Tabelle 'users'
	$usr_id = $row['usr_id'];
	$firstname = $row['usr_firstname'];
	$lastname = $row['usr_lastname'];
	$email = $row['usr_email'];

	$birthdate = $row['usr_birthdate'];

	$year = substr($birthdate, 0,4);
	$month = substr($birthdate, 5,2);
	$day = substr($birthdate, 8,2);

	$street = $row['usr_street'];
	$housenumber = $row['usr_housenumber'];
	$zip = $row['usr_zip'];
	$city = $row['usr_city'];
	$country = $row['usr_country'];
	$registerdate = $row['usr_registerdate'];

	// Daten aus Tabelle 'accounts'
	$acc_id = $_SESSION['acc_id'];
	$accountname = $row['acc_name'];
	$password = $row['acc_password'];
	$signature = $row['acc_signature'];
	$info = $row['acc_info'];
	$info = $row['acc_info'];
	$avatarpath = $row['acc_avatarpath'];

	// Daten aus Tabelle 'labels'
	$stateId = $row['sta_id'];
	$stateLabel = $row['sta_label'];

	// Daten aus Tabelle 'roles'
	$roleId = $row['rol_id'];
	$roleLabel = $row['rol_label'];

	#**********************************************************************************#


	// Formularverarbeitung

	// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde

	if( isset($_POST["formsentProfileEdit"])) {

		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Formular 'formsentProfileEdit' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";


		// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
		$firstname = cleanString($_POST['firstname']);
		$lastname = cleanString($_POST['lastname']);
		$email = cleanString($_POST['email']);
		$day = cleanString($_POST['day']);
		$month = cleanString($_POST['month']);
		$year = cleanString($_POST['year']);
		$street = cleanString($_POST['street']);
		$housenumber = cleanString($_POST['housenumber']);
		$zip = cleanString($_POST['zip']);
		$city = cleanString($_POST['city']);
		$country = cleanString($_POST['country']);
		$signature = cleanString($_POST['signature']);
		$info = cleanString($_POST['info']);

		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$firstname: $firstname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$lastname: $lastname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$email: $email <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$day: $day <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$month: $month <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$year: $year <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$street: $street <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$housenumber: $housenumber <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$zip: $zip <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$city: $city <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$country: $country <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$signature: $signature <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$info: $info <i>(" . basename(__FILE__) . ")</i></p>\r\n";


		// Passwort ändern

		// Prüfen ob ein Änderung vorgenommen werden soll

		if ($_POST["password"] !== "" OR $_POST["passwordCheck"] !== "") {

			if(DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Passwortänderung aktiv <i>(" . basename(__FILE__) . ")</i></p>\r\n";


			$password = cleanString($_POST["password"]);
			$passwordCheck = cleanString($_POST["passwordCheck"]);

			if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$password: $password <i>(" . basename(__FILE__) . ")</i></p>\r\n";
			if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$passwordCheck: $passwordCheck <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			$errorPassword = checkInputString($password, 4);

			if ( $errorPassword ) {
				// Fehler
				if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Das Passwort entspricht NICHT den Mindestanforderungen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			} else {
				// Erfolg
				if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Das Passwort entspricht NICHT den Mindestanforderungen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";


				// WICHTIG: 'BUG' in PHP! Wenn $password 1234 lautet und $passwordCheck 01234
				// erkennt der != Operator beide Werte als gleich! Daher unbedingt MIT Typprüfung !==
				// vergleichen
				if ( $password !== $passwordCheck) {
					// Fehler
					if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Die Passwörter stimmen NICHT überein. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					$errorPassword = "Die Passwörter stimmen nicht überein.";

				} else {
					// Erfolg
					if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Die Passwörter stimmen überein. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					// Passwort verschlüsseln

					$passwordHash = password_hash($password, PASSWORD_DEFAULT);
					if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$passwordHash: $passwordHash <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					// Flagg für Passwortänderung

					$passwordChange = true;
					if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$passwordChange: $passwordChange <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				}
			}
		}


		// Schritt 3 FORM: Werte validieren
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Feldvalidierungen <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$errorFirstname = checkInputString($firstname);
		$errorLastname = checkInputString($lastname);
		$errorEmail = checkEmail($email);


		// Datum validieren
		if( !$day OR !$month OR !$year) {

			if(DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Es wurden nicht alle Boxen ausgewählt.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

			$birthdate = NULL;
			// Hilfsvariablen zurücksetzen
			$day = NULL;
			$month = NULL;
			$year = NULL;
		} elseif( !checkdate($month, $day, $year) )   {
			// Wenn alle 3 Selectboxen ausgewählt wurden, aber das Datum NICHT valide ist:
			// ändere $birthdate nicht, sondern gib Fehlermeldung aus

			if(DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Datum ist ungültig.<i>(" . basename(__FILE__) . ")</i></p>\r\n";
			$errorBirthdate = "Dies ist kein gültiges Datum.";

		} else {
			$birthdate = "$year-$month-$day";
			if(DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Das Datum ist gültig.<i>(" . basename(__FILE__) . ")</i></p>\r\n";
		}

		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$birthdate: $birthdate <i>(" . basename(__FILE__) . ")</i></p>\r\n";


		//Finale Validierung

		if( $errorFirstname OR $errorLastname OR $errorEmail OR $errorBirthdate OR $errorPassword) {

			// Fehlerfall
			if(DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		} else {

			// Erfolgsfall
			if(DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist formal fehlerfrei und wird nun verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Schritt 4 FORM: Daten weiterverarbeiten

			// Email überprüfen

			$statement = $pdo->prepare("
					SELECT COUNT(usr_email) 
					FROM users 
					WHERE usr_email = :ph_email
					AND usr_id != :ph_usr_id
			");

			$statement->execute(array("ph_email"=>$email, "ph_usr_id"=>$usr_id));
			if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			//Daten weiterverarbeiten

			$anzahl = $statement->fetchColumn();
			if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>\$emailCount: $anzahl<i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Prüfe dass Email noch nicht existiert

			if( $anzahl ) {
				//Fehler

				if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>Die Email-Adresse ist bereits auf einem anderen Account registriert.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				$errorEmail = "Die Email-Adresse ist bereits auf einem anderen Account registriert.";

			} else {
				//Erfolg

				if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>Email ist noch nicht in der Datenbank.<i>(" . basename(__FILE__) . ")</i></p>\r\n";


				// Daten speichern
				if (DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>Profildaten werden in der Datenbank gespeichert.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				// $passwordchange

				$sql = "
						UPDATE users INNER JOIN accounts USING(usr_id)
						SET
						usr_firstname = :ph_usr_firstname,
						usr_lastname = :ph_usr_lastname,
						usr_email = :ph_usr_email,
						usr_birthdate = :ph_usr_birthdate,
						usr_street = :ph_usr_street,
						usr_housenumber = :ph_usr_housenumber,
						usr_zip = :ph_usr_zip,
						usr_city = :ph_usr_city,
						usr_country = :ph_usr_country,
						acc_signature = :ph_acc_signature,
						acc_info = :ph_acc_info,
						acc_avatarpath = :ph_acc_avatarpath";

				if ( $passwordChange ) {
					$sql .= ", acc_password = :ph_acc_password";
				}

				$sql .= " WHERE usr_id = :ph_usr_id";

				$params = array(
					"ph_usr_firstname" => $firstname,
					"ph_usr_lastname" => $lastname,
					"ph_usr_email" => $email,
					"ph_usr_birthdate" => $birthdate,
					"ph_usr_street" => $street,
					"ph_usr_housenumber" => $housenumber,
					"ph_usr_zip" => $zip,
					"ph_usr_city" => $city,
					"ph_usr_country" => $country,
					"ph_acc_signature" => $signature,
					"ph_acc_info" => $info,
					"ph_acc_avatarpath" => $avatarpath,
					"ph_usr_id" => $usr_id
				);

				if ( $passwordChange ) {
					$params["ph_acc_password"] = $passwordHash;
				}


				$statement = $pdo->prepare($sql);
				$statement->execute($params);
				if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				$rowCount = $statement->rowCount();
				if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>\$rowCount: $rowCount<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				if( !$rowCount ) {
					// Fehler

					if(DEBUG)	echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>Es wurden keine Profildaten geändert.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

					$dbMessage = "<h3 class='info'>Es wurden keine Profildaten geändert.</h3>";

				} else {
					// Erfolg

					if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>Profildaten erfolgreich aktualisiert.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

					$dbMessage = "<h3 class='success'>Profildaten wurden erfolgreich geändert.</h3>";
				}
			}
		}
	}

?>

<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Default</title>

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/debug.css">
</head>

<body>
<!-- -------- PAGE HEADER START -------- -->
<!-- -------- PAGE HEADER -------- -->
<header class="fright loginheader">
	<p class="fright"><a href="?action=logout"><< Logout</a></p>
</header>
<div class="clearer"></div>

<hr>
<!-- -------- PAGE HEADER END -------- -->

<h1>Benutzerverwaltung - Edit Profile</h1>

<!-- ---------- PROFILE STATISTICS START ---------- -->
<p>Account-Name: <i><b><?= $accountname ?></b></i> | Account-Status: <?= $stateLabel ?> | Account-Role: <?= $roleLabel ?></p>
<br>
<h3 class='info'>Hallo <?= $firstname ?> <?= $lastname ?>.</h3>
<!-- ---------- PROFILE STATISTICS END ---------- -->

<hr>

<!-- -------- MESSAGE POPUP START -------- -->
<br>
<?php if( $dbMessage OR $deleteCheckMessage ): ?>
	<popupBox>
		<?= $dbMessage ?>
		<?= $deleteCheckMessage ?>
		<?php if( $dbMessage ): ?>
			<a class="button" onclick="document.getElementsByTagName('popupBox')[0].style.display = 'none'">Schließen</a>
		<?php endif ?>
	</popupBox>
<?php endif ?>
<br>
<!-- -------- MESSAGE POPUP END -------- -->


<!-- -------- FORM FOR PROFILE EDITING START -------- -->
<form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="formsentProfileEdit">

	<fieldset name="userdata">
		<legend>Benutzerdaten</legend>
		<span class="error"><?php echo $errorFirstname ?></span><br>
		<input type="text" name="firstname" placeholder="Vorname" value="<?php echo $firstname ?>"><span class="marker">*</span><br>
		<span class="error"><?php echo $errorLastname ?></span><br>
		<input type="text" name="lastname" placeholder="Nachname" value="<?php echo $lastname ?>"><span class="marker">*</span><br>
		<span class="error"><?php echo $errorEmail ?></span><br>
		<input type="text" name="email" placeholder="Email-Adresse" value="<?php echo $email ?>"><span class="marker">*</span><br>

		<!-- -------- BIRTHDAY SELECT BOXES START -------- -->
		<fieldset name="birthdate">
			<legend>Geburtsdatum</legend>
			<span class="error"><?php echo $errorBirthdate ?></span><br>

			<!-- DAY -->
			<select class="day" name="day">
				<option value="">Tag</option>
				<option value="" disabled>- - -</option>
				<?php for( $i=1; $i<=31; $i++ ): ?>
					<?php $i = sprintf("%02d", $i) // Datum mit führender 0 versehen ?>
					<?php if($i == $day): // Option vorselektieren?>
						<option value='<?php echo $i ?>' selected><?php echo $i ?></option>
					<?php else: ?>
						<option value='<?php echo $i ?>'><?php echo $i ?></option>
					<?php endif ?>
				<?php endfor ?>
			</select>

			<!-- MONTH -->
			<select class="month" name="month">
				<option value="">Monat</option>
				<option value="" disabled>- - -</option>
				<?php foreach( $monthsArray AS $key=>$value ): ?>
					<?php if( $key == $month ): // Option vorselektieren ?>
						<option value='<?php echo $key ?>' selected><?php echo $value ?></option>
					<?php else: ?>
						<option value='<?php echo $key ?>'><?php echo $value ?></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>

			<!-- YEAR -->
			<select class="year" name="year">
				<option value="">Jahr</option>
				<option value="" disabled>- - -</option>
				<?php for( $i=date("Y"); $i>=date("Y")-120; $i-- ): ?>
					<?php if( $i == $year ): // Option vorselektieren ?>
						<option value='<?php echo $i ?>' selected><?php echo $i ?></option>
					<?php else: ?>
						<option value='<?php echo $i ?>'><?php echo $i ?></option>
					<?php endif ?>
				<?php endfor ?>
			</select>

		</fieldset>
		<!-- -------- BIRTHDAY SELECT BOXES END -------- -->

		<input type="text" name="street" placeholder="Straße" value="<?php echo $street ?>"><br>
		<input type="text" name="housenumber" placeholder="Nummer" value="<?php echo $housenumber ?>"><br>
		<input type="text" name="zip" placeholder="PLZ" value="<?php echo $zip ?>"><br>
		<input type="text" name="city" placeholder="Ort" value="<?php echo $city ?>"><br>
		<input type="text" name="country" placeholder="Land" value="<?php echo $country ?>"><br>
	</fieldset>
	<fieldset name="accountdata">
		<legend>Accountdaten</legend>
		<input type="text" name="signature" placeholder="Signatur" value="<?php echo $signature ?>"><br>
		<textarea name="info" placeholder="Accountinformationen..."><?php echo $info ?></textarea>

		<!-- -------- FILE UPLOAD START-------- -->
		<fieldset name="avatar">
			<legend>Avatar</legend>
			<!-- -------- INFOTEXT FOR IMAGEUPLOAD START -------- -->
			<p class="small">
				Erlaubt sind Bilder des Typs
				<?php $allowedMimetypes = implode( ", ", IMAGE_ALLOWED_MIMETYPES ) ?>
				<?= strtoupper( str_replace( array(", image/jpeg", "image/"), "", $allowedMimetypes) ) ?>.
				<br>
				Die Bildbreite darf <?= IMAGE_MAX_WIDTH ?> Px nicht übersteigen.<br>
				Die Bildhöhe darf <?= IMAGE_MAX_HEIGHT ?> Px nicht übersteigen.<br>
				Die Dateigröße darf <?= IMAGE_MAX_SIZE/1024 ?>kB nicht übersteigen.
			</p>
			<!-- -------- INFOTEXT FOR IMAGEUPLOAD END -------- -->
			<img class="avatar" src="<?php echo $avatarpath ?>" alt="Avatar von <?php echo $accountname ?>" title="Avatar von <?php echo $accountname ?>"><br>
			<span class="error"><?php echo $errorImageUpload ?></span><br>
			<input type="file" name="avatar">
		</fieldset>
		<!-- -------- FILE UPLOAD END -------- -->

		<!-- -------- PASSWORD CHANGE START -------- -->
		<fieldset name="password">
			<legend>Passwort ändern</legend>
			<span class="error"><?php echo $errorPassword ?></span><br>
			<input type="password" name="password" placeholder="Neues Passwort">
			<input type="password" name="passwordCheck" placeholder="Neues Passwort wiederholen">
		</fieldset>
		<!-- -------- PASSWORD CHANGE END -------- -->

	</fieldset>

	<input type="submit" value="Änderungen speichern">
</form>
<!-- -------- FORM FOR PROFILE EDITING END -------- -->



<!-- -------- PAGE HEADER END -------- -->


<h1>Benutzerverwaltung</h1>
</body>
</html>