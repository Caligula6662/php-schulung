<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Verzweigungen/Bedingungen</title>
</head>

<body>
<h1>Verzweigungen/Bedingungen</h1>
<p>
	PHP arbeitet den Quellcode i.d.R. sequenziell, d.h. von oben nach unten ab.
	Programme sollten allerdings auch je nach Situation unterschiedliche Dinge ausführen.
	Hierfür dienen in der Programmierung sogenannte Verzweigungen.
</p>
<p>
	Eine Verzweigung bedeutet, dass eine bestimmte Bedingung erfüllt sein muss, um zu einer
	anderen Stelle im Quellcode zu springen. Hierzu werden Werte aus beispielsweise Variablen
	auf bestimmte Zustände abgefragt und mit einem Referenzwert verglichen.
</p>
<p>Syntax:</p>
<pre>
if( Bedingung ) {
   auszuführender Code, wenn die Bedingung erfüllt ist;
}
Unabhängig von der Bedingung geht es anschließend hier weiter...
</pre>

<p>
	Ein einfaches = ist ein Zuweisungsoperator, der einer Variablen einen Wert zuweist.<br>
	Ein doppeltes == ist ein Vergleichsoperator, der den Inhalt einer Variablen mit einem
	definierten Wert vergleicht.
</p>

<h3>Vergleichsoperatoren</h3>
<p>
	true/false: In der if-Bedingung werden zwei Werte anhand einer Bedingung miteinander verglichen.<br>
	Trifft die Bedingung zu, liefert die Abfrage true zurück. Trifft die Bedingung nicht zu, liefert die Abfrage false
	zurück.
</p>
<p>
	Beispiel:<br>
	Bedingung: Wert1 ist gleich Wert2 -> Ergebnis: true, wenn Wert1 gleich Wert2 ist. Ansonsten false.<br>
	Bedingung: Wert1 ist größer als Wert2 -> Ergebnis: true, wenn Wert1 größer ist als Wert2. Ansonsten false.<br>
	Bedingung: Wert1 ist ungleich Wert2 -> Ergebnis: true, wenn Wert1 ungleich Wert2 ist. Ansonsten false.
</p>

<h4>Liste der Vergleichsoperatoren</h4>
<ul>
	<li>== (ist gleich): prüft, ob eine Bedingung zutrifft (Bedingung ist erfüllt, wenn das Prüfkonstrukt "true"
		ergibt)
	</li>
	<li>!= (ist ungleich): prüft, ob eine Bedingung nicht zutrifft (Bedingung ist erfüllt, wenn das Prüfkonstrukt
		"false" ergibt)
	</li>
	<li>=== (ist gleich gleich): prüft, ob ein Wert gleich ist und ob der Typ gleich ist (Bedingung ist erfüllt, wenn
		das Prüfkonstrukt "true" ergibt)
	</li>
	<li>!== (ist ungleich ungleich): prüft, ob ein Wert ungleich ist und ob der Typ ungleich ist (Bedingung ist erfüllt,
		wenn das Prüfkonstrukt "false" ergibt)
	</li>
	<li>> (größer): Bedingung trifft zu (true), wenn geprüfter Wert größer als ... ist</li>
	<li>< (kleiner): Bedingung trifft zu (true), wenn geprüfter Wert kleiner als ... ist</li>
	<li>>= (größer/gleich): Bedingung trifft zu (true), wenn geprüfter Wert größer als oder gleich groß ... ist</li>
	<li><= (kleiner/gleich): Bedingung trifft zu (true), wenn geprüfter Wert kleiner als oder gleich klein ... ist</li>
	<li>isset() : Prüft, ob eine Variable existiert und ob sie einen anderen Wert hat als NULL</li>
</ul>

<br>
<hr>
<br>

<h4>Beispiel: Ein Türsteher muss das Alter eines Gastes wissen, um entscheiden zu können,
	ob der Gast den Club betreten darf oder nicht.</h4>

