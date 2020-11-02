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
				<title>Schreiben in mehrere Tabellen</title>
				
				<link rel="stylesheet" href="css/main.css">
				<link rel="stylesheet" href="css/pageElements.css">
				<link rel="stylesheet" href="css/debug.css">
			</head>
			
			<body>
				<h1>Schreiben in mehrere Tabellen</h1>
				<p>Einen neuen User mit einem neuen Account anlegen</p>
				<?php
					// Userdaten
					$firstname 	= "Paul";
					$lastname 	= "Paulsen";
					$email 		= "pa@pa.de";
					$city 		= "Pforzheim";
					
					// Accountdaten
					$accountname = "paule007";
					$password 	= "1234";
					
					/*
					echo "<p>" . md5($password) . "</p>";
					echo "<p>" . sha1($password) . "</p>";
					echo "<p>" . password_hash($password, PASSWORD_DEFAULT) . "</p>";
					*/
					$passwordHash = password_hash($password, PASSWORD_DEFAULT);
					
					
					#********** DB OPERATION **********#
					
					// Schritt 1 DB: DB-Verbindung herstellen
					$pdo = dbConnect("miniforum");
					
					
					#********** 1. USERDATENSATZ ANLEGEN **********#
if(DEBUG)		echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Userdatensatz wird gespeichert... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("INSERT INTO users
														(usr_firstname,usr_lastname,usr_email,usr_city)
														VALUES
														(:ph_usr_firstname,:ph_usr_lastname,:ph_usr_email,:ph_usr_city)
														");
					
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					$statement->execute( array(
														"ph_usr_firstname" 	=> $firstname,
														"ph_usr_lastname" 	=> $lastname,
														"ph_usr_email" 		=> $email,
														"ph_usr_city" 			=> $city
														) );
if(DEBUG)		if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														
			
					// Schritt 4 DB: Daten weiterverarbeiten
					// Bei schreibendem Zugriff: Schreiberfolg prüfen
					$rowCount = $statement->rowCount();
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					if( !$rowCount ) {
						// Fehlerfall
if(DEBUG)			echo "<p class='debug err'>FEHLER beim Speichern des neuen Users!</p>\r\n";
						$dbMessage = "<h3 class='error'>Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.</h3>";
						
					} else {
						// Erfolgsfall
						
						// Last Insert ID auslesen
						$lastInsertId = $pdo->lastInsertId();
if(DEBUG)			echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Userdatensatz erfolgreich unter ID$lastInsertId gespeichert. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
						
						
						#********** 2. ACCOUNTDATENSATZ ANLEGEN **********#
if(DEBUG)			echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Accountdatensatz wird gespeichert... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare("INSERT INTO accounts
															(acc_name,acc_password,usr_id)
															VALUES
															(:ph_acc_name,:ph_acc_password,:ph_usr_id)
															");
						
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						$statement->execute( array(
															"ph_acc_name" => $accountname,
															"ph_acc_password" => $passwordHash,
															"ph_usr_id" => $lastInsertId
															) );
if(DEBUG)			if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														
			
						// Schritt 4 DB: Daten weiterverarbeiten
						// Bei schreibendem Zugriff: Schreiberfolg prüfen
						$rowCount = $statement->rowCount();
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\r\n";

						if( !$rowCount ) {
							// Fehlerfall
if(DEBUG)				echo "<p class='debug err'>FEHLER beim Speichern des neuen Accounts!</p>\r\n";
							$dbMessage = "<h3 class='error'>Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.</h3>";
							
							
							#********** DB BEREINIGEN **********#
							// Verwaisten USER-DATENSATZ löschen
if(DEBUG)				echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: DB wird bereinigt... <i>(" . basename(__FILE__) . ")</i></p>\r\n";
							
							// Schritt 2 DB: SQL-Statement vorbereiten
							$statement = $pdo->prepare("DELETE FROM users
																WHERE usr_id = :ph_usr_id");
							
							// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
							$statement->execute( array(
																"ph_usr_id" => $lastInsertId
																) );
if(DEBUG)				if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														
						
							// Schritt 4 DB: Daten weiterverarbeiten
							// Bei schreibendem Vorgang: Schreiberfolg prüfen
							$rowCount = $statement->rowCount();
if(DEBUG)				echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\r\n";

							if( !$rowCount ) {
								// Fehlerfall
if(DEBUG)					echo "<p class='debug err'>FEHLER beim Löschen des Userdatensatz mit der ID$lastInsertId!</p>\r\n";
								
								// TODO:
								// 1. Fehlermeldung in error.log schreiben
								// 2. Email an Systemadministrator senden
								
							} else {
								// Erfolgsfall
if(DEBUG)					echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Userdatensatz mit der ID$lastInsertId erfolgreich gelöscht. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
																		
							}
							#**************************************************#
							
							
						} else {
							// Erfolgsfall
						
							// Last Insert ID auslesen
							$lastInsertId = $pdo->lastInsertId();
if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Accountdatensatz erfolgreich unter ID$lastInsertId gespeichert. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
						
							$dbMessage = "<h3 class='success'>Vielen Dank, Sie wurden erfolgreich registriert.</h3>";
							
						} // 2. ACCOUNTDATENSATZ ANLEGEN ENDE

					} // 1. USERDATENSATZ ANLEGEN ENDE
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