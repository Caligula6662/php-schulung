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
	require_once("include/db.inc.php");


	#**********************************************************************************#
?>

<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Dateioperationen</title>

		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/pageElements.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>
	
	<body>
		<h1>Dateioperationen</h1>
		<p>
			Eine einzulesende Datei muss utf-8 codiert sein. Das geschieht am
			besten, indem man sie in Notepad++ erzeugt und unter "Kodierung"
			utf-8 ohne BOM auswählt.
		</p>

		<h2>Datei auslesen</h2>
		<p>
			Die PHP-Funktion file_get_contents() dient dazu, in PHP Dateien (Files)
			zu öffnen und einzulesen. Die Funktion erwartet als Parameter den Pfad
			zur zu öffnenden Datei und liefert den Inhalt der Datei als einen String zurück.
		</p>
		<p>
			Alternativ kann auch die Funktion readfile() verwendet werden, die zusätzlich zum
			Dateiinhalt auch die Dateigröße in Bytes ausgibt. Da die Dateigröße einfach an den
			Inhaltsstring angehängt wird, kann man damit allerdings nur in speziellen Situationen
			etwas anfangen.
		</p>

		<?php
			// wenn file_get_contents() eine Datei findet und deren Inhalt
			// erfolgreich in eine Variable geschrieben hat...
			// ein @ vor einem Funktionsaufruf unterdrückt die Ausgabe der von dieser
			// Funktion generierten Fehlermeldung im Frontend
			if ($fileContent = @file_get_contents("dateioperationen.txt")) {
				if(DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Datei erfolgreich gelesen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				echo "<p><i>" . nl2br($fileContent, false) . "</i></p>";
			} else {
				if(DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Fehler beim Auslesen der Datei. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
			}
		?>

		<h3>Datei zeilenweise auslesen</h3>
		<p>
			Die PHP-Funktion file() liest eine Datei zeilenweise ein und
			erzeugt ein Array, in dem jede Zeile als eigener Wert (String)
			gespeichert wird. Die Funktion erwartet als Parameter den Pfad
			zur zu öffnenden Datei.
		</p>

		<?php
			$fileContentArray = file("dateioperationen.txt");
			if(DEBUG) echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
			if(DEBUG) print_r($fileContentArray);
			if(DEBUG) echo "</pre>";
		?>

		<h3>Nur die erste Zeile der Textdatei ausgeben:</h3>
		<p><i><?php echo $fileContentArray[0] ?></i></p>
		<p>- - -</p>

		<h3>Alle Zeilen der Textdatei ausgeben:</h3>

		<?php foreach ($fileContentArray as $key => $value): ?>
			<p><i><?php echo "$key: $value" ?></i></p>
		<?php endforeach; ?>
		<p>- - -</p>

		<h3>Alle ungeraden Zeilen der Textdatei ausgeben:</h3>

		<?php foreach ($fileContentArray as $key => $value): ?>
			<?php if( $key%2 == 1 ): ?>
				<p><i><?php echo "$key: $value" ?></i></p>
			<?php endif ?>
		<?php endforeach ?>
		<p>- - -</p>

		<h3>Eine zufällige Zeile der Textdatei ausgeben:</h3>

		<p>
			<i>
				<?php
					$arrayLength = count($fileContentArray) - 1;
					echo $fileContentArray[rand(0,$arrayLength)]
				?>
			</i>
		</p>
		<p>- - -</p>


		<h2>In Datei schreiben</h2>
		<h4>Inhalt überschreiben</h4>
		<p>
			Um in Dateien schreiben zu können, existiert in PHP die Funktion
			file_put_contents($filename,$content). Als Argument erwartet die
			Funktion als erstes den Dateipfad und als zweites die Daten, die
			in die Datei geschrieben werden sollen.<br>
			<br>
			Ist die Datei (noch) nicht vorhanden, wird sie kurzerhand erzeugt.<br>
			Ist die Datei bereits vorhanden, wird ihr Inhalt überschrieben.
		</p>

		<?php
			if( !@file_put_contents("dateioperationen2.txt", "Hier steht mein Content...") ) {
				// Fehlerfall
				if(DEBUG) echo "<p class='debug err'>FEHLER beim Schreiben in Datei!</p>";

			} else {
				// Erfolgsfall
				if(DEBUG) echo "<p class='debug ok'>Erfolgreich in Datei geschrieben.</p>";

				// Inhalt der Datei auslesen:
				echo "<p><i>" . nl2br( file_get_contents("dateioperationen2.txt") ) . "</i></p>";

				// Inhalt der Datei überschreiben:
				file_put_contents("dateioperationen2.txt", "Hier steht mein neuer Content...");
				if(DEBUG) echo "<p class='debug'>Datei wird überschrieben...</p>";

				// Inhalt der Datei erneut auslesen:
				echo "<p><i>" . nl2br( file_get_contents("dateioperationen2.txt") ) . "</i></p>";
			}
		?>

		<p>- - -</p>
		<h4>Inhalt an vorhandenen Inhalt anhängen</h4>
		<p>
			Um in Dateien schreiben zu können, existiert in PHP die Funktion
			file_put_contents($filename,$content). Als Argument erwartet die
			Funktion als erstes des Dateipfad und als zweites die Daten, die
			in die Datei geschrieben werden sollen. Als dritter optionaler Parameter
			kann das Flag FILE_APPEND gesetzt werden. Hierdurch wird der Inhalt der Datei
			nicht überschrieben, sondern der neue Inhalt wird an das Ende des vorhandenen Inhalts
			angehängt.<br>
			<br>
			Ist die Datei (noch) nicht vorhanden, wird sie kurzerhand erzeugt.<br>
			Ist die Datei bereits vorhanden, wird ihr Inhalt nicht überschrieben.
		</p>
		<?php
			if( !file_put_contents("dateioperationen3.txt", "Hier steht mein Content...\r\n") ) {
				// Fehlerfall
				if(DEBUG) echo "<p class='debug err'>FEHLER beim Schreiben in Datei!</p>";

			} else {
				// Erfolgsfall
				if(DEBUG) echo "<p class='debug ok'>Erfolgreich in Datei geschrieben.</p>";

				// Inhalt der Datei auslesen:
				echo "<p><i>" . nl2br( file_get_contents("dateioperationen3.txt") ) . "</i></p>";

				// Inhalt an Datei anhängen:
				file_put_contents("dateioperationen3.txt", "Hier steht mein neuer Content...\r\n", FILE_APPEND);
				if(DEBUG) echo "<p class='debug'>Inhalt wird an Datei angehangen...</p>";

				// Inhalt der Datei erneut auslesen:
				echo "<p><i>" . nl2br( file_get_contents("dateioperationen3.txt") ) . "</i></p>";
			}
		?>
		<p>- - -</p>
		<h2>Datei löschen</h2>
		<p>Mittels der Funktion unlink() kann eine Datei auf dem Server gelöscht werden.</p>

		<?php
			if( !@unlink("dateioperationen3.txt") ) {
				// Fehlerfall
				if(DEBUG) echo "<p class='debug err'>FEHLER beim Löschen der Datei!</p>";

			} else {
				// Erfolgsfall
				if(DEBUG) echo "<p class='debug ok'>Datei wurde erfolgreich gelöscht.</p>";
			}
		?>

		<p><a href="https://www.marvel.com/captainmarvel/">Marvelwebseite im Retrostil</a></p>


		<h3>Wir bauen uns einen Besucherzähler mit PHP und einer Textdatei</h3>
		<p>
			Ein Besucherzähler soll auf der Webseite anzeigen, wie oft die Seite
			bereits aufgerufen wurde. Hierzu wird eine Textdatei angelegt, in der
			der Zähler gespeichert werden und vor jedem Speichervorgang hochgezählt
			werden soll.
		</p>

		<?php
			// zaehler auslesen
			$zaehler = file_get_contents("zaehler.txt");
			//hochzählen
			$zaehler = $zaehler + 1;
			//speichern
			file_put_contents("zaehler.txt", $zaehler);
		?>

		<hr>
			<p style="text-align: center">Sie sind Besucher Nr. <strong><?php echo $zaehler ?></strong></p>
		<hr>

	</body>
</html>