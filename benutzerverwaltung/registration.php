<?php

	require_once ("include/config.inc.php");
	require_once ("include/form.inc.php");


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


</body>
</html>