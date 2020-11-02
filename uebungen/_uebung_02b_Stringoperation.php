<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Übung Tag 2</title>
</head>
<body>

    <h1>Übung Tag 2</h1>
    <h3>Konkatinieren</h3>

    <?php

		$vName1 = "Lars";
		$vName2 = "Peter";
		$vName3 = "Ernst";
		$vName4 = "Uwe";
		$vName5 = "Hubertus";

		echo '<p>Vornamen: '.$vName1.', '.$vName3.', '.$vName4.', '.$vName4.', '.$vName5.'</p>';
		echo "<p>Vornamen: $vName1, $vName3, $vName4, $vName4, $vName5</p>";

    ?>

    <h3>Stringoperation</h3>
	<h4>str_replace</h4>

    <?php

		$stringVar = "Hundeaufzuchtstation";
		echo "<p>$stringVar</p>";

		$newStringVar = str_replace("Hunde", "Pinguin", $stringVar);
		echo "<p>$newStringVar</p>";

    ?>

	<h4>str_length</h4>
	<?php
		$stringVarL = "Die Stoßstange ist aller Laster Anfang";
		$length = mb_strlen($stringVarL);
		echo "<p>Die Länge des Strings: (\" $stringVarL \") ist $length.</p>";

		$stringVarLNew = str_replace("Die Stoßstange", "Müßiggang", $stringVarL);
		echo "<p>$stringVarLNew</p>";
	?>

	<h4>Bonus</h4>

	<?php

		$datum = "2017/16/05";
		$datum2 = str_replace("/", "-", $datum);

		$year = substr($datum, 0, 4);
		$day = substr($datum, 5, 2);
		$month = substr($datum, 8, 2);

		echo "<p>$datum</p>";
		echo "<p>$datum2</p>";
		echo "<p>$day.$month.$year</p>";



	?>


</body>
</html>
