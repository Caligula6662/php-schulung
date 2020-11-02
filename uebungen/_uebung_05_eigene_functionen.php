<?php

	/**
	 * Funktion zum Überprüfen von Variablen und Arrays. Gibt mittels
	 * print_r die Variable lesbar und geordnet zurück.
	 *
	 * @param $testobject : mixed - Variable die zu testen ist
	 */

	function debugSimpleDataTypesAndArrays($value) {
		$backtrace =  debug_backtrace();
		echo ($backtrace[0]['file'] .'(' . $backtrace[0]['line'] . ')');
		echo print_r($value);
	}

	$testvariable = array("test", "test2");
	if (degub) debugSimpleDataTypesAndArrays($testvariable);

?>


<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Default</title>
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/pageElements.css">
	<link rel="stylesheet" href="../css/debug.css">
</head>

	<body>
		<h1>Default</h1>

	</body>
</html>