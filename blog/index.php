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
			}


			#************************************************#
			#************* Includes und Imports *************#
			#************************************************#

			require_once("include/config.inc.php");
			require_once("include/form.inc.php");
			require_once("include/db.inc.php");
			require_once("include/dateTime.inc.php");


			#*************************************#
			#************* Variablen *************#
			#*************************************#

			$errorLogin = NULL;
			$categorieId = NULL;
			$pdo = dbConnect();


			#*********************************#
			#************* Login *************#
			#*********************************#

			// Post Array für Login prüfen
			if (isset($_POST["login"])) {

if (DEBUG) 		echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Postarray wurde gefunden und die Formularverarbeitung kann beginnen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

//if (DEBUG) 	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//if (DEBUG) 	print_r($_POST);
//if (DEBUG)	echo "</pre>";

				// Eingabefelder lesen und entschärfen
				$email = cleanString($_POST["email"]);
				$password = cleanString($_POST["password"]);

if (DEBUG) 		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$email $email <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if (DEBUG) 		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$password $password <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				// Eingabefelder validieren
				$errorEmail = checkEmail($email);
				$errorPassword = checkInputString($password, 4);

if (DEBUG) 		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorEmail $errorEmail <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if (DEBUG) 		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$errorPassword $errorPassword <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				// Finale Validierung mit ggf. Rückmeldung an den User
				if ($errorEmail or $errorPassword) {
					// Fehler
if (DEBUG) 			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Eines der beiden Felder wurde nicht ausgefüllt oder die Email ist keine gültige Email. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					$errorLogin = "Benutzername oder Passwort falsch!";

				} else {
					// Erfolg
if (DEBUG) 			echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Beide Felder enthalten gültige Werte und können weiter verarbeitet werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";


					#**************************************************#
					#************* Login Datenbankabfrage *************#
					#**************************************************#



					$statement = $pdo->prepare("
						SELECT * FROM users WHERE usr_email = :ph_email
					");
					$statement->execute(array("ph_email" => $email));
if (DEBUG) 			if ($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";


					$row = $statement->fetch(PDO::FETCH_ASSOC);

//					if (DEBUG) echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//					if (DEBUG) print_r($row);
//					if (DEBUG) echo "</pre>";

					// Daten aus der Datenbank weiterverarbeiten

					if (!$row) {
						// Fehler
if (DEBUG) 				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Email: $email existiert NICHT in der Datenbank. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						$errorLogin = "Benutzername oder Passwort falsch!";

					} else {
						// Erfolg
if (DEBUG) 				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Email ist in der Datenbank vorhanden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

						#*************************************************#
						#************* Passwort und Session  *************#
						#*************************************************#

						// Passwort überprüfen
						if (!password_verify($password, $row["usr_password"])) {
							// Fehler
if (DEBUG) 					echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Passwörter stimmen NICHT überein. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
							$errorLogin = "Benutzername oder Passwort falsch!";

						} else {
							// Erfolg
if (DEBUG) 					echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Passwörter stimmen überein und die Session kann gestartet werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

							//Session starten

							session_name("blog");
							session_start();

							$isLoggedIn = true;

							$_SESSION["usr_id"] = $row["usr_id"];
							$_SESSION["usr_firstname"] = $row["usr_firstname"];
							$_SESSION["usr_lastname"] = $row["usr_lastname"];

							// Weiterleitung auf das Dashboard
							header("Location: dashboard.php");

//if (DEBUG) 				echo "<pre class='debug'>Session - Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
//if (DEBUG) 				print_r($_SESSION);
//if (DEBUG) 				echo "</pre>";

						} // ENDE Passwort überprüfen

					} // ENDE Daten aus der Datenbank weiterverarbeiten

				} // ENDE Finale Validierung mit ggf. Rückmeldung an den User

			} // ENDE Post Array für Login prüfen



			#****************************************************#
			#********** Vorhandene Kategorien ausgeben **********#
			#****************************************************#

			//$categoriesArray = readTableFromDb($pdo, "categories");

			$statement = $pdo->prepare("SELECT * FROM categories");
			$statement->execute();
if(DEBUG) 	if($statement->errorInfo()[2]) echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			$categoriesArray = $statement->fetchAll(PDO::FETCH_ASSOC);

			// Überprüfe dass Array aus der Datenbank
			if ( !isset($categoriesArray)) {
				// Fehler
if (DEBUG) 		echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: Die Kategorien konnten nicht von der Datenbank geladen werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
				$categoriesArray = "Fehler beim lesen der Kategorien.";

			} else {
				// Erfolg
if (DEBUG) 		echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: Die Kategorien wurden erfolgreich von der Datenbank geladen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			} // ENDE Überprüfe dass Array aus der Datenbank



			#********************************************#
			#********** PROCESS URL PARAMETERS **********#
			#********************************************#

			// Parameter prüfen
			if (isset($_GET['action'])) {

if (DEBUG) 		echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: URL-Parameter 'action' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				$action = cleanString($_GET['action']);
if (DEBUG) 		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$action: $action <i>(" . basename(__FILE__) . ")</i></p>\r\n";

				#****************************#
				#********** Logout **********#
				#****************************#

				// Prüfe, dass der Parameter den Wert Logout enthält und führe dann Logout aus.
				if ($action == "logout") {
if (DEBUG) 			echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Logout wird durchgeführt... <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					session_destroy();

					// Neuladen der Index.php, da action nicht mehr verfügbar ist
					header("Location: index.php");
					exit;

				} // ENDE Prüfe, dass der Parameter den Wert Logout enthält und führe dann Logout aus.

				#**********************************************#
				#********** READ CATEGORIES FROM DB  **********#
				#**********************************************#

				// Prüfe, dass der Parameter den Wert selectCategory enthält und rufe dann die Kategorie ab.
				if ($action == "selectCategory") {

if (DEBUG) 			echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: URL-Parameter 'action' mit 'selectCategory' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

					// Verzweigung des zweiten Parameter 'id'
					if (isset($_GET['id'])) {

if (DEBUG) 			echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: URL-Parameter 'id' wurde übergeben. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

						$categorieId = cleanString($_GET['id']);

					} // ENDE Verzweigung des zweiten Parameter 'id'

				} // ENDE Prüfe, dass der Parameter den Wert selectCategory enthält und rufe dann die Kategorie ab.

			} // ENDE Parameter prüfen


			#***********************************************#
			#********** Blogposts aus DB auslesen **********#
			#***********************************************#

			$postsArray = NULL;
			$sql = "
				SELECT * FROM `blogs`
				LEFT JOIN categories USING(cat_id)
				INNER JOIN users USING(usr_id)
			";
			$params = NULL;

			if ($categorieId) {
				$sql .= " WHERE cat_id = :ph_catId";
				$params = array("ph_catId"=>$categorieId);
			}

			$sql .= " ORDER BY blog_date DESC";

			$statement = $pdo->prepare($sql);
			$statement->execute($params);
			$postsArray = $statement->fetchAll(PDO::FETCH_ASSOC);

if (DEBUG) 	if ($statement->errorInfo()[2]) echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			// Überprüfe dass Array aus der Datenbank
			if (!isset($postsArray)) {
				// Fehler
if (DEBUG) 		echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Die Artikel konnten nicht von der Datenbank geladen werden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			} else {
				// Erfolg
if (DEBUG) 		echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Die Artikel wurden erfolgreich von der Datenbank geladen. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			} // ENDE Überprüfe dass Array aus der Datenbank


?>


<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Willkommen auf meinem Blog</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body>

		<header class="header container">

			<?php if (!isset($_SESSION["usr_id"])): ?>
				<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
					<input type="hidden" name="login">
					<fieldset>
						<legend>Login</legend>
						<span class='error'><?= $errorLogin ?></span><br>
						<input class="short" type="text" name="email" placeholder="Email">
						<input class="short" type="password" name="password" placeholder="Passwort">
						<input class="short" type="submit" value="Anmelden">
					</fieldset>
				</form>
			<?php else: ?>

				<p>Hallo <b><?= $_SESSION["usr_firstname"] ?> <?= $_SESSION["usr_lastname"] ?></b></p>
				<p><a href="?action=logout">Logout</a> || <a href="dashboard.php">Dashboard</a></p>

			<?php endif ?>

		</header>

		<div class="container">

			<div class="hero">
				<h1>PHP Blog Projekt!</h1>
				<a href="index.php">Alle Einträge anzeigen</a>
			</div>

			<div class="d-flex">
				<div class="col-9">
					<div class="content">
						<?php if ($postsArray): ?>
							<?php foreach ($postsArray as $singlePost): ?>

								<div class="blogpost">
									<div class="blogpost-header">
										<small>Kategorie: <?= $singlePost["cat_name"] ?></small>
										<h3><?= $singlePost["blog_headline"] ?></h3>
										<span class="info"><?= $singlePost["usr_firstname"] ?> <?= $singlePost["usr_lastname"] ?> (<?= $singlePost["usr_city"] ?>) schrieb am <?= isoToEuDateTime($singlePost["blog_date"])["date"] ?> um <?= isoToEuDateTime($singlePost["blog_date"])["time"] ?> Uhr:</span>
									</div>
									<div class="blogpost-content">
										<div class="d-flex">
											<?php if ($singlePost["blog_imagePath"]): ?>
												<div class="col-4 image <?= $singlePost["blog_imageAlignment"] ?>">
													<img src="<?= $singlePost["blog_imagePath"] ?>">
												</div>
												<p class="col-8"><?= nl2br($singlePost["blog_content"]) ?></p>
											<?php else: ?>
												<p><?= nl2br($singlePost["blog_content"]) ?></p>
											<?php endif; ?>

										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<p class="error">Es konnten keine Artikel gefunden werden.</p>
						<?php endif; ?>
					</div>
				</div>


				<div class="col-3" style="width: 20%;">
					<div class="sidebar-nav">
						<?php if (!is_array($categoriesArray)): ?>
							<span class="error"><?= $categoriesArray ?></span>
						<?php else: ?>
							<ul class="categories">
								<?php foreach ($categoriesArray as $categorieResults): ?>
									<li>
										<a href="?action=selectCategory&id=<?= $categorieResults["cat_id"] ?>"><?= $categorieResults["cat_name"] ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif ?>
					</div>
				</div>
			</div>

			<div class="clearer"></div>
		</div>

	</body>
</html>