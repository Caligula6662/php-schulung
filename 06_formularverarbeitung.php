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
				require_once("include/form.inc.php");


#**********************************************************************************#


				#******************************************#
				#********** INITIALIZE VARIABLES **********#
				#******************************************#
				
				$monthsArray 		= array("01"=>"Januar", "02"=>"Februar", "03"=>"März", "04"=>"April", "05"=>"Mai", "06"=>"Juni", "07"=>"Juli", "08"=>"August", "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Dezember");
/*
if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG)	print_r($monthsArray);					
if(DEBUG)	echo "</pre>";
*/

				$title	 			= NULL;
				$gender	 			= NULL;
				$firstname 			= NULL;
				$lastname 			= NULL;
				$email 				= NULL;
				$message			= NULL;
				$agb				= NULL;
				$errorFirstname 	= NULL;
				$errorLastname 		= NULL;
				$errorEmail 		= NULL;
				$errorMessage 		= NULL;
				$successMessage 	= NULL;


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
				if( isset( $_POST['formsent'] ) ) {
if(DEBUG)		echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Formular 'Dingsbums' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
					
					// Schritt 2 FORM: Daten auslesen, entschärfen, DEBUG-Ausgabe
if(DEBUG)		echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Werte werden ausgelesen und entschärft... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					$title 		= cleanString($_POST['title']);
					$gender 		= cleanString($_POST['gender']);
					$firstname 	= cleanString($_POST['firstname']);
					$lastname 	= cleanString($_POST['lastname']);
					$email 		= cleanString($_POST['email']);
					$day 			= cleanString($_POST['day']);
					$month 		= cleanString($_POST['month']);
					$year 		= cleanString($_POST['year']);
					$message 	= cleanString($_POST['message']);
					// SonderfallCheckboxen: Wurde eine Checkbox nicht aktiviert, überträgt sie auch 
					// keinen Index in das $_POST-Array 
					if( isset($_POST['agb']) ) {
						$agb 		= cleanString($_POST['agb']);
					} else {
						$agb		= "nicht gelesen";
					}				
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$title: $title <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$gender: $gender <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$firstname: $firstname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$lastname: $lastname <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$email: $email <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$day: $day <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$month: $month <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$year: $year <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$message: $message <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$agb: $agb <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					
					// Schritt 3 FORM: optional: Felder validieren
if(DEBUG)		echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Felder werden validiert... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					$errorFirstname 	= checkInputString($firstname);
					$errorLastname 	= checkInputString($lastname);
					$errorEmail 		= checkEmail($email);
					$errorMessage 		= checkInputString($message, 10, 5000);
					
					#********** FINAL FORM VALIDATION **********#
if(DEBUG)		echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Formular wird geprüft... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					// WICHTIG: Ist das Formular insgesamt fehlerfrei?
					if( $errorFirstname OR $errorLastname OR $errorEmail OR $errorMessage ) {
						// Fehlerfall
if(DEBUG)			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
						
					} else {
						// Erfolgsfall
if(DEBUG)			echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist fehlerfrei und wird nun verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
						
						// Schritt 4 FORM: Daten weiterverarbeiten
						$successMessage 	= "Hallo <i><b>$title $firstname $lastname</b></i>,<br>
														vielen Dank, wir haben Ihre Daten erhalten.<br>
														<br>
														Nachfolgend noch einmal Ihre Angaben zur Kontrolle:<br>
														<br>
														Ihr Geschlecht ist <i><b>$gender</b></i>.<br>
														Ihr Geburtsdatum ist der <i><b>$day.$month.$year</b></i>.<br>
														Ihre Email-Adresse lautet <i><b>$email</b></i>.<br>";
						
						$successMessage	.=	"Unsere AGBs haben Sie <i>$agb</i>.<br>";
						
						$successMessage 	.= "Ihre Nachricht an uns:<br>
														<i><b>$message</b></i>";
					}

				} // PROCESS FORM END
				
				
#**********************************************************************************#
?>

