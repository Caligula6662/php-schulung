<?php
/********************************************************************************************/
//region 1 Variablen

				/****************************************************************************/
				/********** IN DIESEM DOKUMENT VERWENDETE VARIABLEN INITIALISIEREN **********/
				/****************************************************************************/
				
				$variable 			= "Variable";
				$bedingung1 		= "Bedingung 1";
				$bedingung2 		= "Bedingung 2";
				$parameter 			= "Parameter";
				$array				= array("Key1"=>"Value1", "Key2"=>"Value2", "Key3"=>"Value3", "Key4"=>"Value4");
				$hiddenFieldName 	= "formsentLogin";
				$urlParameter 		= "tuIrgendwas";

//endregion
/********************************************************************************************/
//region 2 Konstanten

				/***************************************************************/
				/********** KONSTANTEN ZUR DEBUG-STEUERUNG DEFINIEREN **********/
				/***************************************************************/
				
				define("DEBUG", 	true);	// Debugging für Hauptdokument ein-/ausschalten
				define("DEBUG_F", true);	// Debugging für Funktionen ein-/ausschalten
				define("DEBUG_C", true);	// Debugging für Klassen ein-/ausschalten

//endregion
/********************************************************************************************/
//region 3 einfache Ausgaben

				/********************************************/
				/********** EINFACHE DEBUGAUSGABEN **********/
				/********************************************/

				echo "<p>Einfache Ereignismeldung:</p>";
if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Ereignis XY. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				echo "<p>Variablenwert ausgeben:</p>";
if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$variable: $variable <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				
				echo "<p>Ein Vorgang wird gestartet:</p>";
if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Formulardaten werden verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";

//endregion
/********************************************************************************************/
//region 4 Erfolgs- und Fehlermeldungen

				/********************************************/
				/********** ERFOLGS-/FEHLERMELDUNG **********/
				/********************************************/

				echo "<p>Debug-Ausgabe als Fehlermeldung:</p>";
if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: Inhalt der Fehlermeldung! <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
		
				echo "<p>Debug-Ausgabe als Erfolgsmeldung:</p>";
if(DEBUG)	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Inhalt der Erfolgsmeldung. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				

				echo "<br>";
				echo "<hr>";
				echo "<br>";
				
//endregion
/********************************************************************************************/
//region 5 Arrays und Objekte
				
				/*************************************************/
				/********** ARRAYS UND OBJEKTE AUSGEBEN **********/
				/*************************************************/
				
				echo "<p>Den Inhalt eines Arrays oder Objekts ausgeben:</p>\r\n";
if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG)	print_r($array);					
if(DEBUG)	echo "</pre>";

				echo "<br>";
				echo "<hr>";
				echo "<br>";

//endregion
/********************************************************************************************/
//region 6 Verzweigungen anzeigen

				/********************************************/
				/********** VERZWEIGUNGEN ANZEIGEN **********/
				/********************************************/
				
				echo "<p>Debug-Ausgaben innerhalb von Verzweigungen:</p>";
				if( $bedingung1 ) {
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Bedingung 1 wird ausgeführt... <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					
				} elseif( $bedingung2 ) {
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Bedingung 2 wird ausgeführt... <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
				
				} else {
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Bedingungen wurden nicht erfüllt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";									
				}
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";

//endregion
/********************************************************************************************/
//region 7 Funktionen

				/********************************/
				/********** FUNKTIONEN **********/
				/********************************/
				
				function testfunktion($parameter) {
if(DEBUG_F)		echo "<p class='debug'><b>Line " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "($parameter) <i>(" . basename(__FILE__) . ")</i></p>\r\n";	

				}
				

/********************************************************************************************/


				echo "<p>Debug-Ausgabe für Funktionsauf:</p>";
				testfunktion("Testwert");
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";

//endregion
/********************************************************************************************/
//region 8 Klassen

				/*****************************/
				/********** KLASSEN **********/
				/*****************************/
				
				class Testklasse {
					
					private $attribute1;
					private $attribute2;
					private $attribute3;
					
					
					/*************************************************************************/
					
					public function getAttribute1() {
						return $this->attribute1;
					}
					public function setAttribute1($value) {
						$this->attribute1 = $value;
					}
					public function getAttribute2() {
						return $this->attribute2;
					}
					public function setAttribute2($value) {
						$this->attribute2 = $value;
					}
					public function getAttribute3() {
						return $this->attribute3;
					}
					public function setAttribute3($value) {
						$this->attribute3 = $value;
					}
					
					
					/*************************************************************************/
					

					/********** KONSTRUKTOR **********/
					public function __construct($value1, $value2, $value3="Wert 3") {
if(DEBUG_C)			echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "()  (<i>" . basename(__FILE__) . "</i>)</h3>\r\n";						

						$this->setAttribute1($value1);
						$this->setAttribute2($value2);
						$this->setAttribute3($value3);
						
if(DEBUG_C)			echo "<pre class='debugClass'><b>Line " . __LINE__ .  "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG_C)			print_r($this);					
if(DEBUG_C)			echo "</pre>";	
					}
					

					/*************************************************************************/
					

					/********** METHODEN **********/
					public function methodenname($parameter) {
if(DEBUG_C)			echo "<h3 class='debugClass'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\r\n";
						
					}
					

					/*************************************************************************/
					
				}
				
				
/********************************************************************************************/


				echo "<p>Debug-Ausgabe für Objekterstellung:</p>";
				$object = new Testklasse("Wert 1", "Wert 2");
				
				echo "<p>Debug-Ausgabe für Methodenaufruf:</p>";
				$object->methodenname("Wert 1");
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";
				
//endregion
/********************************************************************************************/
//region 9 URL Parameterverarbeitung

				/***********************************************/
				/********** URL-PARAMETERVERARBEITUNG **********/
				/***********************************************/
				
				echo "<p>Debug-Ausgabe für URL-Parameterverarbeitung:</p>";
				if(isset($urlParameter)) {
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: URL-Parameter 'Parametername' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
					
				}
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";

//endregion
/********************************************************************************************/
//region 10 Formularverarbeitung

				/******************************************/
				/********** FORMULARVERARBEITUNG **********/
				/******************************************/
				
				echo "<p>Debug-Ausgabe für Formularverarbeitung:</p>";
				if(isset($hiddenFieldName)) {
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Formular 'Hiddenfieldname' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
					
				}
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";
				
//endregion
/********************************************************************************************/
//region 11 Statement->Execute Error Ausgabe für SQL Abfragen mit PDO

				/*************************************************************/
				/********** DEBUG-AUSGABE FÜR $statement->execute() **********/
				/*************************************************************/
				
				echo '<p>Debug-Ausgabe für $pdo->execute():</p>';
if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														
				// oder mit Ternärem Operator:
if(DEBUG)	echo $statement->errorInfo()[2] ? "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n" : NULL;														

//endregion
/********************************************************************************************/

?>