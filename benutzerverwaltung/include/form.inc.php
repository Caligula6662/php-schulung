<?php
#**********************************************************************************#

	/**
	 *
	 *    Entschärft und säubert einen String, falls er einen Wert besitzt
	 *    Falls der String keinen Wert besitzt (NULL, "", 0, false) wird er
	 *    1:1 zurückgegeben
	 *
	 * @param String $value - Der zu entschärfende und zu bereinigende String
	 *
	 * @return String        - Originalwert oder der entschärfte und bereinigte String
	 *
	 */
	function cleanString($value)
	{
		if (DEBUG_F) echo "<p class='debugCleanString'><b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value') <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// htmlspecialchars() wandelt potentiell gefährliche Steuerzeichen wie
		// < > "" & in HTML-Code um (&lt; &gt; &quot; &amp;)
		// Der Parameter ENT_QUOTES wandelt zusätzlich einfache '' in &apos; um
		// Der Parameter ENT_HTML5 sorgt dafür, dass der generierte HTML-Code HTML5-konform ist
		// Der optionale Parameter 'false' steuert, dass bereits vorhandene HTL-Entities nicht
		// noch einmal codiert werden (&auml; => &amp;auml;)
		$value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5);

		// trim() entfernt am Anfang und am Ende eines Strings alle
		// sog. Whitespaces (Leerzeichen, Tabulatoren, Zeilenumbrüche)
		$value = trim($value);

		// Damit cleanString() nicht NULL-Werte in Leerstings verändert, wird
		// ein evetueller Leerstring in $value mit NULL überschrieben
		if ($value === "") {
			$value = NULL;
		}

		return $value;
	}


#**********************************************************************************#


	/**
	 *
	 *    Prüft einen String auf Leerstring, Mindest- und Maxmimallänge
	 *
	 * @param String $value - Der zu prüfende String
	 * @param [Integer $minLength=INPUT_MIN_LENGTH]    - Die erforderliche Mindestlänge
	 * @param [Integer $maxLength=INPUT_MAX_LENGTH]    - Die erlaubte Maximallänge
	 *
	 * @return String/NULL - Ein String bei Fehler, ansonsten NULL
	 *
	 */
	function checkInputString($value, $minLength = INPUT_MIN_LENGTH, $maxLength = INPUT_MAX_LENGTH)
	{
		if (DEBUG_F) echo "<p class='debugCheckInputString'><b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value' [$minLength | $maxLength]) <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Prüfen auf leeres Feld
		/*
			WICHTIG: Die Prüfung auf Leerfeld muss zwingend den Datentyp Sting mitprüfen,
			da ansonsten bei einer Eingabe 0 (z.B. Anzahl der im Haushalt lebenden Kinder: 0)
			die 0 als false und somit als leeres Feld gewertet wird!
		*/
		if ($value === "" or $value === NULL) {
			$errorMessage = "Dies ist ein Pflichtfeld!";

			// Prüfen auf Mindestlänge
		} elseif (mb_strlen($value) < $minLength) {
			$errorMessage = "Muss mindestens $minLength Zeichen lang sein!";

			// Prüfen auf Maximallänge
		} elseif (mb_strlen($value) > $maxLength) {
			$errorMessage = "Darf maximal $maxLength Zeichen lang sein!";

		} else {
			$errorMessage = NULL;
		}

		return $errorMessage;

	}


#**********************************************************************************#


	/**
	 *
	 *    Prüft eine Email-Adresse auf Leerstring und Validität
	 *
	 * @param String $value - Die zu prüfende Email-Adresse
	 *
	 * @return String/NULL - Ein String bei Fehler, ansonsten NULL
	 *
	 */
	function checkEmail($value)
	{
		if (DEBUG_F) echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: Aufruf checkEmail('$value') <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$errorMessage = NULL;

		// Prüfen auf Leerstring
		/*
			WICHTIG: Die Prüfung auf Leerfeld muss zwingend den Datentyp Sting mitprüfen,
			da ansonsten bei einer Eingabe 0 (z.B. Anzahl der im Haushalt lebenden Kinder: 0)
			die 0 als false und somit als leeres Feld gewertet wird!
		*/
		if ($value === "" or $value === NULL) {
			$errorMessage = "Dies ist ein Pflichtfeld!";

			// Email auf Validität prüfen
		} elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$errorMessage = "Dies ist keine gültige Email-Adresse!";
		}

		return $errorMessage;

	}


