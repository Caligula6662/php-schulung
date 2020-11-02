<?php
#**********************************************************************************#

				$starttime = microtime(true);
				#***********************************#
				#********** CONFIGURATION **********#
				#***********************************#
				
				// include(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Problem mit doppelter Einbindung derselben Datei
				// require(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Problem mit doppelter Einbindung derselben Datei
				// include_once(Pfad zur Datei): Bei Fehler wird das Skript weiter ausgeführt. Kein Problem mit doppelter Einbindung derselben Datei
				// require_once(Pfad zur Datei): Bei Fehler wird das Skript gestoppt. Kein Problem mit doppelter Einbindung derselben Datei
				require_once("include/config.inc.php");


#**********************************************************************************#
?>

<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Datums- und Zeitfunktionen in PHP</title>
		
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/pageElements.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>
	
	<body>
		<h1>Datums- und Zeitfunktionen in PHP</h1>
			<p>Es gibt in PHP prinzipiell 5 wichtige Funktionen zum Thema Zeit & Datum:</p>
			<ul>
				<li>time()</li>
				<li>date()</li>
				<li>strtotime()</li>
				<li>checkdate()</li>
				<li>microtime()</li>
			</ul>
			
			<br>
			<hr>
			<br>
			
			<h3>time()</h3>
			<p>
				time() erzeugt einen klassischen UNIX-Timestamp (Anzahl der vergangenen Sekunden
				seit dem 01.01.1970 um 00:00:01 Uhr).
			</p>
			<?php
				$timestamp = time();
				echo "<p>\$timestamp: $timestamp</p>";
				
				// number_format() — Formatiert eine Zahl mit Tausender-Trennzeichen
				// Tausendertrennzeichen und Kommazeichen können optional konfiguriert werden
				// number_format(Float Zahl, Anzahl Nachkommastellen=0, Kommatrennzeichen, Tausendertrennzeichen)
				$timestampFormatted = number_format($timestamp, 0, ",", ".");
				echo "<p>\$timestampFormatted: $timestampFormatted</p>";
			?>
			<p>Timestamp von vor 1 Woche:</p>
			<?php
				$timestampOld = time() - (60*60*24*7);			// Sekunden * Minuten * Stunden * Tage
				echo "<p>\$timestampOld: $timestampOld</p>";
			?>
			
			<p>Wieviele Sekunden sind seit genau 1 Woche vergangen?</p>
			<?php
				echo "<p>" . ($timestamp-$timestampOld) . "</p>";
			?>
			
			<p>
				Um einen Timestamp in einen sinnvollen Wert umzuwandeln, müssen die Sekunden
				wahlweise in Minuten, Stunden oder Tage etc. umgerechnet werden.
			</p>
			<p>Vergangene Sekunden seit 01.01.1970 um 00:00 Uhr: <b><?php echo time() ?></b>.</p>
			<p>Vergangene Minuten seit 01.01.1970 um 00:00 Uhr: <b><?php echo round( time()/60 ) ?></b>.</p>
			<p>Vergangene Stunden seit 01.01.1970 um 00:00 Uhr: <b><?php echo round( time()/60/60 ) ?></b>.</p>
			<p>Vergangene Tage seit 01.01.1970 um 00:00 Uhr: <b><?php echo round( time()/60/60/24 ) ?></b>.</p>
			<p>Vergangene Jahre seit 01.01.1970 um 00:00 Uhr: <b><?php echo floor( time()/60/60/24/365.25 ) ?></b>.</p>
			
			<br>
			<hr>
			<br>
			
			<h3>date()</h3>
			<p>Dient der Formatierung eines Timestamps in ein beliebiges Datums-/Zeitformat.</p>
			<p>
				date() gibt einen formatierten String anhand eines vorzugebenden Musters zurück. 
				Dabei wird entweder der angegebene Timestamp oder die gegenwärtige Zeit berücksichtigt, 
				wenn kein Timestamp angegegeben wird.<br>
				Mit anderen Worten ausgedrückt: der Parameter Timestamp ist optional und falls dieser 
				nicht angegeben wird, wird der Wert der Funktion time() angenommen. 
			</p>
			
			<p>
				Werte für die Formatierung von date():<br>
				<a href="http://php.net/manual/de/function.date.php" target="_blank">date() auf php.net</a>
			</p>
			<p><i>Beispiel: date("d.m.Y - H:i:s")</i><p>
			<p><?php echo date("d.m.Y - H:i:s") ?> (Datum im EU-Format + Uhrzeit)</p>
			<p><?php echo date("d.m.Y") ?> (Datum im EU-Format)</p>
			<p><?php echo date("H:i:s") ?> (Uhrzeit)</p>
			<p><?php echo date("H:i") ?> (Uhrzeit ohne Sekunden)</p>
			<p><?php echo date("Y-m-d") ?> (Datum im ISO-Format)</p>
			<p><?php echo date("m/d/Y") ?> (Datum im US-Format)</p>
			<p><?php echo date("d.m.Y", $timestampOld) ?> (Datum im EU-Format von vor 1 Woche)</p>
			
			<br>
			<hr>
			<br>
			
			<h3>strtotime()</h3>
			<p>Hilft bei der Berechnung von Daten anhand eines Datumsstrings.</p>
			<p>
				strtotime() erwartet einen String mit einem Datum im ISO (YYYY-MM-DD), American (MM/DD/YYYY) 
				oder European (DD.MM.YYYY) Datumsformat und versucht, dieses Format in einen Unix-Timestamp zu übersetzen.<br>
				Wenn nicht anders angegeben, wird die Angabe relativ zum Timestamp der aktuellen Zeit ausgewertet. 
			</p>
			
			<p>- - -</p>
				
			<h5>ISO-Format (YYYY-MM-DD):</h5>
			<?php $timestamp = strtotime("2009-05-31") ?>
			<p>
				'2009-05-31' als Timestamp: <b><?php echo $timestamp ?></b><br>
				entspricht dem Datum <?php echo date("Y-m-d", $timestamp) ?>
			</p>
			
			<h5>US-Format (MM/DD/YYYY):</h5>
			<?php $timestamp = strtotime("05/31/2009") ?>
			<p>
				'05/31/2009' als Timestamp: <b><?php echo $timestamp ?></b><br>
				entspricht dem Datum <?php echo date("m/d/Y", $timestamp) ?>
			</p>
			
			<h5>EU-Format (DD.MM.YYYY):</h5>
			<?php $timestamp = strtotime("31.05.2009") ?>
			<p>
				'31.05.2009' als Timestamp: <b><?php echo $timestamp ?></b><br>
				entspricht dem Datum <?php echo date("d.m.Y", $timestamp) ?>
			</p>
			
			<p>- - -</p>
			
			<p>
				Anhand bestimmter reservierter Schlüsselworte wie "day", "week", "month" etc. lassen sich mittels 
				strtotime() auch Zeitintervalle in einen Timestamp umwandeln:
			</p>
			<h4>Datum von Morgen:</h4>
			<p>
				strtotime('+1 day'): <?php echo strtotime('+1 day') ?><br>
				entspricht dem Datum <b><?php echo date('d.m.Y', strtotime('+1 day')) ?></b>.
			</p>
			
			<h4>Datum von Heute in 1 Woche:</h4>
			<p>
				strtotime('+1 week'): <?php echo strtotime('+1 week') ?><br>
				entspricht dem Datum <b><?php echo date('d.m.Y', strtotime('+1 week')) ?></b>.
			</p>
			
			<h4>Datum von nächsten Mittwoch:</h4>
			<p>
				strtotime('next wednesday'): <?php echo strtotime('next wednesday') ?><br>
				entspricht dem Datum <b><?php echo date('d.m.Y', strtotime('next wednesday')) ?></b>.
			</p>
			
			<h4>Datum von letzten Sonntag:</h4>
			<p>
				strtotime('last sunday'): <?php echo strtotime('last sunday') ?><br>
				entspricht dem Datum <b><?php echo date('d.m.Y', strtotime('last sunday')) ?></b>.
			</p>
			
			<h4>Datum von Heute in 1 Woche plus 2 Tage plus 4 Stunden plus 12 Minuten:</h4>
			<p>
				strtotime('+1 week 2 days 4 hours 12 minutes'): <?php echo strtotime('+1 week 2 days 4 hours 12 minutes') ?><br>
				entspricht dem Datum <b><?php echo date('d.m.Y - H:i', strtotime('+1 week 2 days 4 hours 12 minutes')) ?></b>.
			</p>
			
			<h5>Schwachpunkt von strtotime(): ungültiges Datum</h5>
			<p>strtotime("31.02.2006"): <?php echo strtotime('31.02.2006') ?><br>
			entspricht dem Datum <b><?php echo date( "d.m.Y", strtotime('31.02.2006') ) ?></b></p>
			<p><i>Bei einem ungültigen Datum errechnet strtotime() einen falschen Timestamp, anstatt eine 
			Fehlermeldung auszugeben.</i></p>
			
			<br>
			<hr>
			<br>
			
			<h3>checkdate()</h3>
			<p>
				checkdate() prüft ein Gregorianisches Datum auf Gültigkeit. checkdate() kann beispielsweise 
				ermitteln, ob der 29.02.1955 ein valides Datum darstellt.
			</p>
			<p>
				Aufruf: checkdate( MM, TT, YYYY ). Ist das Datum gültig, gibt checkdate() true zurück, 
				ansonsten false.
			</p>
			<?php
				$day 		= 29;
				$month 	= 02;
				$year 	= 1956;
				
				if( !checkdate($month, $day, $year) ) {
					// Fehlerfall
					echo "<p class='error'>Der <b>$day.$month.$year</b> ist kein gültiges Datum!</p>";
				} else {
					// Erfolgsfall
					echo "<p class='success'>Der <b>$day.$month.$year</b> ist ein gültiges Datum.</p>";
				}
			?>
			
			<br>
			<hr>
			<br>
			
			<h3>microtime()</h3>
			<p>microtime() gibt den aktuellen Unix-Timestamp/Zeitstempel mit Mikrosekunden zurück.</p>
			<p>
				Standardmäßig gibt microtime() einen String im Format "Mikrosekunden Sekunden" zurück.
				Die Sekunden stellen die Anzahl der Sekunden dar, die seit dem 01.01.1970 um 00:00:00 Uhr vergangen sind.
				Die Mikrosekunden geben zuzüglich zu den vergangen Sekunden die fehlenden Microsekunden an.
			</p>
			<p>
				Wird microtime(true) als optionaler Parameter "true" mitgegeben, erfolgt die Rückgabe 
				des Timestamps als Float.
			</p>
			<p>microtime(): <?php echo microtime() ?></p>
			<p>microtime(true): <?php echo microtime(true) ?></p>
			
			<br>
			<hr>
			<br>






		<h4>microtime() als Timer bzw. Benchmark</h4>
		<p>
			microtime() kann beispielsweise als Timer bzw. Benchmark eingesetzt werden, um zu prüfen,
			wie lange die Ausführung eines PHP-Skripts dauert:
		</p>

		<p>
			Der Timer wird hierzu am Anfang des PHP-Skripts gestartet, indem der Rückgabewert von
			microtime() in eine Variable geschrieben wird. Am Ende des Skripts wird ebenfalls der Wert
			von microtime() in eine zweite Variable geschrieben. Zieht man nun den Wert der Startvariable
			vom Wert der Endvariable ab, erhält man die Zeit, die das Skript benötigt hat, um den Code
			zwischen diesen beiden Markern auszuführen.
		</p>

		<?php
			// Für eine längere Ausführungszeit des PHP-Skripts wird ein länger dauernder Prozess angestoßen



			//Timestamp für Benchmark setzen
			$endtime = microtime(true);

			//Differenz zwischen $starttime und $endtime berechnen
			$runtime = $endtime - $starttime;
			$runtime = round($runtime, 4);

			//Ausgabe des Messergebnisses im Frontend
			echo "<h3>Ausführungszeit des PHP-Skripts:</h3>";
			echo "<p>$runtime Sekunden</p>";


		// Ausgabe des Messergebnisses im Frontend
		echo "<h3>Ausführungszeit des PHP-Skripts: </h3>";
		echo "<p>$runtime Sekunden</p>";
		?>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		
	</body>
</html>