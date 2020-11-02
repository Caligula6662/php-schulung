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
				require_once("include/functions.inc.php");


#**********************************************************************************#
?>

	<!doctype html>

		<html>
			<head>
				<meta charset="utf-8">
				<title>Eigene Funktionen | Documentation</title>
				
				<link rel="stylesheet" href="css/main.css">
				<link rel="stylesheet" href="css/pageElements.css">
				<link rel="stylesheet" href="css/debug.css">
			</head>
			
			<body>
				<?php require_once("include/pageElements/header.html"); ?>
				<h1>Eigene Funktionen | Documentation</h1>
				<p>
					In der Programmierung gibt es sich ständig wiederholende Aufgaben, 
					sei es eine Formularüberprüfung, eine mathematische Berechnung 
					oder auch eine spezielle Abfrage von Daten aus einer Datenbank. Damit man 
					diesen Code nicht jedes Mal neu schreiben muss, lagert man ihn 
					in eine Funktion aus, die dann von überall immer wieder aufrufbar ist.
				</p>
				
				<h3>Funktion definieren</h3>
				<p>
					<code>
					function Funktionsname(optional: zu übergebende Parameter) {<br>
					&nbsp;&nbsp;&nbsp;...code...<br>
					&nbsp;&nbsp;&nbsp;Optional: Rückgabewert<br>
					}
					</code>
				</p>
				
				<p>
					Der Code innerhalb einer Funktion ist "gekapselt", d.h. dass beispielsweise
					Variablen, die innerhalb einer Funktion definiert werden, außerhalb dieser
					Funktion nicht existieren und man demnach nicht von außen auf diese Variablen 
					zugreifen kann. Man nennt diese Variablen daher auch 'lokale' Variablen.<br>
					Eine lokale Variable wird aus dem Speicher gelöscht, sobald die Funktion,
					in der sie notiert ist, beendet wurde.<br>
					<br>
					Variablen, die außerhalb von Funktionen - also innerhalb des übrigen PHP-Codes - notiert sind, 
					nennt man auch 'globale' Variablen. Diese werden aus dem Speicher gelöscht, sobald das 
					PHP-Dokument in Gänze fertig abgearbeitet ist.<br>
					<br>
					Um einen lokalen Variablenwert aus einer Funktion nach außen zu übergeben, muss man 
					diesen Wert als sog. Rückgabewert nach außen reichen. Hierzu dient der Befehl
					"return".<br>
					<br>
					Umgekehrt müssen Variablenwerte von außerhalb an die Funktion übergeben 
					werden, damit sie innerhalb der Funktion verarbeitet werden können.
				</p>
				
				<h3>Rückgabewerte einer Funktion</h3>
				
				<p>
					Mittels <i>return</i> kann eine Funktionen an die aufrufende Stelle einen Wert zurückgeben. 
					Benötigt man mehrere Werte, die zurückgegeben werden sollen, muss man an dieser Stelle 
					ein Array zurückgeben und dieses dann von der aufrufenden Stelle weiterverarbeiten.
				</p>
				
				<br>
				<hr>
				<br>
<?php
#**********************************************************************************#


				#*******************************#
				#********** KAPSELUNG **********#
				#*******************************#
				
				
				$name = "Ingmar";
				
				
				#**********************************************************************#
				// Definition der Funktion
				function meineFunktion1() {
if(DEBUG_F)		echo "<p class='debug'><b>Line " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\r\n";	
					
					// Kapselung 1: Aus einer Funktion heraus kann nicht auf Variablen zugegriffen werden,
					// die außerhalb der Funktion definiert wurden
					echo $name;
					
					$age = 13;
										
				}
				#**********************************************************************#
				
				// Aufruf der Funktion
				meineFunktion1();

				// Kapselung 2: Außerhalb einer Funktion kann nicht auf Variablen zugegriffen werden,
				// die innerhalb der Funktion definiert wurden
				echo $age;
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";
				

#**********************************************************************************#


				#************************************************#
				#********** PARAMETER UND RÜCKGABEWERT **********#
				#************************************************#
				
				$name = "Ingmar";
				
				#**********************************************************************#
				// Um innerhalb der Funktion auf den Wert einer Variablen, die außerhalb
				// definiert wurde, zugreifen zu können, muss der Funktion bei ihrem Aufruf
				// der WERT der Variablen übergeben werden
				function meineFunktion2( $parameter ) {
if(DEBUG_F)		echo "<p class='debug'><b>Line " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\r\n";	
					
					echo $parameter;
					
					$age = 13;
					
					// Um außerhalb der Funktion auf eine Variable zugreifen zu können, die innerhalb
					// der Funktion definiert wurde, muss der WERT dieser Variablen von der Funktion
					// nach außen zurückgegeben werden
					return $age;
					
				}
				#**********************************************************************#
				
				// Um den Rückgabewert einer Funktion entgegenzunehmen, muss dieser
				// beim Aufruf der Funktion beispielsweise in eine Variable gespeichert werden
				$rueckgabewert = meineFunktion2( $name );
				
				echo "<p>$rueckgabewert</p>";
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";


#**********************************************************************************#


				#**********************************************#
				#********** PFLICHTPARAMETERÜBERGABE **********#
				#**********************************************#
				
				
				echo "<h4>Pflichtparameter</h4>";
				echo "<p>
							Eine Funktion kann beliebig viele Parameter erhalten. 
							Wichtig ist, dass diese Parameter in der Funktionsdefinition 
							vorhanden sind. Der Aufruf der Funktion muss dann mit allen 
							nötigen Parametern in der richtigen Reihenfolge erfolgen.
						</p>";
				
				#**********************************************************************#
				function meineFunktionMitParametern( $zahl1, $zahl2 ) {
if(DEBUG_F)		echo "<p class='debug'><b>Line " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "($zahl1, $zahl2) <i>(" . basename(__FILE__) . ")</i></p>\r\n";	
					
					$ergebnis = $zahl1 - $zahl2;
					
					return $ergebnis;
				}
				#**********************************************************************#
				
				echo "<p>" . meineFunktionMitParametern(10, 5) . "</p>";
				echo "<p>" . meineFunktionMitParametern(14, 7) . "</p>";
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";				
				