<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Default</title>
		
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/pageElements.css">
		<link rel="stylesheet" href="css/debug.css">
		
		<style>
			* { margin: 0; padding: 0; }
			body { padding: 50px; font-family: arial; font-size: 12px; background-color: #eee}
			h1, h2 { margin: 10px; 50px; }
			h2 { color: green; }
			p { font-size: 1.1em; }
			
			input, textarea, select, label { margin: 10px; padding: 3px; width: 300px; border-radius: 5px; }
			label { font-size: 1.1em; }
			select { width: 235px; }
			select#day { width: 70px; }
			select#month { width: 115px; }
			select#year { width: 80px; }
			input[type="radio"], input[type="checkbox"] { width: 20px; margin: 10px 6px; }
			input[type="submit"] { width: 310px }
			textarea { float: left; font-size: 1.1em;}
			
			.marker { font-size: 1.6em; font-weight: bold;}
			.clearer { clear: both; }
			/* Den Placeholder-Font selbst bestimmen: */
			::-webkit-input-placeholder { font-family: verdana; }
			:-moz-placeholder { font-family: verdana; }
			::-moz-placeholder { font-family: verdana; }
			:-ms-input-placeholder { font-family: verdana; }
		</style>
	</head>
	
	<body>
		<h1>Formularverarbeitung</h1>
		
		<br>
		<hr>
		<br>
		<!-------------------- SUCCESS MESSAGE -------------------->
		<h4><?php echo $successMessage ?></h4>
		<br>
		<hr>
		<br>
	
		<!-------------------- FORMULAR START -------------------->
		<form action="" method="POST">
			
			<!---------- HIDDEN FIELD ----------> 
			<input type="hidden" name="formsent">
			
			<!---------- SELECTBOX ---------->
			<label>Anrede:</label>
			<select name="title">
				<option value="Herr" <?php if($title=="Herr") echo "selected" ?>>Herr</option>
				<option value="Frau" <?php if($title=="Frau") echo "selected" ?>>Frau</option>
				<option value="Sonstiges" <?php if($title=="Sonstiges") echo "selected" ?>>Sonstiges</option>
			</select>
			
			<br>
			<br>
			<br>
			
			<!---------- RADIOBUTTONS ---------->
			<label>Geschlecht:</label>
			<input type="radio" name="gender" value="männlich" <?php if($gender === NULL OR $gender=="männlich") echo "checked" ?>>männlich
			<input type="radio" name="gender" value="weiblich" <?php if($gender=="weiblich") echo "checked" ?>>weiblich
			<input type="radio" name="gender" value="Sonstiges" <?php if($gender=="Sonstiges") echo "checked" ?>>sonstiges
			
			<br>
			<br>
			
			<!---------- INPUTFIELDS ---------->
			<span class="error"><?php echo $errorFirstname ?></span><br>
			<input type="text" name="firstname" value="<?php echo $firstname ?>" placeholder="Vorname"><span class="marker">*</span>
			<br>
			<br>
			<span class="error"><?php echo $errorLastname ?></span><br>
			<input type="text" name="lastname" value="<?php echo $lastname ?>" placeholder="Nachname"><span class="marker">*</span>
			<br>
			<br>
			<span class="error"><?php echo $errorEmail ?></span><br>
			<input type="text" name="email" value="<?php echo $email ?>" placeholder="Email"><span class="marker">*</span>
			<br>
			<br>		
			
			<!---------- SELECTBOXES BIRTHDATE START ---------->
			<label>Geburtsdatum:</label><br>
			<select id="day" name="day">
				<?php
					for( $i=1; $i<=31; $i++ ) {
						// $i mit führender 0 auffüllen
						// sprintf() gibt einen vorformatierten String zurück
						// Erster Parameter:
						// % = Steuerzeichen (hier soll aufgefüllt werden); 0 = Zeichen, mit dem aufgefüllt werden soll
						// 2 = Anzahl der Zeichen, bis zu der aufgefüllt werden soll
						// d = Wert aus Parameter 2 wird als Integer angesehen und als Dezimalwert ausgegeben
						// Zweiter Parameter:
						// String, der umformatiert werden soll
						$i=sprintf("%02d", $i);
						if( $day == $i ) {
							echo "\t\t\t\t<option value='$i' selected>$i</option>\n";
						} else {
							echo "\t\t\t\t<option value='$i'>$i</option>\n";
						}	
					}
				?>
			</select>
			
			<select id="month" name="month">
				<?php
					foreach( $monthsArray AS $key=>$value ) {
						if( $month == $key ) {
							echo "\t\t\t\t<option value='$key' selected>$value</option>\n";
						} else {
							echo "\t\t\t\t<option value='$key'>$value</option>\n";
						}						
					}
				?>
			</select>
			
			<select id="year" name="year">
				<?php
					// das aktuelle Jahr mittles der date()-Funktion ermitteln
					$currentYear = date("Y");
					for( $i=$currentYear; $i>=$currentYear-110; $i-- ) {
						if( $year == $i ) {
							echo "\t\t\t\t<option value='$i' selected>$i</option>\n";
						} else {
							echo "\t\t\t\t<option value='$i'>$i</option>\n";
						}						
					}
				?>
			</select>
			<!---------- SELECTBOXES BIRTHDATE END ---------->
			
			<br>
			<br>
			
			<!---------- TEXTAREA ---------->
			<span class="error"><?php echo $errorMessage ?></span><br>
			<textarea class="fleft" name="message" placeholder="Ihre Nachricht an uns..."><?php echo $message ?></textarea><span class="marker">*</span>
			<div class="clearer"></div>
			<br>
			
			<!---------- CHECKBOX ---------->
			<input type="checkbox" name="agb" value="gelesen" <?php if($agb == "gelesen") echo "checked" ?>>AGB gelesen
			
			<br>
			<br>
			
			<!---------- SUBMIT BUTTON ---------->
			<input type="submit" value="Absenden">
		
		</form>
		<!-------------------- FORMULAR END -------------------->
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
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