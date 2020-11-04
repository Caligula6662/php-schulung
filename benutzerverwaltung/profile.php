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

	$accountname = NULL;
	$stateLabel = NULL;
	$roleLabel = NULL;
	$firstname = NULL;
	$lastname = NULL;



	if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
	if(DEBUG)	print_r($_SESSION);
	if(DEBUG)	echo "</pre>";

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




	#**********************************************************************************#


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
<!-- -------- PAGE HEADER END -------- -->


<h1>Benutzerverwaltung</h1>
</body>
</html>