<h3>if-else</h3>
<p>"else" ist optional und kann auch auf die Nichterfüllung der Bedingung reagieren.</p>
<?php
	// Variable deklarieren und initialisieren
	$ingmarsAlter = "minderjährig";
	echo "<p>\$ingmarsAlter: $ingmarsAlter</p>";

	if ($ingmarsAlter == "volljährig") {
		// Wenn Bedingung erfüllt ist:
		echo "<p><i>Du darfst eintreten.</i></p>";
	} else {
		// Wenn Bedingung NICHT erfüllt ist:
		echo "<p><i>Du musst draußen bleiben!</i></p>";
	}
	// unabhängig von der Erfüllung der Bedingung geht es hier weiter...
	echo "<p><i>Schönen Abend noch.</i></p>";
?>

<p>- - -</p>

<h3>if-elseif-else</h3>
<p>Mit "elseif" kann eine alternative Bedingungen formuliert werden</p>
<p>
	Wenn eine Bedingung innerhalb eines if-/elseif-Konstrukts erfüllt wurde, werden keine
	weiteren Bedingungen mehr geprüft!
</p>
<?php
	// Variable deklarieren und initialisieren
	$ingmarsAlter = "nuschelnuschel";
	echo "<p>\$ingmarsAlter: $ingmarsAlter</p>";

	if ($ingmarsAlter == "volljährig") {
		// Wenn Bedingung erfüllt ist:
		echo "<p><i>Du darfst eintreten.</i></p>";

	} elseif ($ingmarsAlter == "minderjährig") {
		// Wenn die if-Bedingung NICHT zutrifft, wird die elseif-Bedingung geprüft
		// Wenn die if-Bedingung erfüllt wurde, wird die elseif-Bedingung NICHT mehr geprüft
		echo "<p><i>Du musst draußen bleiben!</i></p>";

	} else {
		// Wenn KEINE der Bedingungen erfüllt ist:
		echo "<p><i>HÄH?!?</i></p>";
	}
	// unabhängig von der Erfüllung der Bedingung geht es hier weiter...
	echo "<p><i>Schönen Abend noch.</i></p>";
?>

<p>- - -</p>

<h5>Zahlenwerte prüfen</h5>
<p>
	PHP kann Strings als Zahlenwerte interpretieren, wenn mit diesen Strings eine mathematische
	Operation bzw. ein mathematischer Vergleich durchgeführt wird.<br>
	Der String wird hierbei von links nach rechts auf interpretierbare Zahlenwerte durchsucht. Ab
	dem ersten Zeichen, das nicht eindeutig als Zahl interpretiert werden kann, wird der restliche
	String ignoriert.<br>
	Enthält ein String keinerlei als Zahl interpretierbaren Wert, wird der gesamte String als 0 interpretiert.
</p>
<p>
	Der Grund für dieses Verhalten ist, dass PHP aus HTML-Formularen und HTML-Links ausschließlich den Datentyp
	String erhält.
</p>
<?php
	// Variable deklarieren und initialisieren
	$ingmarsAlter = 55;
	echo "<p>\$ingmarsAlter: $ingmarsAlter</p>";

	if ($ingmarsAlter < 18) {
		// minderjährig
		echo "<p><i>Du musst draußen bleiben.</i></p>";

	} elseif ($ingmarsAlter >= 50) {
		// alter Sack
		echo "<p><i>Das ist hier keine Ü50-Party.</i></p>";

	} elseif ($ingmarsAlter >= 18) {
		// volljährig
		echo "<p><i>Du darfst eintreten.</i></p>";

	}
	// unabhängig von der Erfüllung der bedingungen geht es hier weiter
	echo "<p><i>Schönen Abend noch.</i></p>";
?>

<br>
<hr>
<br>

