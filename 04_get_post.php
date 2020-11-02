<?php
	#**********************************************************************************#


	#***********************************#
	#********** CONFIGURATION **********#
	#***********************************#

	// include(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Problem mit doppelter Einbindung derselben Datei
	// require(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Problem mit doppelter Einbindung derselben Datei
	// include_once(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Kein Problem mit doppelter Einbindung derselben Datei
	// require_once(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Kein Problem mit doppelter Einbindung derselben Datei
	require_once("include/config.inc.php");


	#**********************************************************************************#


	#*****************************************#
	#********** INITIALZE VARIABLES **********#
	#*****************************************#

	$content = NULL;


	#**********************************************************************************#


	#********************************************#
	#********** PROCESS URL PARAMETERS **********#
	#********************************************#

	/*
if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
if(DEBUG)	print_r($_GET);
if(DEBUG)	echo "</pre>";
	*/

	// Schritt 1 URL: Prüfen, ob URL-Parameter übergeben wurde
	if( isset($_GET['action']) ) {
		if(DEBUG)		echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: URL-Parameter 'action' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe

		// SICHERHEIT: Damit so etwas nicht passiert: ?action=<script>alert("HACK!")</script>
		// muss der empfangene String ZWINGEND entschärft werden!
		// htmlspecialchars() wandelt potentiell gefährliche Steuerzeichen wie
		// < > "" & in HTML-Code um (&lt; &gt; &quot; &amp;)
		// Der Parameter ENT_QUOTES wandelt zusätzlich einfache '' in &apos; um
		// Der Parameter ENT_HTML5 sorgt dafür, dass der generierte HTML-Code HTML5-konform ist
		// trim() entfernt vor und nach einem String sämtliche Whitespaces (Leerzeichen, Tabs, Zeilenumbrüche)
		$action = trim( htmlspecialchars( $_GET['action'], ENT_QUOTES | ENT_HTML5 ) );
		if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$action: $action <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Schritt 3 URL: i.d.R. Verzweigen


		#********** SHOW NEWS **********#
		if( $action == "showNews" ) {
			if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Zeige News... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Schritt 4 URL: Daten weiterarbeiten
			$content  = "<h5>Heute frisch aus den Nachrichten:</h5>";
			$content .= "<p>Bla blabla bla? Bla bla!</p>";


			#********** SHOW WEATHER **********#
		} elseif( $action == "showWeather" ) {
			if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Zeige Wetter... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Schritt 4 URL: Daten weiterarbeiten
			$content  = "<h5>Heute Sturm und Regen.</h5>";
			$content .= "<p>Wir werden alle sterben!!!</p>";

		}

	} // PROCESS URL PARAMETERS END


	#**********************************************************************************#


	#**********************************#
	#********** PROCESS FORM **********#
	#**********************************#

	/*
if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
if(DEBUG)	print_r($_POST);
if(DEBUG)	echo "</pre>";
	*/

	// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
	if( isset( $_POST['formsentMessage'] ) ) {
		if(DEBUG)		echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Formular 'Message' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe

		// SICHERHEIT: Damit so etwas nicht passiert: ?action=<script>alert("HACK!")</script>
		// muss der empfangene String ZWINGEND entschärft werden!
		// htmlspecialchars() wandelt potentiell gefährliche Steuerzeichen wie
		// < > "" & in HTML-Code um (&lt; &gt; &quot; &amp;)
		// Der Parameter ENT_QUOTES wandelt zusätzlich einfache '' in &apos; um
		// Der Parameter ENT_HTML5 sorgt dafür, dass der generierte HTML-Code HTML5-konform ist
		// trim() entfernt vor und nach einem String sämtliche Whitespaces (Leerzeichen, Tabs, Zeilenumbrüche)
		$firstname 	= trim( htmlspecialchars( $_POST['firstname'], ENT_QUOTES | ENT_HTML5 ) );
		$lastname 	= trim( htmlspecialchars( $_POST['lastname'], ENT_QUOTES | ENT_HTML5 ) );
		$birthdate 	= trim( htmlspecialchars( $_POST['birthdate'], ENT_QUOTES | ENT_HTML5 ) );
		if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$firstname: $firstname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$lastname: $lastname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$birthdate: $birthdate <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Schritt 3 FORM: ggf. Feldvalidierung

		// Schritt 4 FORM: Daten weiterverarbeiten
		$content  = "<h5>Hallo $firstname $lastname!</h5>";
		$content .= "<p>Dein Geburtsdatum ist der $birthdate.</p>";

	} // PROCESS FORM END


	#**********************************************************************************#
?>

<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Interaktion & Datenübergabe (GET & POST)</title>

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/pageElements.css">
	<link rel="stylesheet" href="css/debug.css">
</head>

<body>
<h1>Interaktion & Datenübergabe (GET & POST)</h1>
<p>
	Daten werden innerhalb von PHP-Seiten entweder über die URL (URL-Parameter)
	oder über ein Formular von einer Seite an die nächste weitergereicht.<br>
	Diese Daten/Parameter werden vom PHP-Code abgefangen und anschließend weiterverarbeitet.
</p>
<p>
	Diese Daten werden in PHP mittels der Methoden $_GET bzw. $_POST von einer
	PHP-Seite an eine andere (oder an sich selbst) übergeben.<br>
	<br>
	Im nächsten Schritt können diese übergebenen Werte dann ausgelesen und
	anschließend weiterverarbeitet werden.
</p>
<p>
	<b>Merke:</b> Alle Daten, egal ob via URL-Parameter oder via Formularfelder werden
	als Datentyp String übergeben. Genau deshalb verfügt PHP von Hause aus über
	keine feste Datentypisierung und interpretiert bei mathematischen Berechnungen
	oder vergleichen einen String als Integer.
</p>

<br>
<hr>
<br>

<h2>$_GET (Parameterübergabe via URL)</h2>
<p>
	Das Konstrukt $_GET liest Parameter aus, die über die URL übergeben wurden,
	also beispielsweise www.meineseite.de?action=showNews&range=lastMonth.
</p>
<p>
	Die Syntax zu dieser URL folgt dem Schema "name-der-webseite?parameter1=wert1&amp;parameter2=wert2 ..."
</p>

<h4>Links zur Seitensteuerung</h4>
<p><a href="04_get_post.php">Seitenaufruf ohne Parameter</a></p>
<p><a href="04_get_post.php?action=showNews">Zeige Nachrichten</a></p>
<p><a href="04_get_post.php?action=showWeather">Zeige Wetter</a></p>

<br>
<hr>
<br>

<?php echo $content ?>

<br>
<hr>
<br>

<form action="" method="POST">

	<input type="hidden" name="formsentMessage">

	<input type="text" name="firstname" placeholder="Vorname"><br>
	<input type="text" name="lastname" placeholder="Nachname"><br>
	<input type="text" name="birthdate" placeholder="Geburtsdatum"><br>

	<input type="submit" value="Absenden">
</form>


</body>
</html>