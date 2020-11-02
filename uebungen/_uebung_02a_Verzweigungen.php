<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Übung Tag 2</title>
</head>
<body>

    <h1>Übung Tag 2</h1>
	<h3>If Else Bedingungen</h3>


    <?php

		$wert = 50;
		$sth = 40;
		$gth = 70;

		if ($wert < $sth) {
			echo "<p>$wert ist kleiner als $sth.</p>";
		} else {
			echo "<p>$wert ist NICHT kleiner als $sth.</p>";
		}

		if ($wert > $gth) {
			echo "<p>$wert ist größer als $gth.</p>";
		} else {
			echo "<p>$wert ist NICHT größer als $gth.</p>";
		}

		if ($wert < $sth) {
			echo "<p>$wert ist kleiner als $sth.</p>";
		} elseif ($wert > $gth) {
			echo "<p>$wert ist größer als $gth.</p>";
		} else {
			echo "<p>Der Wert $wert liegt zwischen $sth und $gth.</p>";
		}

    ?>

	<h3>If Else mit logischen Operatoren und Gruppierungen</h3>

	<?php
		$gemuese1 = "Gurken";
		$gemuese2 = "Tomaten";

		if ($gemuese1 == "Gurken") {
			echo "<p>Heute gibt es Gurken.</p>";
		}

		if ($gemuese1 == "Tomaten") {
			echo "<p>Heute gibt es Tomaten.</p>";
		}

		if ($gemuese1 != "Tomaten" AND $gemuese1 != "Gurken") {
			echo "<p>Heute gibt es weder Gurken noch Tomaten.</p>";
		}

		if (($gemuese1 == "Gurken" OR $gemuese1 == "Tomaten") AND ($gemuese2 == "Gurken" OR $gemuese2 == "Tomaten")) {
			echo "<p>Heute gibt es Salat.</p>";
		} else {
			echo "<p>Heute gibt es keinen Salat.</p>";
		}

	?>


	<h3>Switch</h3>


	<?php

		$auto = "BMW";
		$echoWert = "<p>Das Auto ist ein $auto</p>";

		switch ($auto) {
			case "Audi": echo $echoWert;
				break;
			case "Mercedes": echo $echoWert;
				break;
			case "VW": echo $echoWert;
				break;
			case "BMW": echo $echoWert;
				break;
			case "Opel": echo $echoWert;
				break;
		}

	?>



</body>
</html>