<h3>Logische Operatoren</h3>
<p>Bedingungen (Vergleiche) lassen sich mittels logischer Operatoren miteinander verknüpfen.</p>
<p>
	Es gibt die beiden logischen Operatoren AND (&&) und OR (||).<br>
	AND (&&) bedeutet: <b>Alle</b> Bedingungen müssen erfüllt sein, damit das Gesamtkonstrukt der if-Abfrage wahr (true)
	ist.<br>
	OR (||) bedeutet: Es muss nur <b>1</b> Bedingung erfüllt sein, damit das Gesamtkonstrukt der if-Abfrage wahr (true)
	ist.
</p>
<p>
	Darüber hinaus gibt es noch einen dritten logischen Operator: XOR oder auch "ausschließliches OR": Hier werden zwei
	Bedingungen
	mittels XOR verknüpft. Das Gesamtkontrukt der if-Abfrage ist true, wenn eine der beiden Bedingungen true ist, aber
	<strong>nicht beide</strong>!
</p>
<h5>Beispiel für logische Operatoren</h5>

<p>Aufgabenstellung:</p>
<ol>
	<li>Wenn Ingmar volljährig ist, darf er in den Club</li>
	<li>Wenn Ingmars Job "Putze" ist UND er volljährig ist, muss er die Klos putzen</li>
	<li>Wenn Ingmar berühmt ist (Rennfahrer oder Filmstar), darf er unabhängig von
		seinem Alter in die VIP-Lounge
	</li>
</ol>
<?php
	$ingmarsAlter = 17;
	echo "<p>\$ingmarsAlter: $ingmarsAlter</p>";
	$ingmarsJob = "Student";
	echo "<p>\$ingmarsJob: $ingmarsJob</p>";

	if ($ingmarsJob == "Putze" and $ingmarsAlter >= 18) {
		// Fall Putze: Putze und volljährig
		echo "<p><i>Willste Putzjob haben?</i></p>";

	} elseif ($ingmarsJob == "Rennfahrer" or $ingmarsJob == "Filmstar") {
		// Fall VIP: Rennfahrer oder Filmstar - Alter egal
		echo "<p><i>Willkommen in der VIP-Lounge.</i></p>";

	} elseif ($ingmarsAlter >= 18) {
		// Fall volljährig: volljährig - Job egal
		echo "<p><i>Du darfst eintreten.</i></p>";

	} elseif ($ingmarsAlter < 18) {
		// Fall minderjährig: minderjährig - Job egal
		echo "<p><i>Du musst draußen bleiben.</i></p>";
	}
?>

<br>
<hr>
<br>

<h4>Prüfen auf Existenz und Wert einer Variablen/eines Array-Indexes (true/false)</h4>

<p>Variante 1: isset() - Prüfen auf Existenz und vorhandenen Datentyp:</p>
<?php
	// Variable deklarieren und initialisieren
	$vorname = "";
	echo "<p>\$vorname: $vorname</p>";

	if (isset($vorname)) {
		echo "<p>Die Variable existiert UND hat einen anderen Wert als NULL</p>";
	} else {
		echo "<p>Die Variable existiert NICHT ODER sie hat den Wert NULL</p>";
	}

?>

<p>- - -</p>

<p>Variante 2: Prüfen auf Existenz und einen gültigen Wert einer Variablen/eines Array-Indexes::</p>
<p>
	Prüfen, ob eine Variable existiert bzw. ob sie einen messbaren Wert besitzt.<br>
	Ein messbarer Wert ist alles, das NICHT <i>NULL, 0, "", "0" oder false</i> ist.
</p>
<?php
	if ($vorname) {
		echo "<p>Die Variable existiert UND hat einen anderen Wert als NULL, 0, '', '0' oder false</p>";
	} else {
		echo "<p>Die Variable existiert NICHT ODER sie hat den Wert NULL, 0, '', '0' oder false</p>";
	}
?>

<br>
<hr>
<br>

<h5>Vergleich des Inhalts und Datentyps einer Variablen</h5>
<p>
	Manchmal ist es zwingend notwendig, zusätzlich zum Wert einer Variablen auf ihren Datentyp zu
	prüfen.
