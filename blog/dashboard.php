<?php


	#**************************************#
	#********** CONTINUE SESSION **********#
	#**************************************#

	// Session fortführen
	session_name("blog");
	session_start();

	// Secure Page

	if (!isset($_SESSION["usr_id"])) {
		session_destroy();
		header("Location: index.php");
		exit;
	}



	#************************************************#
	#************* Includes und Imports *************#
	#************************************************#

	require_once("include/config.inc.php");
	require_once("include/form.inc.php");
	require_once("include/db.inc.php");



	#***********************************************************#
	#************* Variablen und Initialisierungen *************#
	#***********************************************************#

	// Datenbank
	$pdo = dbConnect();
	$dbMessage = NULL;

	// Kategorie anlegen
	$usrMsgCategory = NULL;
	$categories = NULL;
	$categoriesArray = NULL;

	// BlogPost verfassen
	$cat_id = 1;
	$blog_headline = NULL;
	$blog_imagePath = NULL;
	$blog_imageAlignment = 1;
	$blog_content = NULL;

	$errorCat_id = NULL;
	$errorBlog_headline = NULL;
	$errorBlog_content = NULL;
	$errorBlog_imageAlignment = NULL;
	$errorBlog_image = NULL;



	#****************************#
	#********** Logout **********#
	#****************************#

	// Prüfe, dass der Parameter Action in der URL vorhanden ist
	if (isset($_GET['action'])) {

		if (DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: URL-Parameter 'action' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$action = cleanString($_GET['action']);
		// Prüfe, dass der Parameter den Wert Logout enthält und führe dann Logout aus.
		if ($action == "logout") {
			if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Logout wird durchgeführt... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			session_destroy();
			header("Location: index.php");
			exit;

		} // ENDE Prüfe, dass der Parameter den Wert Logout enthält und führe dann Logout aus.

	} // ENDE Prüfe, dass der Parameter Action in der URL vorhanden ist



	#***************************************#
	#********** Kategorie anlegen **********#
	#***************************************#

	// Prüfe, dass das Formular für eine neue Kategorie abgesendet wurde
	if (isset($_POST["addCategory"])) {

		if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular für eine neue Kategorie wurde abgesendet. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$category = cleanString($_POST["cat_name"]);
		if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$category: $category <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$usrMsgCategory = checkInputString($category);
		//$usrMsgCategory = "<span class='error'>" . $usrMsgCategory . "</span>";

		if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorCategory: $usrMsgCategory <i>(" . basename(__FILE__) . ")</i></p>\r\n";


		// Finale Prüfung des Eingabefeldes Kategorie
		if ( $usrMsgCategory ) {
			// Fehler
			if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Der Input für die Kategorie entspricht nicht den Vorgaben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		} else {
			// Erfolg
			if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Der Input für die Kategorie entspricht Vorgaben. Weiterverbeitung beginnt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			#************************************************#
			#********** Kategorie in DB überprüfen **********#
			#************************************************#

			$statement = $pdo->prepare("SELECT COUNT(cat_name) FROM categories WHERE cat_name = :ph_cat_name");
			$statement->execute(array("ph_cat_name"=> $category));
			if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			$existCategory = $statement->fetchColumn();

			if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$existCategory: $existCategory <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Finale Prüfung der Existenz der Kategorie
			if ( $existCategory ) {
				// Fehler
				if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Die Kategorie ist bereits vorhanden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				$usrMsgCategory = "<span class='error'>Die Kategorie ist bereits vorhanden.</span>";

			} else {
				// Erfolg

				if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Kategorie kann in der Datenbank angelegt werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				#*********************************************#
				#********** Kategorie in DB anlegen **********#
				#*********************************************#

				$statement = $pdo->prepare("INSERT INTO categories (cat_name) VALUES (:ph_cat_name)");
				$statement->execute(array("ph_cat_name"=>$category));

				if(DEBUG)	if($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				$rowCount = $statement->rowCount();
				if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>\$rowCount: $rowCount<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				// User über das Anlegen der Kategorie in der DB informieren
				if( !$rowCount ) {
					// Fehler

					if(DEBUG)	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>Fehler beim Speichern der Kategorie in die Datenbank<i>(" . basename(__FILE__) . ")</i></p>\r\n";
					$usrMsgCategory = "<span class='error'>Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.</span>";

				} else {
					// Erfolg

					if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Kategorie wurde erfolgreich in der Datenbank angelegt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					$usrMsgCategory = "<span class='success'>Die Kategorie <b>$category</b> wurde erfolgreich in der Datenbank angelegt.</span>";

				} // User über das Anlegen der Kategorie in der DB informieren

			} // ENDEFinale Prüfung der Existenz der Kategorie

		} // ENDE Finale Prüfung des Eingabefeldes Kategorie

	} // ENDE Prüfe, dass das Formular für eine neue Kategorie abgesendet wurde



	#****************************************************#
	#********** Vorhandene Kategorien ausgeben **********#
	#****************************************************#

	$categoriesArray = readTableFromDb("categories");



	#********************************************************#
	#********** Blogbeitrag auslesen und speichern **********#
	#********************************************************#

	// Überprüfe dass PostArray für den BlogPost
	if ( isset($_POST["addBlogPost"]) ) {

		if (DEBUG) echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
		if (DEBUG) print_r($_POST);
		if (DEBUG) echo "</pre>";

		if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Der Post-Array <b>addBlog</b> wurde gefunden und die Verarbeitung kann beginnen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$cat_id = cleanString($_POST["cat_id"]);
		$blog_headline = cleanString($_POST["blog_headline"]);
		$blog_imageAlignment = cleanString($_POST["blog_imageAlignment"]);
		$blog_content = cleanString($_POST["blog_content"]);

		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$cat_id: $cat_id <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$blog_headline: $blog_headline <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$blog_imagePath: $blog_imagePath <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$blog_imageAlignment: $blog_imageAlignment <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$blog_content: $blog_content <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$errorCat_id = checkInputString($_POST["cat_id"], 1, 2);
		$errorBlog_headline = checkInputString($_POST["blog_headline"]);
		$errorBlog_imageAlignment = checkInputString($_POST["blog_imageAlignment"], 4, 5);
		$errorBlog_content = checkInputString($_POST["blog_content"], 10, 2048);

		// Finale Prüfung der Pflichteinfabefelder Blogpost
		if ( $errorCat_id OR $errorBlog_headline OR $errorBlog_content OR $errorCat_id OR $errorBlog_imageAlignment) {
			// Fehler
			if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>\r\n";


		} else {
			// Erfolg

			if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist formal fehlerfrei und wird nun verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>\r\n";



			#********************************************#
			#********** Bildupload verarbeiten **********#
			#********************************************#

//			if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//			if(DEBUG)	print_r($_FILES);
//			if(DEBUG)	echo "</pre>";

			// Prüfen, dass ein Upload vorliegt
			if ($_FILES["blog_imagePath"]["tmp_name"]) {

				if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Upload liegt vor und Bild kann geprüft werden.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				$imageUploadReturnArray = imageUpload($_FILES["blog_imagePath"]);

//				if (DEBUG) echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//				if (DEBUG) print_r($imageUploadReturnArray);
//				if (DEBUG) echo "</pre>";

				// Prüfen, ob es einen Bilduploadfehler gab und diesen ausgeben
				if ($imageUploadReturnArray["imageError"]) {
					// Fehler
					if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>:$imageUploadReturnArray[imageError] <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					$errorBlog_image = $imageUploadReturnArray["imageError"];

				} else {
					// Erfolg
					if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>:Bild wurde erfolgreich unter $imageUploadReturnArray[imagePath] gespeichert <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					// Neuen Bildpfad in Datenbank speichern
					$blog_imagePath = $imageUploadReturnArray["imagePath"];

				} // ENDE Prüfen, ob es einen Bilduploadfehler gab und diesen ausgeben

			}// ENDE Prüfen, dass ein Upload vorliegt


			// Finale überprüfung des Uploads
			if ($errorBlog_image) {
				// Fehler
				if (DEBUG) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Upload des Bildes war fehlerhaft. <i>(" . basename(__FILE__) . ")</i></p>\r\n";


				// Wir können mit else fortfahren, weil die Variable $errorBlog_image NULL oder "" enthält und somit auch ohne Upload fortgefahren werden kann.
			} else {
				// Erfolg



				#**********************************************#
				#********** BlogPost in DB schreiben **********#
				#**********************************************#

				$statement = $pdo->prepare("
					INSERT INTO 
					blogs (
						blog_headline, 
						blog_imagePath, 
						blog_imageAlignment, 
						blog_content, 
						cat_id, 
						usr_id
					) 
					VALUES (
						:ph_blog_headline, 
						:ph_blog_imagePath, 
						:ph_blog_imageAlignment, 
						:ph_blog_content, 
						:ph_cat_id, 
						:ph_usr_id
					)
				");

				$statement->execute( array(
						"ph_blog_headline" => $blog_headline,
						"ph_blog_imagePath" => $blog_imagePath,
						"ph_blog_imageAlignment" => $blog_imageAlignment,
						"ph_blog_content" => $blog_content,
						"ph_cat_id" => $cat_id,
						"ph_usr_id" => $_SESSION["usr_id"]
				) );

				if (DEBUG) if ($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				$rowCount = $statement->rowCount();
				if (DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>\$rowCount: $rowCount<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				if (!$rowCount) {
					// Fehler
					if (DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>Der Blogpost konnte nicht in die Datenbank geschrieben werden.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

				} else {
					// Erfolg

					if (DEBUG) echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>Der Blogpost wurde erfolgreich in die Datenbank gespeichert.<i>(" . basename(__FILE__) . ")</i></p>\r\n";

					// User benachrichtigen
					$dbMessage = "<h3 class='success'>Der Blogpost wurde erfolgreich in die Datenbank gespeichert.</h3>";

					// Eingabefelder zurücksetzen

					$cat_id = 1;
					$blog_headline = NULL;
					$blog_imagePath = NULL;
					$blog_imageAlignment = "left";
					$blog_content = NULL;

				}

			}

		} // ENDE Finale Prüfung der Pflichteinfabefelder Blogpost

	} // ENDE Überprüfe dass PostArray für den BlogPost





?>


<!doctype html>

<html>



<head>
	<meta charset="utf-8">
	<title>Dashboard</title>

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/debug.css">
</head>



<body>

	<header class="fright loginheader">
		<p>Hallo <b><?= $_SESSION["usr_firstname"] ?> <?= $_SESSION["usr_lastname"] ?></b></p>
		<p><a href="?action=logout">Logout</a> || <a href="index.php">Startseite</a></p>
	</header>
	<div class="clearer"></div>

	<h1>Dashboard</h1>

	<div class="fleft">
		<span class="success"><?= $dbMessage ?></span>
		<h3>Neuen Blogeintrag verfassen</h3>

		<form method="post" action="" enctype="multipart/form-data">
			<input type="hidden" name="addBlogPost">
			<fieldset>

				<?php if (!is_array($categoriesArray)): ?>
					<span class="error"><?= $categoriesArray ?></span>
				<?php else: ?>
					<span class="error"><?= $errorCat_id ?></span>
					<select name="cat_id" value="<?= $cat_id ?>">
						<?php foreach ($categoriesArray AS $categorieResults): ?>
							<option value="<?= $categorieResults["cat_id"] ?>" <?php if($categorieResults["cat_id"] == $cat_id) echo "selected" ?> ><?= $categorieResults["cat_name"] ?></option>
						<?php endforeach; ?>
					</select><br>
				<?php endif ?>

				<span class="error"><?= $errorBlog_headline ?></span>
				<input type="text" name="blog_headline" placeholder="Überschrift" value="<?= $blog_headline ?>">

				<p>Bild hochladen</p>
				<div>
					<div class="fleft">
						<fieldset name="blog_imagePath">
							<span class="error"><?= $errorBlog_image ?></span>
							<input type="file" name="blog_imagePath" value="">
						</fieldset>
					</div>
					<div class="fright">
						<span class="error"><?= $errorBlog_imageAlignment ?></span>
						<select name="blog_imageAlignment" value="<?= $blog_imageAlignment ?>">
							<option value="left" <?php if($blog_imageAlignment == "left") echo "selected" ?> >Links ausrichten</option>
							<option value="right" <?php if($blog_imageAlignment == "right") echo "selected" ?> >Rechts ausrichten</option>
						</select>
					</div>
				</div>
				<div class="clearer"></div>

				<span class="error"><?= $errorBlog_content ?></span>
				<textarea name="blog_content"><?= $blog_content ?></textarea>

				<input type="submit" value="Veröffentlichen">
			</fieldset>
		</form>

	</div>
	<div class="fright">
		<h3>Neue Kategorie anlegen</h3>

		<form method="post" action="">
			<fieldset>
				<input type="hidden" name="addCategory">
				<?= $usrMsgCategory ?>
				<input type="text" name="cat_name" placeholder="Name der Kategorie">
				<input type="submit" value="Neue Kategorie anlegen">
			</fieldset>
		</form>

	</div>
	<div class="clearer"></div>

</body>



</html>