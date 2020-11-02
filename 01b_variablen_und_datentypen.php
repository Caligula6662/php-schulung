<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Variablen und Datentypen</title>
    </head>
    <body>
        <h1>Variablen und Datentypen</h1>
        <h2>Datentypen für Variablen</h2>
        <p>
            PHP benutzt sog. Variablen, um Werte zu speichern und weiter zu verarbeiten.
            Diese Variablen können mit einer bestimmten Art von Werten umgehen. Hierzu gehören:
        </p>
        <ul>
            <li>Zeichenketten (String)</li>
            <li>Ganze Zahlen (Integer)</li>
            <li>Zahlen mit Nachkommastellen (Double/float)</li>
            <li>Felder (Array)</li>
            <li>Objekte</li>
            <li>Wahrheitswert (Boolean)</li>
        </ul>
        <p>
            Anders als in sog. Hochsprachen wird der Datentyp in PHP nicht vom Programmierer
            festgelegt, sondern richtet sich nach dem aktuellen Inhalt der Variable. So kann in einer
            Variable beispielsweise anfangs ein String stehen, später vielleicht aber ein Integer.
        </p>
        <h2>Namen bzw. Benennung von Variablen</h2>
        <p>
            Der Name einer Variablen in PHP beginnt immer mit einem Dollarzeichen ($).<br>
            Der Name selbst ist frei wählbar (solange er nicht gleichlautend mit vorbelegten PHP-Funktionen ist).
            Der Name kann aus großen und/oder kleinen Buchstaben, Ziffern und _ bestehen.<br>
            Der Name darf nicht mit einer Ziffer beginnen. Es gilt also:
        </p>
        <ul>
            <li>keine Leerzeichen</li>
            <li>keine Sonderzeichen außer _</li>
            <li>erlaubt sind Buchstaben (case sensitive) und Zahlen und _</li>
            <li>muss mit einem Buchstaben oder einem _ beginnen</li>
            <li>sollte "sprechend" und selbsterklärend sein (Name des Users: $username = gut; $u = schlecht)</li>
            <li>sollte aus Kleinbuchstaben oder aus einer Mischung aus Klein- und Großbuchstaben bestehen
            (keine reinen GROSSBUCHSTABEN, kein Großbuchstabe am Anfang)</li>
        </ul>

        <?php

            // Beispiell für Variablenname und Datentypen
            // Eine Variable wird in PHP zuerst deklariert (benannt)
            // und schließend mittels = initialisiert (mti einem Wert befüllt)

            $firstname = "Lars";
            $lastname = "Künzel";
            $name = $firstname . " " . $lastname;

            $age = 28;
            $amountOfCars = "1";
            $price = 199.98;
            $claim = "Lebe jeden Tag als wäre es dein letzter";
            $_ = "Echt doofer Variablenname";
            $isOnline = true;
            $isOffline = false;

            echo "<p>" . $name . "</p>";

            $is = 1;                    //true
            $is = 0;                    //false
            $is = -10.5;                //true
            $is = "irgendein Text";     //true
            $is = "";                   //true
            $is = "0";                  //Sonderfall true
            $is = "00";                 //true
            $is = "false";              //true
            $is = NULL;                 //false
            $is = true;                 //true
            $is = false;                //false


            // Unterschied zwischen doppelten " und einfachen ':
            // Alles, was zwischen ' und ' steht, wird als reiner String angesehen und
            // mittels echo entsprechend 1:1 ausgegeben
            echo '<p>Variable $firstname: $firstname</p>';

            // Innerhalb von " und " können einfache Variablenwerte direkt als Wert ausgegeben
            // (interpretiert) werden
            echo "<p>Variable $firstname: $firstname</p>";

            // Sollen innerhalb von ' und ' Variablenwerte ausgegeben werden, muss der String
            // konkateniert (aneinandergereiht) werden
            echo '<p>Variable $firstname: ' . $firstname . '</p>';

            // Soll eine Variable innerhalb von " und " nicht als Wert interpretiert werden,
            // muss sie mittels \ maskiert werden
            echo "<p>Variable \$firstname: $firstname</p>";

            echo "<p>Variable \$lastname: $lastname</p>";
            echo "<p>Variable \$age: $age</p>";
            echo "<p>Variable \$amountOfCars: $amountOfCars</p>";
            echo "<p>Variable \$price: $price</p>";
            echo "<p>Variable \$claim: $claim</p>";
            echo "<p>Variable \$isOnline: $isOnline</p>";
            echo "<p>Variable \$isOffline: $isOffline</p>";

        ?>

        <h3>Rechnen mit dem Datentyp Number (Integer/Float)</h3>
        <?php
            $zahl1 = 5; // Datentyp Integer
            $zahl2 = 10; // Datentyp Integer

            // Addition
            $ergebnis = $zahl1 + $zahl2;
            echo "<p>Rechenoperation: $zahl1 + $zahl2</p>";
            echo "<p>Ergebnis: <u>$ergebnis</u></p>";
            echo "<p>- - -</p>";

            // Subtraktion
            $ergebnis = $zahl1 - $zahl2;
            echo "<p>Rechenoperation: $zahl1 - $zahl2</p>";
            echo "<p>Ergebnis: <u>$ergebnis</u></p>";
            echo "<p>- - -</p>";

            // Multiplikation
            $ergebnis = $zahl1 * $zahl2;
            echo "<p>Rechenoperation: $zahl1 * $zahl2</p>";
            echo "<p>Ergebnis: <u>$ergebnis</u></p>";
            echo "<p>- - -</p>";

            // Division
            $ergebnis = $zahl1 / $zahl2;
            echo "<p>Rechenoperation: $zahl1 / $zahl2</p>";
            echo "<p>Ergebnis: <u>$ergebnis</u></p>"; // Datentyp hat sich von Integer auf Float geändert
            echo "<p>- - -</p>";
        ?>


    </body>
</html>
