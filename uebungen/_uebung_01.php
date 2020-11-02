<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Übung Tag 1</title>
</head>
<body>

    <h1>Übung Tag 1</h1>
    <h3>Hundenamen</h3>

    <?php

        $owner1 = "Ingmar";
        $owner2 = "Karl-Hors";
        $owner3 = "Ella";
        $dog1 = "Paul";
        $dog2 = "Lumpi";
        $dog3 = "Pfiffi";
        $ageDog1 = 5;
        $ageDog2 = 12;
        $ageDog3 = 7;
        $width = "150px";

        echo "<table style='text-align: center'>";
        echo    "<thead>";
        echo        "<tr>";
        echo            "<th style='width:".$width."'>Name des Halters</th>";
        echo            "<th style='width:".$width."'>Name des Hundes</th>";
        echo            "<th style='width:".$width."'>Altes des Hundes</th>";
        echo        "</tr>";
        echo    "</thead>";
        echo    "<tbody>";
        echo        "<tr>";
        echo            "<td>\$owner1: $owner1</td>";
        echo            "<td>\$dog1: $dog1</td>";
        echo            "<td>\$ageDog1: $ageDog1</td>";
        echo        "</tr>";
        echo        "<tr>";
        echo            "<td>\$owner3: $owner3</td>";
        echo            "<td>\$dog2: $dog2</td>";
        echo            "<td>\$ageDog2: $ageDog2</td>";
        echo        "</tr>";
        echo        "<tr>";
        echo            "<td>\$owner3: $owner3</td>";
        echo            "<td>\$dog3: $dog3</td>";
        echo            "<td>\$ageDog3: $ageDog3</td>";
        echo        "</tr>";
        echo    "</tbody>";
        echo "</table>";

    ?>

    <h3>Übung Rechenarten</h3>

    <?php
        $zahl1 = 10;
        $zahl2 = 50;
        $zahl3 = 0.75;

        $r1 = $zahl2 - $zahl1 * 10;
        $r2 = ($zahl2 - $zahl1) * 10;
        $r3 = $zahl1 + $zahl2 * 3;
        $r4 = ($zahl1 + $zahl2) *3;
        $r5 = $zahl1 + ($zahl2*3);
        $r6 = $zahl1 * $zahl3;
        $r7 = $zahl2 / $zahl3 + $zahl1;
        $r8 = $zahl2 / ($zahl3 + $zahl1);

        echo "<p> Ergebnis 1: ".$r1."</p>";
        echo "<p> Ergebnis 2: ".$r2."</p>";
        echo "<p> Ergebnis 3: ".$r3."</p>";
        echo "<p> Ergebnis 4: ".$r4."</p>";
        echo "<p> Ergebnis 5: ".$r5."</p>";
        echo "<p> Ergebnis 6: ".$r6."</p>";
        echo "<p> Ergebnis 7: ".$r7."</p>";
        echo "<p> Ergebnis 8: ".$r8."</p>";
    ?>

</body>
</html>