</p>
<?php
	$variable = "10";
	echo "<p>\$variable: $variable</p>";

	// Zwei == prüfen auf den Wert
	if ($variable == 10) {
		echo "<p>Der Wert stimmt. Der Datentyp wurde nicht überprüft.</p>";
	} else {
		echo "<p>Der Wert stimmt NICHT. Der Datentyp wurde nicht überprüft.</p>";
	}

	// Drei === prüfen auf den Wert UND auf den Datentyp
	if ($variable === 10) {
		echo "<p>Der Wert UND der Datentyp stimmen überein.</p>";
	} else {
		echo "<p>Der Wert ODER der Datentyp stimmen NICHT überein.</p>";
	}

	echo "<p>- - -</p>";

	// !== ist das Gegenteil von ===, d.h. die Bedingung ist dann NICHT erfüllt, wenn
	// Wert UND Datentyp gleich sind.
	if ($variable !== 10) {
		echo "<p>Der Wert und/oder der Datentyp sind unterschiedlich.</p>";
	} else {
		echo "<p>Der Wert UND der Datentyp sind gleich.</p>";
	}
?>

<br>
<hr>
<br>

<h2>Switch Case</h2>
<p>
	Die switch Anweisung entspricht in etwa einer Folge von if Anweisungen, die jeweils den gleichen Ausdruck
	prüfen. Es kommt oft vor, dass man dieselbe Variable (oder denselben Ausdruck) gegen viele verschiedene
	mögliche Werte prüfen (und abhängig davon unterschiedlichen Code ausführen) möchte.<br>
	Da das Auslesen des Wertes der zu prüfenden Variable im Switch lediglich einmal geschieht und
	anschließend ihr Wert nur noch gegen die Cases geprüft wird, kann ein switch bei einer Anzahl von
	vielen Prüfungen auf dieselbe Variable schneller sein, als mehrere if-elseifs.
</p>
<p>
	Die Möglichkeiten des Switches sind gegenüber des if-elseif-Konstrukts deutlich eingeschränkt: So lassen
	sich beispielsweise nicht mehrere Variablen auf einmal überprüfen, und auch eine logische AND-Verknüpfung
	ist für den Switch nicht vorgesehen. Eine Oder-Verknüpfung hingegen kann mittels des sog. "Fall through"s
	erreicht werden.
</p>

<p>- - -</p>

<h4>Fall Through:</h4>
<p>
	Fall Through beim Switch bedeutet, dass man ein oder mehrere Breaks weglassen kann.
	In diesem Fall werden alle Cases bis zum nächsten break; durchlaufen (Fall Through) und es wird der Befehl im
	nächsten Case ausgeführt. Dieses Verhalten entspricht einer logischen OR-Verknüpfung.
</p>

<h3>Ein Switch mit Strings:</h3>

<?php
	$weather = "graupel";
	echo "<p>\$weather: $weather</p>";

	switch ($weather) {

		case "graupel":
		case "regen":
			echo "<p><i>Du brauchst einen Regenschirm.</i></p>";
			break;
		case "schnee":
			echo "<p><i>Du brauchst Schneeschuhe.</i></p>";
			break;
		case "sonnig":
			echo "<p><i>Du brauchst einen Sonnenhut.</i></p>";
			break;
		default:
			echo "<p><i>Das Wetter ist unberechenbar.</i></p>";
			break;
	}
?>

<h3>Ein Switch mit Zahlenwerten:</h3>

<?php
	$ingmarsAlter = 7;
	echo "<p>\$ingmarsAlter: $ingmarsAlter</p>";

	switch ($ingmarsAlter) {
		case $ingmarsAlter < 18:
			echo "<p><i>Du darfst hier nicht rein!</i></p>";
			break;
		case $ingmarsAlter > 40:
			echo "<p><i>Das ist hier keine Ü40-Party!</i></p>";
			break;
		case $ingmarsAlter > 18:
			echo "<p><i>Du darfst eintreten.</i></p>";
			break;
		case 18:
			echo "<p><i>Herzlichen Glückwunsch zum Geburtstag!</i></p>";
			break;
	}
?>


</body>
</html>