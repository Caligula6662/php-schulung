<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Stringoperationen mit PHP-Funktionen</title>
</head>

<body>
<h1>Stringoperationen mit PHP-Funktionen</h1>
<p>
	Da PHP i.d.R. sehr viel mit dem Datentyp String arbeitet, gibt es von Hause aus eine ganze
	Reihe an Funktionen, die dazu dienen, den Wert von Strings zu prüfen bzw. zu verändern.<br>
	<br>
	Eine Funktion ist ein eigenständiges Code-Fragment, das dazu dient, spezielle Aufgaben zu
	erfüllen, und das im Bedarfsfall explizit aufgerufen wird.<br>
	<br>
	Welche Funktionen PHP bereits mitbringt und wie mit diesen umzugehen ist, lässt sich auf der
	offiziellen Dokumentationsseite unter <a href="http://php.net" target="_blank">php.net</a>
	nachlesen.
</p>

<h2>Einige ausgewählte String-Funktionen</h2>
<?php
	$meinString1 = "Das ist ein String.";
	$meinString2 = "Das hier ist noch ein String.";
?>
<h3>Ausgangssituation:</h3>
<p>$meinString1: <i><?php echo $meinString1 ?></i></p>
<p>$meinString2: <i><?php echo $meinString2 ?></i></p>

<br>
<hr>
<br>

<h3>str_replace() - kann Zeichen innerhalb eines Strings ersetzen</h3>
<p>str_replace(needle, replacement, haystack)</p>
<p>Ziel: Aus <i>Das ist ein String.</i> soll werden <i>Das ist ein Hund.</i></p>
<?php
	$ergebnis = str_replace("String", "Hund", $meinString1);
?>
<p>Ergebnis: <i><?php echo $ergebnis ?></i></p>

<br>
<hr>
<br>

<h3>str_shuffle() - mischt alle Zeichen eines Strings durcheinander</h3>
<p>str_shuffle(String)</p>
<p>
	str_shuffle micht nicht die einzelnen Zeichen, sondern die Bytes, die diese im
	Speicher belegen (normales ASCII-Zeichen: 2 Bytes). Das führt dazu, dass Umlaute (4 Bytes) beim Shuffeln
	auseinandergerissen
	werden können (lälöHo - a�lH�l).
</p>
<?php
	$ergebnis = str_shuffle("Hallö");
?>
<p>Ergebnis: <i><?php echo $ergebnis ?></i></p>

<br>
<hr>
<br>

<h3>mb_strlen() - liest die Anzahl der Zeichen innerhalb eines Strings aus</h3>
<p>mb_strlen(String)</p>
<?php
	$ergebnis = mb_strlen($meinString1);
?>
<p>Ergebnis: <i><?php echo $ergebnis ?></i></p>
<p>
	Achtung: Die Funktion strlen() zählt nicht wirklich Zeichen, sondern die Bytes, die von diesen Zeichen im Speicher
	belegt
	werden.<br>
	Umlaute belegen mehr Bytes als einfache Zeichen und geben daher eine falsche String-Länge zurück. Um dieses Problem
	zu umgehen,
	muss für UTF-8-kodierte Strings die Funktion Multibyte-StringLength (mb_strlen()) verwendet werden, der man die
	aktuelle
	Zeichenkodierung als Parameter mitgeben kann.<br><br>
	Beispiel: echo mb_strlen($string, 'UTF-8')
</p>

<br>
<hr>
<br>

<h3>stripos() - findet das erste Vorkommen eines Teilstrings innerhalb eines Strings
	(fängt bei 0 zu zählen an)</h3>
<p>stripos(haystack, needle)</p>
<p>Die Variante stripos() ist case insensitive.</p>
<?php
	$ergebnis = stripos($meinString1, "ein");
?>
<p>Ergebnis: <i><?php echo $ergebnis ?></i></p>

<br>
<hr>
<br>

<h3>substr() - schneidet einen Teil eines Strings aus und liefert diesen Teil zurück</h3>
<p>substr(haystack, startposition [, length])</p>
<p>Übergebener String: <i><?php echo $meinString2 ?></i></p>
<p>Schneide einen Teilstring ab Zeichen 12 aus: <i><?php echo substr($meinString2, 12) ?></i></p>
<p>Schneide ab Zeichen 13 die folgenden 8 Zeichen aus: <i><?php echo substr($meinString2, 13, 8) ?></i></p>
<p>Schneide von vorn die folgenden 20 Zeichen aus: <i><?php echo substr($meinString2, 0, 20) ?></i></p>
<p>Schneide von hinten gezählt 20 Zeichen aus: <i><?php echo substr($meinString2, -20) ?></i></p>
<p>Schneide von hinten gezählt ab Zeichen 20 die folgenden 8 Zeichen aus:
	<i><?php echo substr($meinString2, -20, 8) ?></i></p>

<br>
<hr>
<br>

<?php
	$meineDatei = "meinSuperBild.js";
	$startPosition = stripos($meineDatei, ".");

	$dateiEndung = substr($meineDatei, $startPosition);
?>
<p>Dateiendung: <?php echo $dateiEndung ?></p>

</body>
</html>
