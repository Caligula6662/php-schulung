<?php
	require_once("include/config.inc.php");
	require_once("include/db.inc.php");
?>

<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Datenbankverbindung mit PDO in PHP</title>

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/pageElements.css">
	<link rel="stylesheet" href="css/debug.css">
</head>

<body>
	<h1>Datenbankverbindung mit PDO in PHP</h1>
	<p>
		In PHP existieren drei Varianten, um auf eine MySQL Datenbank zuzugreifen. Die älteste nutzt die MySQL Erweiterung,
		die aber seit PHP 5.5.0 als veraltet (deprecated) markiert wurde und in der nachfolgenden PHP Version entfernt wurde.
		Die zweite Möglichkeit ist mittels der MySQL Improved Extension (MySQLi), und die letzte Möglichkeit ist mittels
		PHP Data Objects (PDO).<br>
		<br>
		PDO ist dabei das aktuellste Interface, um auf Datenbank zuzugreifen, und besitzt gegenüber MySQLi einige neue nette
		Funktionen und den großen Vorteil, dass es auch mit anderen Datenbanksystemen als MySQL zusammenarbeiten kann.
		Das heißt, dass man, sollte man einmal auf ein anderes Datenbanksystem wechseln müssen, kaum etwas am PHP-Code
		verändern muss.
	</p>

	<p>
		Eine PHP-Datenbankabfrage - egal ob lesend oder schreibend - läuft immer
		nach dem gleichen Schema ab:
	</p>
	<ul>
		<li>Schritt 1: Mit der Datenbank verbinden</li>
		<li>Schritt 2: SQL-Statement vorbereiten</li>
		<li>Schritt 3: SQL-Statement ausführen und ggf. Platzhalter füllen</li>
		<li>Schritt 4: Daten weiterverarbeiten</li>
	</ul>

	<br>
	<hr>
	<br>

	<h3>Schritt 1 DB: Mit der Datenbank verbinden</h3>
	<code>$pdo = dbConnect("market")</code>
	<?php
		// Aufruf der Funktion dbConnect() und speichern des zurückgelieferten PDO-Objekts
		// (Datenbankverbindung)
		$pdo = dbConnect("market");
	?>

	<h3>Schritt 2 DB: SQL Statement vorbereiten</h3>
	<code>$statement = $pdo->prepare("SQL-Statement")</code>
	<?php
		// Hier findet sozusagen der 'Handshake' zwischen Statement-Objekt und Datenbank statt
		$statement = $pdo->prepare("SELECT * FROM products");
	?>

	<h3>Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen</h3>
	<code>$statement->execute();</code>
	<?php
		// Die SQL-Abfrage ist in der übermittelten Form 'genehmigt' und kann nun ausgeführt werden
		$statement->execute();
if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";
	?>

	<h3>Schritt 4 DB: Daten weiterverarbeiten</h3>
	<p>
		<code>$statement->fetchAll()</code> liest in einem Rutsch alle Datensätze aus der Datenbank
		und schreibt das Ergebnis (ein zweidimensionales Array, das alle Datensätze in Form von
		einzelnen Arrays enthält) in die Variable <code>$resultArray</code>.
		$resultArray enthält also je Datensatz ein Array, dessen Indizes den Namen der Tabellenspalten
		entsprechen.
	</p>

	<?php
		// Der fetchAll()-Parameter PDO::FETCH_ASSOC liefert o.g. assoziatives Array zurück.
		// Der fetchAll()-Parameter PDO::FETCH_NUM liefert das gleiche Array als numerisches Array zurück.
		$resultArray = $statement->fetchAll(PDO::FETCH_ASSOC);
		if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
		if(DEBUG)	print_r($resultArray);
		if(DEBUG)	echo "</pre>";
	?>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Beschreibung</th>
				<th>Kategorie</th>
				<th>Preis</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $resultArray AS $product ): ?>
				<!--
					$resultArray enthält ein zweidimensionales Array. Jedes darin
					enthaltene Array entspricht einem Datensatz aus der DB.
					Je Schleifendurchlauf enthält $product einen anderen Datensatz in Form
					eines eindimensionalen Arrays, dessen Indizes den Namen der Spalten in
					der Tabelle 'products' entsprechen.
				-->
				<tr>
					<td><?= $product['prod_id'] ?></td>
					<td><?= $product['prod_name'] ?></td>
					<td><?= $product['prod_description'] ?></td>
					<td><?= $product['prod_category'] ?></td>
					<td><?= $product['prod_price'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<br>
	<hr>
	<br>

	<h2>Noch eine Datenbankoperation - diesmal mit Platzhaltern</h2>

	<?php
		// HACK: $filter = "Obst' OR 1=1";
		$filter = "Obst";

		// Schrit 1 DB: Verbindung herstellen
		// ist bereits geschehen

		// Schritt 2 DB: SQL-Statement vorbereiten
		$statement = $pdo->prepare("SELECT * FROM products WHERE prod_category = :ph_filter");

		// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter auffüllen
		$statement->execute( array( "ph_filter" => $filter ) );
if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		// Schritt 4 DB: Daten weiterverarbeiten
		// Der fetchAll()-Parameter PDO::FETCH_ASSOC liefert o.g. assoziatives Array zurück.
		// Der fetchAll()-Parameter PDO::FETCH_NUM liefert das gleiche Array als numerisches Array zurück.
		$resultArray = $statement->fetchAll(PDO::FETCH_ASSOC);
//		if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//		if(DEBUG)	print_r($resultArray);
//		if(DEBUG)	echo "</pre>";

	?>

	<h4>Ausgabe der Ergebnisse im Frontend:</h4>

	<table>
		<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Beschreibung</th>
			<th>Kategorie</th>
			<th>Preis</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $resultArray AS $product ): ?>
			<!--
				$resultArray enthält ein zweidimensionales Array. Jedes darin
				enthaltene Array entspricht einem Datensatz aus der DB.
				Je Schleifendurchlauf enthält $product einen anderen Datensatz in Form
				eines eindimensionalen Arrays, dessen Indizes den Namen der Spalten in
				der Tabelle 'products' entsprechen.
			-->
			<tr>
				<td><?= $product['prod_id'] ?></td>
				<td><?= $product['prod_name'] ?></td>
				<td><?= $product['prod_description'] ?></td>
				<td><?= $product['prod_category'] ?></td>
				<td><?= $product['prod_price'] ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<br>
	<hr>
	<br>


</body>
</html>