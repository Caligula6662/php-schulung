<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Schleifen und Arrays (Felder)</title>
	</head>

	<body>
		<h1>Schleifen und Arrays (Felder)</h1>
		<h2>Schleifen</h2>

		<p>
			Schleifen dienen in PHP dazu, automatisiert Datensätze zu
			durchsuchen bzw. automatisiert Daten zu erzeugen.<br>
			<br>
			Eine Schleife besteht i.d.R. aus einer Bedingung, in der festgelegt wird,
			wie oft die Schleife ausgeführt wird, sowie aus einem Schleifenrumpf, in
			dem der Code notiert wird, der in jedem einzelnen Schleifendurchlauf
			ausgeführt werden soll.<br>
			<br>
			<b><i>Beispiel:</i></b>
		</p>

		<h3>for-Schleife</h3>
		<p>
			Die for-Schleife funktioniert wie folgt:<br>
			Als erstes wird ein Zähler deklariert und initialisiert.<br>
			Dann wird eine Abbruchbedingung definiert.<br>
			Dann wird die Abbruchbedingung geprüft.<br>
			Dann wird der Schleifenrumpf ausgeführt.<br>
			Zum Schluss wird der Zähler hoch- oder runtergezählt.<br>
			In jedem weiteren Schleifendurchlauf wird nun zuerst die Abbruchbedingung überprüft,
			danach der Schleifenrumpf ausgeführt und zum Schluss der Zähler modifiziert.
		</p>
		<?php
			/*
			for( Initialisierung des Zählers; wie lange soll die Schleife laufen; Änderung des Zählers je Schleifendurchlauf ) {
				Code, der in jedem Schleifendurchlauf ausgeführt wird;
			}
			*/
			// $i = $i+1 ist das gleiche wie $i+=1 ist das gleiche wie $i++
			for( $i=0; $i<5; $i++ ) {
				echo "$i ";
			}
			echo "<p>- - -</p>";

			// Gib die 12 Monate des Jahres aus (1-12)
			for( $i=1; $i<=12; $i++ ) {
				echo "$i ";
			}
			echo "<p>- - -</p>";

			// Gib die 12 Monate des Jahres aus (rückwärts von 12-1)
			for( $i=12; $i>=1; $i-- ) {
				echo "$i ";
			}
			echo "<p>- - -</p>";

			// Gib die 12 Monate des Jahres aus (nur die geraden Monate)
			// Variante 1:
			for( $i=1; $i<=12; $i++ ) {
				echo ++$i . " ";
			}
			echo "<p>- - -</p>";

			// Variante 2:
			for( $i=2; $i<=12; $i+=2 ) {
				echo "$i ";
			}
			echo "<p>- - -</p>";

			// Variante 3:
			for( $i=1; $i<=12; $i++ ) {
				if( $i%2 == 0 ) {
					echo "$i ";
				}
			}
			echo "<p>- - -</p>";
		?>

		<br>
		<hr>
		<br>

		<h3>do-while-Schleife</h3>
		<p>
			Im Gegensatz zur for-Schleife wird die do-while-Schleife immer mindestens 1 Mal ausgeführt.<br>
			<br>
			Die do-while-Schleife funktioniert wie folgt:<br>
			Zuerst wird außerhalb der Schleife der Iterator definiert und initialisiert.<br>
			Dann wird der Schleifenrumpf ausgeführt, in dem auch der Iterator hoch- oder runtergezählt wird.<br>
			Zum Schluss wird die Bedingung überprüft.
		</p>
		<?php
			$i=0;
			do {
				echo "$i ";
				$i++;
			} while( $i<5 );
		?>

		<br>
		<hr>
		<br>

		<h2>Arrays (Felder)</h2>
		<p>
			Ein Array ist eine Variable, die mehrere Werte beinhalten kann.
			Ein Array kann auch andere Arrays beinhalten. In diesem Fall spricht man von
			mehrdimensionalen Arrays. Ein Array kann Werte von unterschiedlicher Art enthalten,
			also beispielsweise sowohl Strings als auch Integers.<br>
			<br>
			Ein Array besteht immer aus einem Schlüssel/Wertepaar, nämlich dem sogenannten Key und dem zum Key gehörigen Wert.
			Üblicherweise wird der Key eines Arrays im Form eines Zähl-Index automatisch gesetzt.
		</p>

		<h3>Numerische Arrays</h3>
		<h4>Numerisches Array deklarieren und initialisieren:</h4>
		<?php
			// Numerisches Array deklarieren und intialisieren
			$wochentageArray = array("Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag");

			echo "<pre>";
			// var_dump($wochentageArray);
			print_r($wochentageArray);
			echo "</pre>";

			// Einzelnen Wert aus dem Array über dessen Index auslesen:
			// "Mittwoch"
			echo "<h4>Einen einzelnen Wert aus dem Array über dessen Key/Index auslesen (Mittwoch):</h4>";
			echo $wochentageArray[2];
			echo "<h4>Einen einzelnen Wert aus dem Array über dessen Key/Index auslesen (Samstag):</h4>";
			echo $wochentageArray[5];
		?>

		<br>
		<hr>
		<br>

		<h4>Einen Wert an ein numerisches Array anhängen:</h4>
		<?php
			$wochentageArray[] = "Feiertag";
			echo "<pre>";
			print_r($wochentageArray);
			echo "</pre>";
		?>

		<br>
		<hr>
		<br>

		<h4>Einen bestehenden Wert innerhalb eines numerischen Arrays überschreiben:</h4>
		<?php
			$wochentageArray[1] = "Badetag";
			echo "<pre>";
			print_r($wochentageArray);
			echo "</pre>";
		?>

		<br>
		<hr>
		<br>

		<h4>Einen bestehenden Wert aus einem numerischen Array löschen:</h4>
		<?php
			// unset($wochentageArray[5]);
			$wochentageArray[5] = NULL;
			echo "<pre>";
			print_r($wochentageArray);
			echo "</pre>";
		?>

		<br>
		<hr>
		<br>

		<h4>Numerisches Array mittels Schleife auslesen:</h4>
		<h5>for-Schleife:</h5>
		<?php
			for( $i=0; $i<=7; $i++ ) {
				echo "$wochentageArray[$i] ";
			}

			// Noch einen Wert an ein numerisches Array anhängen
			$wochentageArray[] = "Geburtstag";
			echo "<pre>";
			print_r($wochentageArray);
			echo "</pre>";

			// count() liefert die Anzahl der Einträge in einem Array zurück
			for( $i=0; $i < count($wochentageArray); $i++ ) {
				echo "$wochentageArray[$i] ";
			}
		?>

		<br>
		<hr>
		<br>

		<h5>do-while-Schleife</h5>
		<?php
			$i=0;
			do {
				echo "$wochentageArray[$i] ";
				$i++;
			} while( $i < count($wochentageArray) );
		?>

		<br>
		<hr>
		<br>

		<h5>while-Schleife</h5>
		<?php
			$i=0;
			while( $i < count($wochentageArray) ) {
				echo "$wochentageArray[$i] ";
				$i++;
			}
		?>

		<br>
		<hr>
		<br>

		<h5>foreach-Schleife</h5>
		<?php
			foreach( $wochentageArray AS $value ) {
				echo "$value ";
			}

			echo "<p>- - -</p>";

			foreach( $wochentageArray AS $key=>$value ) {
				echo "$key: $value ";
			}
		?>

		<br>
		<hr>
		<br>

		<h3>Assoziative Arrays</h5>
		<p>
			Assoziative Arrays sind Arrays, die als Index (Key) keine Nummerierung besitzen,
			sondern einen selbst definierten Schlüsselnamen.
		</p>

		<h4>Assoziatives Array deklarieren und initialisieren:</h4>
		<?php
			$buchArray = array("Autor"=>"Peter Patzig", "Titel"=>"Ich lass das jetzt so!", "Genre"=>"Ratgeber");
			echo "<pre>";
			print_r($buchArray);
			echo "</pre>";

			echo "<h4>Einen einzelnen Wert aus dem Array über dessen Key/Index auslesen (Autor):</h4>";
			echo $buchArray['Autor'];
		?>

		<br>
		<hr>
		<br>

		<h4>Einen Wert an ein assoziatives Array anhängen:</h4>
		<?php
			$buchArray['Erscheinungsjahr'] = 2006;
			echo "<pre>";
			print_r($buchArray);
			echo "</pre>";
		?>

		<br>
		<hr>
		<br>

		<h4>Einen bestehenden Wert innerhalb eines assoziativen Arrays überschreiben:</h4>
		<?php
			$buchArray['Genre'] = "Horror";
			echo "<pre>";
			print_r($buchArray);
			echo "</pre>";
		?>

		<br>
		<hr>
		<br>

		<h4>Einen bestehenden Wert aus einem assoziativen Array löschen:</h4>
		<?php
			unset($buchArray['Genre']);
			echo "<pre>";
			print_r($buchArray);
			echo "</pre>";
		?>

		<br>
		<hr>
		<br>

		<h4>Assoziatives Array mittels Schleife auslesen:</h4>
		<p>
			Assoziative Arrays werden immer mittels foreach-Schleife ausgelesen, da alle anderen Schleifen
			Zählschleifen sind - und da ein assoziatives Array keine numerischen Indexes besitzt, macht
			das Auslesen mittels Zählschleife hier keinen Sinn.
		</p>
		<?php
			foreach( $buchArray AS $key=>$value ) {
				echo "<b>$key:</b> <i>$value</i><br>";
			}
		?>

		<br>
		<hr>
		<br>

		<h3>Gemischte Arrays</h3>
		<p>
			Man kann ein Array auch sowohl mit assoziativen Indizes als auch mit numerischen Indizes
			befüllen (auch die Datentypen lassen sich wild mischen):
		</p>
		<?php
			$mixedArray = array("Name"=>"Ingmar", "Alter"=>21, "Mitarbeiter des Monats", true, "Preis"=>"100.000 Euro", 17=>18, 990);
			echo "<pre>";
			print_r($mixedArray);
			echo "</pre>";

			foreach( $mixedArray AS $key=>$value ) {
				echo "<b>$key:</b> <i>$value</i><br>";
			}
		?>

		<br>
		<hr>
		<br>

		<h3>Mehrdimensionale Arrays</h3>
		<p>
			Ein mehrdimensionales Array ist ein Array, das mindestens
			ein weiteres Array enthält.
		</p>

		<h4>Mehrdimensionales (zweidimensionales) Array definieren und befüllen:</h4>
		<?php
			$firma = array(
								"Vertrieb" 		=> array("Hugo", "Paul", "Lisa"),
								"Produktion" 	=> array("Klaus-Günther", "Frederike")
								);

			echo "<pre>";
			print_r($firma);
			echo "</pre>";
		?>

		<h4>Die inneren Arrays sind (wie bei jedem anderen Wert auch) über ihren Index aufrufbar:</h4>
		<p>Nur inneres Array [Vertrieb] anzeigen:</p>
		<?php
			echo "<pre>";
			print_r($firma['Vertrieb']);
			echo "</pre>";
		?>
		<p>Nur inneres Array [Produktion] anzeigen:</p>
		<?php
			echo "<pre>";
			print_r($firma['Produktion']);
			echo "</pre>";
		?>

		<p>- - -</p>

		<h4>Einen Wert an das innere Array [Produktion] anhängen:</h4>
		<?php
			$firma['Produktion'][] = "Naomi-Chantalle";
			echo "<pre>";
			print_r($firma);
			echo "</pre>";
		?>

		<h4>Einen einzelnen Wert des inneren Arrays auslesen (Frederike)</h4>
		<?php
			echo $firma['Vertrieb'][2];
		?>

		<br>
		<hr>
		<br>

		<h4>Mehrdimensionales Array mittels Schleife auslesen:</h4>
		<b>Abteilung:</b> Abteilungsname1<br>
		<i>Name1</i><br>
		<i>Name2</i><br>
		<i>Name3</i><br>
		<b>Abteilung:</b> Abteilungsname2<br>
		<i>Name1</i><br>
		<i>Name2</i><br>
		<i>Name3</i><br>

		<p>- - -</p>

		<?php
			echo "<pre>";
			print_r($firma);
			echo "</pre>";


			foreach( $firma AS $abteilung=>$mitarbeiterArray ) {
				// Je Schleifendurchlauf einen Index aus dem äußeren Array auslesen und im Frontend ausgeben
				echo "<b>Abteilung:</b> $abteilung<br>";

				// Je Schleifendurchlauf das jeweilige Array mit den Mitarbeiternamen durchlaufen
				foreach( $mitarbeiterArray AS $name ) {
					// Je Schleifendurchlauf einen Namen aus dem Array auslesen und im Frontend ausgeben
					echo "<i>$name</i><br>";
				}
				echo "<br>";
			}
		?>

		<br>
		<hr>
		<br>

		<h3>Array in String konvertieren und umgekehrt</h3>
		<p>
			Mittels der Funktion serialize() lässt sich ein Array in einen String umwandeln, um ihn
			beispielsweise in eine Datenbank zu speichern, ohne dass hierbei die ursprüngliche
			Arraystruktur verloren geht:
		</p>
		<?php
			$arrayString = serialize($mixedArray);
			echo "<p>$arrayString</p>";
		?>
		<p>
			Mittels der Funktion unserialize() lässt sich ein solcher Array-String wieder zurück in
			das ursprüngliche Array umwandeln (beispielsweise nach dem Auslesen aus der Datenbank):
		</p>
		<?php
			$mixedArrayReconverted = unserialize($arrayString);
			echo "<pre>";
			print_r($mixedArrayReconverted);
			echo "</pre>";
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
