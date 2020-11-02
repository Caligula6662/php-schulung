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
				require_once("include/form.inc.php");


#**********************************************************************************#


				#******************************************#
				#********** INITIALIZE VARIABLES **********#
				#******************************************#
				
				$dbMessage 			= NULL;
				$messageCountSql 	= NULL;
				$messageCountPhp 	= NULL;


#**********************************************************************************#


				#***********************************#
				#********** DB CONNECTION **********#
				#***********************************#
				
				$pdo = dbConnect("market");


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
					$action = cleanString( $_GET['action'] );
if(DEBUG)		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$action: $action <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					
					// Schritt 3 URL: gem. der Parameterwerte verzweigen
					
					
					#********** INSERT **********#
					if( $action == "insert" ) {
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Verzweigung INSERT... <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						// Schritt 4 URL: Daten weiterverarbeiten
						// Werte aus fiktivem Formular:
						$name 			= "Thunfisch";
						$description 	= "Mit einem Delfinanteil von maximal 70%";
						$category 		= "Fisch";
						$price 			= "49.90";
						
						
						#********** DB OPERATION **********#
						// Schritt 1 DB: DB-Verbindung herstellen
						// ist bereits geschehen
						
						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare("
															INSERT INTO products
															(prod_name,prod_description,prod_category,prod_price)
															VALUES
															(:ph_prod_name,:ph_prod_description,:ph_prod_category,:ph_prod_price)
															");
						
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						$statement->execute( array(
															"ph_prod_name" 			=> $name,
															"ph_prod_description" 	=> $description,
															"ph_prod_category" 		=> $category,
															"ph_prod_price" 			=> $price
															) );
if(DEBUG)			if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														
						
						// Schritt 4 DB: Daten weiterverarbeiten
						// Bei schreibendem Zugiff: Schreiberfolg prüfen
						// Number of affected rows auslesen (Anzahl der von der DB-Operation betroffenen Datensätze)
						$rowCount = $statement->rowCount();
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						if( !$rowCount ) {
							// Fehlerfall
if(DEBUG)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER beim Speichern des Datensatzes in die DB! <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
							$dbMessage = "<h3 class='error'>FEHLER beim Speichern des Datensatzes in die DB!</h3>";
							
						} else {
							// Erfolgsfall
							
							// ID des neuen Datensatzes auslesen
							$lastInsertId = $pdo->lastInsertId();
							
if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Datensatz wurde erfolgreich unter ID$lastInsertId in die DB gespeichert. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
							$dbMessage = "<h3 class='success'>Datensatz erfolgreich in die DB gespeichert.</h3>";
						}
						
					
					#********** UPDATE **********#
					} elseif( $action == "update" ) {
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Verzweigung UPDATE... <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						// Schritt 4 URL: Daten weiterverarbeiten
						// Werte aus fiktivem Formular:
						$name				= "Thunfisch";
						$price 			= "29.90";
						
						
						#********** DB OPERATION **********#
						// Schritt 1 DB: DB-Verbindung herstellen
						// ist bereits geschehen
						
						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare("UPDATE products
																SET
																prod_price = :ph_prod_price
																WHERE
																prod_name = :ph_prod_name
															");
						
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						$statement->execute( array(
															"ph_prod_name" 			=> $name,
															"ph_prod_price" 			=> $price
															) );
if(DEBUG)			if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														
						
						// Schritt 4 DB: Daten weiterverarbeiten
						// Bei schreibendem Zugiff: Schreiberfolg prüfen
						// Number of affected rows auslesen (Anzahl der von der DB-Operation betroffenen Datensätze)
						$rowCount = $statement->rowCount();
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						if( !$rowCount ) {
							// "Fehlerfall"
if(DEBUG)				echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Es wurden keine Daten geändert. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
							$dbMessage = "<h3 class='info'>Es wurden keine Daten geändert.</h3>";
							
						} else {
							// Erfolgsfall
							
if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: $rowCount Datensätze erfolgreich in der DB geändert. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
							$dbMessage = "<h3 class='success'>$rowCount Datensätze erfolgreich in der DB geändert.</h3>";
						}
						
						
					#********** DELETE **********#	
					} elseif( $action == "delete" ) {
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Verzweigung DELETE... <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						// Schritt 4 URL: Daten weiterverarbeiten
						// Werte aus fiktivem Formular:
						$name				= "Thunfisch";
						
						
						#********** DB OPERATION **********#
						// Schritt 1 DB: DB-Verbindung herstellen
						// ist bereits geschehen
						
						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare("DELETE FROM products
																WHERE
																prod_name = :ph_prod_name
															");
						
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						$statement->execute( array(
															"ph_prod_name" 			=> $name
															) );
if(DEBUG)			if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														
						
						// Schritt 4 DB: Daten weiterverarbeiten
						// Bei schreibendem Zugiff: Schreiberfolg prüfen
						// Number of affected rows auslesen (Anzahl der von der DB-Operation betroffenen Datensätze)
						$rowCount = $statement->rowCount();
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						if( !$rowCount ) {
							// "Fehlerfall"
if(DEBUG)				echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Es wurden keine Daten gelöscht. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
							$dbMessage = "<h3 class='info'>Es wurden keine Daten gelöscht.</h3>";
							
						} else {
							// Erfolgsfall
							
if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: $rowCount Datensätze erfolgreich aus der DB gelöscht. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
							$dbMessage = "<h3 class='success'>$rowCount Datensätze erfolgreich aus der DB gelöscht.</h3>";
						}
						
					
					#********** COUNT SQL **********#
					} elseif( $action == "countSql" ) {	
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Verzweigung COUNT SQL... <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						// Schritt 4 URL: Daten weiterverarbeiten
						
						
						#********** DB OPERATION **********#
						// Schritt 1 DB: DB-Verbindung herstellen
						// ist bereits geschehen
						
						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare("SELECT COUNT(DISTINCT prod_category)
															FROM products
															");
						
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						$statement->execute();
if(DEBUG)			if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														
						
						// Schritt 4 DB: Daten weiterverarbeiten
						// Bei SELECT COUNT(): Rückgabewert von COUNT() über fetchColumn() auslesen
						$anzahl = $statement->fetchColumn();
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$anzahl: $anzahl <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						// Ergebnis der Zählung für Ausgabe im Frontend vorbereiten
						$messageCountSql = "<p class='info'>Es wurden $anzahl unterschiedliche Kategorien gefunden.</p>";
					

					#********** COUNT PHP **********#
					} elseif( $action == "countPhp" ) {
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Verzweigung COUNT PHP... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

						// Schritt 4 URL: Daten weiterverarbeiten
						
						
						#********** DB OPERATION **********#
						// Schritt 1 DB: DB-Verbindung herstellen
						// ist bereits geschehen
				
						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare("SELECT DISTINCT prod_category FROM products");
				
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						$statement->execute();
if(DEBUG)			if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";																	
								
						// Schritt 4 DB: Daten weiterverarbeiten
						// Beim Auslesen von Datensätzen: Gefundene Datensätze abholen
						$dataArrayCountPhp = $statement->fetchAll(PDO::FETCH_ASSOC);

/*						
if(DEBUG)			echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG)			print_r($dataArrayCountPhp);					
if(DEBUG)			echo "</pre>";
*/

						// Zählen, wieviele Datensätze gefunden wurden
						$anzahl = $statement->rowCount();
if(DEBUG)			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$anzahl: $anzahl <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						// Ergebnis der Zählung für Ausgabe im Frontend vorbereiten
						$messageCountPhp = "<p class='info'>Es wurden $anzahl unterschiedliche Kategorien gefunden.</p>";
					
					
					} // VERZWEIGUNG ENDE					
					
				} // PROCESS URL PARAMETERS END			


#**********************************************************************************#


				#****************************************#
				#********** FETCH DATA FROM DB **********#
				#****************************************#
				
				// Schritt 1 DB: DB-Verbindung herstellen
				// ist bereits geschehen
				
				// Schritt 2 DB: SQL-Statement vorbereiten
				$statement = $pdo->prepare("SELECT * FROM products");
				
				// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
				$statement->execute();
if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";																	
								
				// Schritt 4 DB: Daten weiterverarbeiten
				// Beim Auslesen von Datensätzen: Gefundene Datensätze abholen
				$resultArray = $statement->fetchAll(PDO::FETCH_ASSOC);

/*
if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG)	print_r($resultArray);					
if(DEBUG)	echo "</pre>";
*/

#**********************************************************************************#
?>

<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>DB-Operationen mit Prepared Statements</title>
		
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/pageElements.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>
	
	<body>
		<h1>DB-Operationen mit Prepared Statements</h1>
		
		<br>
		<hr>
		<br>
		
		<?= $dbMessage ?>
		
		<br>
		<hr>
		<br>
		
		<p><a href="08_db_operationen_mit_prepared_statements.php">Seitenaufruf ohne Parameter</a></p>
		
		<br>
		<hr>
		<br>
		
		<p><a href="?action=insert">Einen neuen Datensatz anlegen (INSERT)</a></p>
		
		<br>
		<hr>
		<br>
		
		<p><a href="?action=update">Einen bestehenden Datensatz ändern (UPDATE)</a></p>
		
		<br>
		<hr>
		<br>
		
		<p><a href="?action=delete">Einen bestehenden Datensatz löschen (DELETE)</a></p>
		
		<br>
		<hr>
		<br>
				
		<h3>Bestehende Datensätze zählen mit SQL (COUNT())</h3>
		<p>
			In SQL wird mittels des Konstrukts COUNT() gezählt, wieviele Einträge in einer Tabelle 
			von einer SQL-Abfrage betroffen sind.<br>
			<br>
			Vorteil dieser Methode: Die Einträge werden tatsächlich nur gezählt. Es werden keine 
			weiteren Daten übertragen, was sich positiv auf die Performanz auswirkt.<br>
			Nachteil dieser Methode: Sollen die betroffenen Datensätze doch noch verarbeitet werden, 
			muss eine zweite SQL-Abfrage an die DB gesandt werden.
		</p>
		<p><a href="?action=countSql">Datensätze zählen mit SQL</a></p>
		
		<?php echo $messageCountSql ?>
		
		<br>
		<hr>
		<br>
		
		<h3>Bestehende Datensätze zählen mit PHP (rowCount())</h3>
		<p>
			In PHP wird bei Einsatz von Prepared Statements mittels des Konstrukts $statement->rowCount() gezählt, wieviele 
			Datensätze von der SQL-Abfrage zurückgeliefert wurden.<br>
			<br>
			Vorteil dieser Methode: Neben der Anzahl der gelieferten Datensätze stehen auch die Datensätze selbst zur 
			Weiterverarbeitung zur Verfügung.<br>
			Nachteil dieser Methode: Es werden alle betroffenen Datensätze tatsächlich aus der DB gelesen und übertragen, was
			für das reine Zählen wenig performant ist.
		</p>
		<p><a href="?action=countPhp">Datensätze zählen mit PHP</a></p>
		
		<?php echo $messageCountPhp ?>
		
		<?php if( isset($dataArrayCountPhp) ): ?>
		<h4>Unterschiedliche Kategorien in der Datenbank:</h4>
		<ol>
			<!--
				$dataArrayCountPhp enthält ein zweidimensionales Array. Jedes darin 
				enthaltene Array entspricht einem Datensatz aus der DB.
				Je Schleifendurchlauf enthält $category einen anderen Datensatz in Form 
				eines eindimensionalen Arrays, dessen Indizes den Namen der Spalten in 
				der Tabelle 'products' entsprechen.
			-->
			<?php foreach( $dataArrayCountPhp AS $category ): ?>
			<li><?php echo $category['prod_category'] ?></li>
			<?php endforeach ?>
		</ol>
		<?php endif ?>
		
		<br>
		<hr>
		<br>
		
		<table>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Beschreibung</th>
				<th>Kategorie</th>
				<th>Preis</th>
			</tr>
			<?php foreach( $resultArray AS $product ): ?>
			<tr>	
				<td><?= $product['prod_id'] ?></td>
				<td><?= $product['prod_name'] ?></td>
				<td><?= $product['prod_description'] ?></td>
				<td><?= $product['prod_category'] ?></td>
				<td><?= $product['prod_price'] ?>&nbsp;€</td>
			</tr>	
			<?php	endforeach ?>
		</table>
		
		<br>
		<hr>
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
		<br>
		
	</body>
</html>