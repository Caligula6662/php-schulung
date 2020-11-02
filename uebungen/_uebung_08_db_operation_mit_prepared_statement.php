<?php

	//region 1 Imports, Initialisierungen, Konstanten, Variablen


	//region 1.1 Imports
	require_once("../include/form.inc.php");
	require_once("../include/config.inc.php");
	require_once("../include/db.inc.php");
	//endregion


	//region 1.2 Initialisierungen
	$pdo = dbConnect("buechersammlung");
	//endregion


	//region 1.3 Konstanten
	//endregion


	//region 1.4 Variablen
	$author 		= NULL;
	$title 			= NULL;
	$price 			= NULL;
	$year 			= $currentYear = date("Y");
	$mediaTypes 	= array("Hardcover", "Paperback", "Foliant", "Hörbuch");
	$errorMsgFields = NULL;
	//endregion


	//endregion



	//region 2 Daten verarbeiten

	if( isset( $_POST['formsent'] ) ) {

		//region 2.1 Formulardaten vorbereiten

		$author 	= cleanString($_POST['author']);
		$title 		= cleanString($_POST['title']);
		$price 		= cleanString($_POST['price']);
		$price 		= doubleval(str_replace(',', '.', str_replace('.', '', $price)));
		$year 		= cleanString($_POST['year']);
		$media 		= cleanString($_POST['mediatypes']);

		//endregion

		//region 2.2 Daten in Datenbank speichern

		//Strings checken

		$errorAuthor = (checkInputString($author));
		$errorTitle = (checkInputString($title));
		$errorPrice = (checkInputString($price));

		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorAuthor: $errorAuthor <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorTitle: $errorTitle <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorPrice: $errorPrice <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		//Finale Prüfung und Schreiben in Datenbank auslösen
		if (!$errorAuthor AND !$errorTitle AND !$errorPrice) {
			//Speichern vorbereiten
			$statement = $pdo->prepare("
				INSERT INTO werke (
						werke_author,
						werke_title,
						werke_release,
						werke_mediatype,
						werke_price
					)
				VALUES (
						:ph_werke_author,
						:ph_werke_title,
						:ph_werke_release,
						:ph_werke_mediatype,
						:ph_werke_price
			)
		");
			//Speichern ausführen
			$statement->execute( array(
				"ph_werke_author" 		=> $author,
				"ph_werke_title" 		=> $title,
				"ph_werke_release" 		=> $year,
				"ph_werke_mediatype"	=> $media,
				"ph_werke_price" 		=> $price
			) );
		} else {
			$errorMsgFields = "Bitte alle Felder ausfüllen";
		}


		//endregion

	}


	//endregion

?>


<!doctype html>

<html lang="de">
<head>
	<meta charset="utf-8">
	<title>Default</title>

	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/pageElements.css">
	<link rel="stylesheet" href="../css/debug.css">
</head>

<body>
	<h1>Bücherverwaltung</h1>

	<form action="" method="POST">


		<input type="hidden" name="formsent">
		<?php if ($errorMsgFields !== NULL) { echo "<p class='error'>$errorMsgFields</p>"; } ?>

		<div>
			<label for="title">Titel</label><br>
			<input <?php if($errorTitle) echo "class='bg-error'" ?> type="text" placeholder="Titel" name="title">
		</div>
		<div>
			<label for="author">Autor</label><br>
			<input <?php if($errorAuthor) echo "class='bg-error'" ?> type="text" placeholder="Autor" name="author">
		</div>
		<div>
			<label for="price">Preis</label><br>
			<input <?php if($errorPrice) echo "class='bg-error'" ?> type="text" placeholder="Preis" name="price">
		</div>

		<div>
			<label for="mediatypes">Medientyp auswählen</label><br>
			<select name="mediatypes">
				<?php foreach ($mediaTypes AS $type): ?>
					<option value="<?php echo $type ?>" <?php if($type == "Hardcover") "selected" ?> ><?php echo $type ?></option>
				<?php	endforeach ?>
			</select>
		</div>

		<div>
			<label for="year">Erscheinungsjahr auswählen</label><br>
			<select name="year">
				<?php

					for( $i=$year; $i>=$year-110; $i-- ) {
						if( $year == $i ) {
							echo "<option value='$i' selected>$i</option>";
						} else {
							echo "<option value='$i'>$i</option>";
						}
					}
				?>
			</select>
		</div>
		<div>
			<label>Absenden</label><br>
			<input type="submit" value="Absenden">
		</div>

	</form>

</body>
</html>