#**********************************************************************************#


	/**
	 * @param $uploadedImage
	 * @param int $imageMaxHeight
	 * @param int $imageMaxWidth
	 * @param int $imageMaxSize
	 * @param string $uploadPath
	 * @param string[] $allowedMimeTypes
	 * @return array
	 */

	function imageUpload( 	$uploadedImage,
							$imageMaxHeight=IMAGE_MAX_HEIGHT,
							$imageMaxWidth=IMAGE_MAX_WIDTH,
							$imageMaxSize=IMAGE_MAX_SIZE,
							$uploadPath=IMAGE_UPLOAD_PATH,
							$allowedMimeTypes = IMAGE_ALLOWED_MIMETYPES
	)
	{

		if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: Aufruf imageUpload('') <i>(" . basename(__FILE__) . ")</i></p>\r\n";

//		if(DEBUG)	echo "<pre class='debugImageUpload'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//		if(DEBUG)	print_r($uploadedImage);
//		if(DEBUG)	echo "</pre>";

		/*
			Das Array $_FILES['avatar'] bzw. $uploadedImage enthält:
			Den Dateinamen [name]
			Den generierten (also ungeprüften) MIME-Type [type]
			Den temporären Pfad auf dem Server [tmp_name]
			Die Dateigröße in Bytes [size]
		*/


		// Bildinformationen sammeln

		$fileName = cleanString($uploadedImage["name"]);
		$fileSize = $uploadedImage["size"];
		$fileTmp = $uploadedImage["tmp_name"];



		//Dateinamen von Sonderzeichen befreien

		// Leerzeichen entfernen
		$fileName = str_replace(" ", "_", $fileName);

		// in Kleinbuchstaben umwandeln
		$fileName = mb_strtolower($fileName);

		// Umlaute ersetzen
		$fileName = str_replace( array("ä", "ö", "ü", "ß"), array("ae", "oe", "ue", "ss"), $fileName );

		// Dateiendung kopieren und entfernen
		$startpositionDateiEndung = strrpos($fileName, ".");
		$dateiendungsKopie = substr($fileName, $startpositionDateiEndung);
		$fileName = str_replace($dateiendungsKopie, "", $fileName);

		// RegEx
		$fileName = preg_replace('/[^a-z0-9_-]/', "", $fileName);
		$fileName .= $dateiendungsKopie;

		// Prefix erzeugen, verhindert doppelte Dateinamen
		$randomPrefix = rand(1,999999) . str_shuffle("abcdef") . time();
		$fileTarget = $uploadPath . $randomPrefix . "_" . $fileName;

		if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$fileName: $fileName <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$fileSize: ". round($fileSize / 1024, 2) ." kB <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$fileTmp: $fileTmp <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$fileTarget: $fileTarget <i>(" . basename(__FILE__) . ")</i></p>\r\n";



		$imageDataArray = getimagesize($fileTmp);

		if(DEBUG)	echo "<pre class='debugImageUpload'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
		if(DEBUG)	print_r($imageDataArray);
		if(DEBUG)	echo "</pre>";

		/*
			Die Funktion getimagesize() liefert bei gültigen Bildern ein Array zurück:
			Die Bildbreite in PX [0]
			Die Bildhöhe in PX [1]
			Einen für die HTML-Ausgabe vorbereiteten String für das IMG-Tag
			(width="480" height="532") [3]
			Die Anzahl der Bits pro Kanal ['bits']
			Die Anzahl der Farbkanäle (somit auch das Farbmodell: RGB=3, CMYK=4) ['channels']
			Den echten(!) MIME-Type ['mime']
		*/

		$imageWidth = $imageDataArray[0];
		$imageHeight = $imageDataArray[1];
		$imageMimeType = $imageDataArray['mime'];

		if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$imageWidth: $imageWidth px <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$imageHeight: $imageHeight px <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$imageMimeType: $imageMimeType <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Validate Image

		// MIME TYPE prüfen
		// Whitelist für Bildtypen

		//$allowedMimeTypes = array( "image/jpeg", "image/jpg", "image/gif", "image/png" );

		if( !in_array($imageMimeType, $allowedMimeTypes) ) {
			// Fehler
			$errorMessage = "Dies ist kein erlaubter Bildtyp!";
		} elseif ( $imageHeight > $imageMaxHeight ) {
			// maximale Bildhöhe
			$errorMessage = "Die Bildhöhe darf maximal $imageMaxHeight px betragen!";
		} elseif ( $imageWidth > $imageMaxWidth ) {
			// maximale Bildbreite
			$errorMessage = "Die Bildbreite darf maximal $imageMaxWidth px betragen!";
		} elseif ( $fileSize > $imageMaxSize * 1024 ) {
			// maximale Dateigröße
			$errorMessage = "Die Dateigröße darf maximal" . round($imageMaxSize / 1024, 2) ."kb betragen!";
		} else {
			$errorMessage = NULL;
		}


		if ( $errorMessage ) {
			// Fehler
			if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$errorMessage: $errorMessage <i>(" . basename(__FILE__) . ")</i></p>\r\n";
			$fileTarget = NULL;
		} else {
			// Erfolg
			if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: Die Bildprüfung ergab keine Fehler. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Bild speichern

			if( !move_uploaded_file( $fileTmp, $fileTarget ) ) {
				// Fehler
				if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: Fehler beim verschieben des Bildes von $fileTmp nach $fileTarget. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				$fileTarget = NULL;
			} else {
				// Erfolg
				if (DEBUG_F) echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: Bild erfolgreich von $fileTmp nach $fileTarget verschoben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
			}
		}

		return array("imagePath"=>$fileTarget, "imageError"=>$errorMessage);

	}

?>