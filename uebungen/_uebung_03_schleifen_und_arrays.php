<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Übung 3 - Schleifen und Arrays</title>
</head>
<body>
	<h1>Übung 3 - Schleifen und Arrays</h1>

	<h3>Nummerisches Array</h3>

	<?php
		$numArray = array("Peter","Patzig","Paulastraße 12","12345","Paulsdorf");

		for ( $i = 0; $i < count($numArray); $i++) {
			echo "$numArray[$i] ";
		}


		echo "<h4>Peter umbenennen</h4>";
		$numArray[0] = "Paul";
		for ( $i = 0; $i < count($numArray); $i++) {
			echo "$numArray[$i] ";
		}

		echo "<h4>Email anhängen</h4>";
		$numArray[] = "peter@patzig.de";
		for ( $i = 0; $i < count($numArray); $i++) {
			echo "$numArray[$i] ";
		}

		echo "<h4>While Schleife</h4>";
		$increment = 0;
		while ($increment < count($numArray)) {
			echo "$numArray[$increment] ";
			$increment++;
		}

		echo "<h4>Foreach Schleife</h4>";

		foreach ($numArray AS $value) {
			echo "$value ";
		}

    ?>

	<h3>Assoziatives Array</h3>

	<?php
		$numArray = array("Vorname" => "Peter", "Nachname" => "Patzig", "Strasse" => "Paulastraße 12", "PLZ" => "12345", "Ort" => "Paulsdorf");

		foreach ($numArray AS $value) {
			echo "$value ";
		}


		echo "<h4>Peter umbenennen</h4>";
		$numArray["Vorname"] = "Paul";

		echo "<h4>Email anhängen</h4>";
		$numArray["Email"] = "peter@patzig.de";

		foreach ($numArray AS $value) {
			echo "$value ";
		}

	?>

	<h3>Mehrdimensionales Array</h3>

	<?php
		$adressen = array(
			"Pizzaservice" => array(
					"Name" => "Alfredos Pizzabude",
					"Telefon" => "089 350 945",
					"Ort" => "München"
			),
			"Nachbar" => array(
				"Name" => "Herr Müller",
				"Telefon" => "0573 999 758",
				"Ort" => "Kleinpatzingen"
			),
			"Eltern" => array(
				"Name" => "Mama und Papa",
				"Telefon" => "05432 75 84 93",
				"Ort" => "Großpatzingen"
			)
		);

		foreach ($adressen AS $key => $value) {
			echo "<h4><b>$key</b></h4>";
			foreach ($value AS $key => $value) {
				echo "<span><b>$key:</b> $value</span><br>";
			}
			echo "<br>";
		}

	?>

</body>
</html>
