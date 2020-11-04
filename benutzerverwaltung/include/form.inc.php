<?php
#**********************************************************************************#


				/**
				*
				*	Entschärft und säubert einen String, falls er einen Wert besitzt
				*	Falls der String keinen Wert besitzt (NULL, "", 0, false) wird er 
				*	1:1 zurückgegeben
				*
				*	@param String $value - Der zu entschärfende und zu bereinigende String
				*
				*	@return String 		- Originalwert oder der entschärfte und bereinigte String
				*
				*/
				function cleanString($value) {
if(DEBUG_F)		echo "<p class='debugCleanString'><b>Line " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "('$value') <i>(" . basename(__FILE__) . ")</i></p>\r\n";	
					
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
					if( $value === "" ) {
						$value = NULL;
					}

					return $value;
				}


#**********************************************************************************#


				/**
				*
				*	Prüft einen String auf Leerstring, Mindest- und Maxmimallänge
				*
				*	@param String $value 									- Der zu prüfende String
				*	@param [Integer $minLength=INPUT_MIN_LENGTH] 	- Die erforderliche Mindestlänge
				*	@param [Integer $maxLength=INPUT_MAX_LENGTH] 	- Die erlaubte Maximallänge
				*
				*	@return String/NULL - Ein String bei Fehler, ansonsten NULL
				*	
				*/
				function checkInputString($value, $minLength=INPUT_MIN_LENGTH, $maxLength=INPUT_MAX_LENGTH) {
if(DEBUG_F)		echo "<p class='debugCheckInputString'><b>Line " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "('$value' [$minLength | $maxLength]) <i>(" . basename(__FILE__) . ")</i></p>\r\n";	
					
					// Prüfen auf leeres Feld
					/*
						WICHTIG: Die Prüfung auf Leerfeld muss zwingend den Datentyp Sting mitprüfen,
						da ansonsten bei einer Eingabe 0 (z.B. Anzahl der im Haushalt lebenden Kinder: 0)
						die 0 als false und somit als leeres Feld gewertet wird!
					*/
					if( $value === "" OR $value === NULL ) {
						$errorMessage = "Dies ist ein Pflichtfeld!";
					
					// Prüfen auf Mindestlänge
					} elseif( mb_strlen($value) < $minLength ) {	
						$errorMessage = "Muss mindestens $minLength Zeichen lang sein!";
					
					// Prüfen auf Maximallänge
					} elseif( mb_strlen($value) > $maxLength ) {
						$errorMessage = "Darf maximal $maxLength Zeichen lang sein!";
						
					} else {
						$errorMessage = NULL;
					}
					
					return $errorMessage;
					
				}


#**********************************************************************************#


				/**
				*
				*	Prüft eine Email-Adresse auf Leerstring und Validität
				*
				*	@param String $value - Die zu prüfende Email-Adresse
				*
				*	@return String/NULL - Ein String bei Fehler, ansonsten NULL
				*
				*/
				function checkEmail($value) {
if(DEBUG_F)		echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: Aufruf checkEmail('$value') <i>(" . basename(__FILE__) . ")</i></p>\r\n";	

					$errorMessage = NULL;
					
					// Prüfen auf Leerstring
					/*
						WICHTIG: Die Prüfung auf Leerfeld muss zwingend den Datentyp Sting mitprüfen,
						da ansonsten bei einer Eingabe 0 (z.B. Anzahl der im Haushalt lebenden Kinder: 0)
						die 0 als false und somit als leeres Feld gewertet wird!
					*/
					if( $value === "" OR $value === NULL ) {
						$errorMessage = "Dies ist ein Pflichtfeld!";

					// Email auf Validität prüfen
					} elseif( !filter_var($value, FILTER_VALIDATE_EMAIL) ) {
						$errorMessage = "Dies ist keine gültige Email-Adresse!";
					}
				
					return $errorMessage;
					
				}


#**********************************************************************************#
?>