#**********************************************************************************#


				#*************************************************#
				#********** OPTIONALE PARAMETERÜBERGABE **********#
				#*************************************************#
				
				echo "<h4>Optionale Parameter</h4>";
				echo "<p>
							Man kann die Parameter einer Funktion auch mit Default-Werten 
							vorbelegen, so dass nicht zwingend alle Parameter übergeben 
							werden müssen. Man muss hier allerdings auf die Reihenfolge der 
							Parameter achten: Will man Werte an die Funktion übergeben, kann 
							man diese nur „von vorne nach hinten“ übergeben – man darf also 
							keinen Parameter am Anfang oder in der Mitte auslassen, sondern 
							darf lediglich die Parameter am Ende auslassen.
						</p>";
				
				#**********************************************************************#
				function meineFunktionMitOptionalenParametern( $zahl1, $zahl2=5 ) {
if(DEBUG_F)		echo "<p class='debug'><b>Line " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "($zahl1, $zahl2) <i>(" . basename(__FILE__) . ")</i></p>\r\n";	
				
					$ergebnis = $zahl1 - $zahl2;
						
					return $ergebnis;
										
				}
				#**********************************************************************#			
					
				echo "<p>" . meineFunktionMitOptionalenParametern( 10 ) . "</p>";
				echo "<p>" . meineFunktionMitOptionalenParametern( 17 ) . "</p>";
				echo "<p>" . meineFunktionMitOptionalenParametern( 10, 3 ) . "</p>";
					
				echo "<br>";
				echo "<hr>";
				echo "<br>";			


#**********************************************************************************#


				#***********************************************#
				#********** REIHENFOLGE DER PARAMETER **********#
				#***********************************************#
				
				
				#**********************************************************************#
				// Funktion ist ausgelagert nach 'include/functions.inc.php'
				#**********************************************************************#
				
				
				echo "<p>" . rechne1(5,"+",10) . "</p>";
				echo "<p>" . rechne1(5,"-",10) . "</p>";
				echo "<p>" . rechne1(10,"*",5) . "</p>";
				echo "<p>" . rechne1(5,"/",10) . "</p>";
				echo "<p>" . rechne1(5,10,"-") . "</p>";
				echo "<p>" . rechne1(5,"/",3) . "</p>";
					
				echo "<br>";
				echo "<hr>";
				echo "<br>";	
				

#**********************************************************************************#


				#******************************************************#
				#********** REIHENFOLGE OPTIONALER PARAMETER **********#
				#******************************************************#
				
				
				#**********************************************************************#
				// Funktion ist ausgelagert nach 'include/functions.inc.php'
				#**********************************************************************#
				
				
				echo "<p>" . rechne2() . "</p>";
				// 5-10
				echo "<p>" . rechne2(5,"-") . "</p>";
				// 3*7
				echo "<p>" . rechne2(3,"*",7) . "</p>";
				// 10/3
				echo "<p>" . rechne2(10,"/",3) . "</p>";
				// 2-10
				echo "<p>" . rechne2(2,"-") . "</p>";
				// 5+12
				echo "<p>" . rechne2(5,"+",12) . "</p>";

					
				echo "<br>";
				echo "<hr>";
				echo "<br>";	
				

#**********************************************************************************#


				#******************************************************************#
				#********** REIHENFOLGE PFLICHT- UND OPTIONALE PARAMETER **********#
				#******************************************************************#
				
				
				#**********************************************************************#
				// Funktion ist ausgelagert nach 'include/functions.inc.php'
				#**********************************************************************#
				
				// 5+10
				echo "<p>" . rechne3(5,10) . "</p>";
				// 7-3
				echo "<p>" . rechne3(7,3,"-") . "</p>";
				
					
				echo "<br>";
				echo "<hr>";
				echo "<br>";	
				

#**********************************************************************************#


				#*******************************************#
				#********** MEHRERE RÜCKGABEWERTE **********#
				#*******************************************#

				echo "<p>
							Eine Funktion, die einen Teilstring innerhalb eines Strings ersetzt und
							die Vorkommen des Teilstrings im String zählt.<br>
							Die Funktion soll zurückliefern: Den bearbeiteten String + Die Anzahl der
							Vorkommen.
						</p>";
				
				#**********************************************************************#
				// Funktion ist ausgelagert nach 'include/functions.inc.php'
				#**********************************************************************#
				

				$text 			= "Mein Haus ist ein tolles Haus und es ist blau und es ist ein neues Haus.";
				$needle			= "Haus";
				$replacement	= "Auto";
				
				
				$returnArray = suchenUndErsetzenUndZaehlen( $text, $needle, $replacement );
if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG)	print_r($returnArray);					
if(DEBUG)	echo "</pre>";	

				echo "<p>Anzahl der Vorkommen von '$needle' in '$text': $returnArray[anzahlDerErsetzungen]</p>";
				echo "<p>Der String nach der Ersetzung lautet: '$returnArray[ersetzterString]'</p>";
				
				echo "<br>";
				echo "<hr>";
				echo "<br>";
				

#**********************************************************************************#
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
				<?php require_once("include/pageElements/footer.php"); ?>
			</body>
		</html>