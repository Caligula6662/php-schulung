<?php

	//region 0 Imports

	require_once ("../include/config.inc.php");

	//endregion




	//region 1 Variables

	$content = NULL;
	$testArrayOutput = NULL;

	//endregion




	//region 2 Process Form Inputs

	if (isset($_POST["formsent"])) {

		if(DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Formular 'Message' wurde abgeschickt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$name = trim(htmlspecialchars($_POST["name"], ENT_QUOTES | ENT_HTML5));
		$email = trim(htmlspecialchars($_POST["email"], ENT_QUOTES | ENT_HTML5));

		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$name: $name <i>(" . basename(__FILE__) . ")</i></p>\r\n";
		if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$email: $email <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		$content = "<h4>Willkommen $name! Du bist mit der Email $email angemeldet.</h4>";

	}

	//endregion




	//region 3 Process URL Parameter

	if (isset($_GET["action"])) {

		if(DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Der URL Request wurde empfangen <i>(" . basename(__FILE__) . ")</i></p>\r\n";

		if ($_GET["action"] == "show") {
			if(DEBUG) echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Der URL Parameter Show wurde empfangen.<i>(" . basename(__FILE__) . ")</i></p>\r\n";


			$testArray = array(1,2,3,4,5,6,7,8,9,10);
			if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";
			if(DEBUG)	print_r($testArray);
			if(DEBUG)	echo "</pre>";

			$runs = count($testArray);
			if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$runs: $runs <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			if (isset($_GET["anzahl"])) {
				$runs = $_GET["anzahl"];
				if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$runs: $runs <i>(" . basename(__FILE__) . ")</i></p>\r\n";
			}

			if(DEBUG) echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$runs: $runs <i>(" . basename(__FILE__) . ")</i></p>\r\n";

			$testArrayOutput = "<ul>";

			for ($i = 0; $i < $runs; $i++) {
				$testArrayOutput .= "<li>Listenpunkt: $testArray[$i]</li>";
			}

			$testArrayOutput .= "<ul>";
		}

		if ($_GET["action"] == "hide") {
			$testArrayOutput = NULL;
		}

	}

	//endregion


?>


<?php //region HTML-Document ?>
<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Get Post in PHP</title>

		<link rel="stylesheet" href="../css/main.css">
		<link rel="stylesheet" href="../css/pageElements.css">
		<link rel="stylesheet" href="../css/debug.css">
	</head>
	
	<body>
		<h1>Übungen URL-Parameter- und Formularverarbeitung</h1>

		<h3>Post</h3>
		<?php echo $content ?>

		<form action="" method="post">
			<input type="hidden" name="formsent">
			<input type="text" name="name" placeholder="Name">
			<input type="text" name="email" placeholder="Email">
			<input type="submit" value="Absenden">
		</form>
	
		<h3>Get</h3>

		<h4>Links zur Seitensteuerung</h4>
		<p><a href="_uebung_04_get_post.php">Seitenaufruf ohne Parameter</a></p>
		<p><a href="_uebung_04_get_post.php?action=show">Zeige Array</a></p>
		<p><a href="_uebung_04_get_post.php?action=show&anzahl=2">Zeige 2 Werte aus dem Array</a></p>
		<p><a href="_uebung_04_get_post.php?action=hide">Blende die Anzeige aus.</a></p>

		<?php echo $testArrayOutput?>

	</body>
</html>
<?php //endregion ?>