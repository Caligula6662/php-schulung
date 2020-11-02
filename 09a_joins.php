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
				require_once("include/dateTime.inc.php");


#**********************************************************************************#
?>

		<!doctype html>

		<html>
			<head>
				<meta charset="utf-8">
				<title>JOINs - Oder die Kunst, mehrere Tabellen abzufragen</title>
				
				<link rel="stylesheet" href="css/main.css">
				<link rel="stylesheet" href="css/pageElements.css">
				<link rel="stylesheet" href="css/debug.css">
			</head>
			
			<body>
				<h1>JOINs - Oder die Kunst, mehrere Tabellen abzufragen</h1>
				<p>
					Ausgangssituation: Es gibt 3 Tabellen in der Datenbank "miniforum"
					(users, accounts, postings). Diese Tabellen sind über einen
					Fremdschlüssel wie in einer Eimerkette miteinander verbunden:<br>
					<br>
					postings -> accounts -> users<br>
					<br>
					Als Fremdschlüssel dienen die jeweiligen IDs der in den Tabellen 
					enthaltenen Datensätze:
				</p>
				<ul>
					<li>Die Datensätze in der Tabelle postings enthalten als Fremdschlüssel 
					jeweils die ID desjenigen Accounts, der das Posting verfasst hat.</li>
					<li>Die Datensätze in der Tabelle Accounts enthalten als Fremdschlüssel 
					die ID desjenigen Users, zu dem der Account gehört.</li>
				</ul>
		
				<h2>Inhalte der einzelnen Tabellen anzeigen</h2>
				<?php
					// Schritt 1 DB: DB-Verbindung herstellen
					$pdo = dbConnect("miniforum");
				?>
				
				<br>
				<hr>
				<br>
		
				<h4>Tabelle Users:</h4>
				<?php
					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("SELECT * FROM users");
					
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					$statement->execute();
if(DEBUG)		if($statement->errorInfo()[2]) echo "<p class='debug err'>" . $statement->errorInfo()[2] . "</p>";
					
					// Schritt 4 DB: Daten weiterverarbeiten
					$userDataArray = $statement->fetchAll(PDO::FETCH_ASSOC);
				?>
				<table>
					<tr>
						<th>usr_id</th>
						<th>usr_firstname</th>
						<th>usr_lastname</th>
						<th>usr_email</th>
						<th>usr_city</th>
						<th>usr_registerdate</th>
					</tr>
					
					<?php foreach( $userDataArray AS $userData ): ?>
						<tr>
							<td><?php echo $userData['usr_id'] ?></td>
							<td><?php echo $userData['usr_firstname'] ?></td>
							<td><?php echo $userData['usr_lastname'] ?></td>
							<td><?php echo $userData['usr_email'] ?></td>
							<td><?php echo $userData['usr_city'] ?></td>
							<td><?php echo $userData['usr_registerdate'] ?></td>
						</tr>
					<?php endforeach ?>
					
				</table>
				
				<br>
				<hr>
				<br>
			
				<h4>Tabelle Accounts:</h4>
				<?php
					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("SELECT * FROM accounts");
					
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					$statement->execute();
if(DEBUG)		if($statement->errorInfo()[2]) echo "<p class='debug err'>" . $statement->errorInfo()[2] . "</p>";
					
					// Schritt 4 DB: Daten weiterverarbeiten
					$accountDataArray = $statement->fetchAll(PDO::FETCH_ASSOC);
				?>
				<table>
					<tr>
						<th>acc_id</th>
						<th>acc_name</th>
						<th>acc_password</th>
						<th>usr_id</th>
					</tr>
					
					<?php foreach( $accountDataArray AS $accountData ): ?>
						<tr>
							<td><?php echo $accountData['acc_id'] ?></td>
							<td><?php echo $accountData['acc_name'] ?></td>
							<td><?php echo $accountData['acc_password'] ?></td>
							<td><?php echo $accountData['usr_id'] ?></td>
						</tr>
					<?php endforeach ?>
					
				</table>
				
				<br>
				<hr>
				<br>
			
				<h4>Tabelle Postings:</h4>
				<?php
					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("SELECT * FROM postings");
					
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					$statement->execute();
if(DEBUG)		if($statement->errorInfo()[2]) echo "<p class='debug err'>" . $statement->errorInfo()[2] . "</p>";
					
					// Schritt 4 DB: Daten weiterverarbeiten
					$postingDataArray = $statement->fetchAll(PDO::FETCH_ASSOC);
				?>
				<p>So würden die Postings aussehen, wenn wir nur auf die Tabelle 'postings' zugreifen würden:</p>
				<?php foreach( $postingDataArray AS $postingData ): ?>
					<article>
						<b><?php echo $postingData['acc_id'] ?></b> aus schrieb am <?php echo $postingData['pos_date'] ?>:<br>
						<i><?php echo $postingData['pos_content'] ?></i>
						<hr>
					</article>
				<?php endforeach ?>
				
				<br>
				<hr>
				<br>
			
				<h2>Anmerkung zur Abfrage über mehrere Tabellen mittels JOINs:</h2>
				<p>
					Bei einem JOIN muss im SQL-Statement immer auch die Verbindung der beteiligten
					Tabellen definiert werden, also über welche Spalten die Tabellen miteinander verbunden sind
					(Primary Key Tabelle1 -> Foreign Key Tabelle2).<br>
					Lauten die Spaltennamen für Primary Key aus Tabelle1 und Foreign Key aus Tabelle2 gleich (z.B. 'usr_id'),
					kann das einfache Konstrukt <code>USING(usr_id)</code> verwendet werden.<br>
					Lauten die Spaltennamen hingegen unterschiedlich (z.B. 'usr_id' in Tabelle1 und 'acc_usr_id' in Tabelle2), 
					so muss stattdessen explizit übermittelt werden, welcher der Spaltennamen zu welcher Tabelle gehört:
					<code>ON tabelle1.usr_id = tabelle2.acc_usr_id</code>.			
				</p>
				<p>
					Das Gleiche gilt auch dann, wenn die Tabellenspalten ohne Präfix benannt wurden, und es dadurch
					dazu kommt, dass in unterschiedlichen Tabellen identische Spaltennamen vorhanden sind (z.B. 'date' oder 'name').<br>
					Damit die Datenbank weiß, welcher Wert aus welcher Tabelle in welchen Index des Ergebnisarrays
					geschrieben werden soll, muss hier von Hand ein Alias für den jeweils zu verwendenden Ergebnis-Index angelegt werden:
					<code>SELECT usr_id, users.name AS userName, users.date AS userRegisterdate, 
					acc_id, accounts.name AS accountName, accounts.date AS accountLastOnlineDate FROM users<br>
					INNER JOIN accounts ON users.usr_id = accounts.acc_usr_id</code><br>
					Der Wert für 'name' aus der Tabelle users würde nun im Ergebnisarray unter dem Index 'userName'
					zu finden sein, der Wert für 'name' aus der Tabelle accounts hingegen unter dem Index 'accountName'.<br>
					<br>
					Im Vergleich fällt auf, dass es die Arbeit deutlich erleichtert und den Code deutlich übersichlicher macht, 
					wenn man prinzipiell Präfixes für die Tabellenspalten verwendet und die Primary- und Foreign Keys stets gleich 
					lauten:<br>
					<code>SELECT usr_id, usr_name, usr_date, acc_id, acc_name, acc_date FROM users<br>
					INNER JOIN accounts USING(usr_id)</code>
				</p>
				
				<br>
				<hr>
				<br>
			
				<h2>INNER JOIN</h2>
				<p>
					INNER JOIN liefert alle Datensätze, die in den beteiligten Tabellen eine 
					gemeinsame Schnittmenge haben.
				</p>
				<h4>Zeige alle Accounts, die Postings verfasst haben PLUS die zugehörigen Postings</h4>	
				<?php
					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("SELECT acc_name, pos_content, pos_date
														FROM accounts INNER JOIN postings USING(acc_id)");
					
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhaler füllen
					$statement->execute();
if(DEBUG)		if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";																	
								
					// Schritt 4 DB: Daten weiterverarbeiten
					// Bei lesendem Zugriff: Datensätze abholen
					$dataArray = $statement->fetchAll(PDO::FETCH_ASSOC);
					
if(DEBUG)		echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG)		print_r($dataArray);					
if(DEBUG)		echo "</pre>";
				?>
			
				<p>So sehen die Postings aus, wenn wir mittels INNER JOIN auf die Tabellen 'postings' und 'accounts' zugreifen:</p>
				<?php foreach( $dataArray AS $dataSet ): ?>
					<article>
						<b><?php echo $dataSet['acc_name'] ?></b> aus schrieb am <?php echo $dataSet['pos_date'] ?>:<br>
						<i><?php echo $dataSet['pos_content'] ?></i>
						<hr>
					</article>
				<?php endforeach ?>
				
				<br>
				<hr>
				<br>
			
				<h2>LEFT-/RIGHT JOIN</h2>
				<p>
					LEFT-/RIGHT JOIN liefert sämtliche Datensätze aus einer Tabelle, zuzüglich diejenigen Datensätze 
					aus einer weiteren Tabelle, die mit der ersten Tabelle eine gemeinsame Schnittmenge haben.
				</p>
				<p>Zeige <u>alle</u> Accountnamen PLUS ggf. die von ihnen verfassten Postings:</p>
		
				<?php
					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("SELECT acc_name, pos_content, pos_date
														FROM accounts LEFT JOIN postings USING(acc_id)");
					
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhaler füllen
					$statement->execute();
if(DEBUG)		if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";																	
								
					// Schritt 4 DB: Daten weiterverarbeiten
					// Bei lesendem Zugriff: Datensätze abholen
					$dataArray = $statement->fetchAll(PDO::FETCH_ASSOC);
					
if(DEBUG)		echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
if(DEBUG)		print_r($dataArray);					
if(DEBUG)		echo "</pre>";
				?>
				<p>Die gleiche Ausgabe noch einmal, diesmal allerdings mit LEFT JOIN:</p>
				<?php foreach( $dataArray AS $dataSet ): ?>
					<article>
						<b><?php echo $dataSet['acc_name'] ?></b> aus schrieb am <?php echo $dataSet['pos_date'] ?>:<br>
						<i><?php echo $dataSet['pos_content'] ?></i>
						<hr>
					</article>
				<?php endforeach ?>
				
				<br>
				<hr>
				<br>
			
				<h2>INNER JOIN über 3 Tabellen:</h2>
				<?php
					// Schritt 2 DB: SQL-Statement vorbereiten
					$statement = $pdo->prepare("SELECT acc_name, pos_content, pos_date, usr_city
														FROM accounts INNER JOIN postings USING(acc_id)
														INNER JOIN users USING(usr_id)");
														
					// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
					$statement->execute();
if(DEBUG)		if($statement->errorInfo()[2]) echo "<p class='debug err'>" . $statement->errorInfo()[2] . "</p>";					
				
					// Schritt 4 DB: Daten weiterverarbeiten
					$dataArray = $statement->fetchAll(PDO::FETCH_ASSOC);
				?>
				<p>Nun die Ausgabe bei Abfrage aller 3 Tabellen:</p>
				<?php foreach( $dataArray AS $dataSet ): ?>
				<?php $dateTime = isoToEuDateTime($dataSet['pos_date']) ?>
					<article>
						<b><?php echo $dataSet['acc_name'] ?></b> aus <?php echo $dataSet['usr_city'] ?> schrieb am <?php echo $dateTime['date'] ?> um <?php echo $dateTime['time'] ?> Uhr:<br>
						<i><?php echo $dataSet['pos_content'] ?></i>
						<hr>
					</article>
				<?php endforeach ?>
				
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