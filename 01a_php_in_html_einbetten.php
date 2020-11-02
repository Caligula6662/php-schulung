<!doctype html>

<html>
    <head>
        <meta charset="utf-8" />
        <title>PHP in HTML einbetten</title>
    </head>
    <body>
        <h1>PHP in HTML einbetten</h1>
        <p>Ein Absatz in HMTL</p>
        <?php
            // Einzeiliger Kommentar
            # Einzeiliger Kommentar
            /*
                Mehrzeiliger Kommentar
            */

            echo "<p>Ein Absatz in PHP</p>";
        ?>

        <h3>Listen in HTML und PHP</h3>
        <h4>Liste in HTML</h4>
        <ul>
            <li>Listenpunkt 1</li>
            <li>Listenpunkt 2</li>
            <li>Listenpunkt 3</li>
        </ul>

        <?php
            echo "<h4>Liste in PHP</h4>\n";
            /*
                STEUERZEICHEN:
                \n = new line
                \t = tabulator
                Steuerzeichen wirken sich in diesem Fall nur im Quellcode aus und
                dienen hier zur sauberen Einrückung des mittels PHP erzeugten HTML-Codes
            */
            echo "\t\t<ul>\n";
                echo "\t\t\t<li>Listenpunkt 1</li>\n";
                echo "\t\t\t<li>Listenpunkt 2</li>\n";
                echo "\t\t\t<li>Listenpunkt 3</li>\n";
            echo "\t\t</ul>";
        ?>

        <h3>Anführungszeichen innerhalb eines Strings ausgeben</h3>
        <p style="color: red">Ein Absatz in HTML mit einem Inline-Style...</p>

        <?php
            //1. Variante
            echo "<p style='color: red'>Ein Absatz in PHP mit einem Inline-Style...</p>";
            //2. Variante
            echo '<p style="color: blue">Ein Absatz in PHP mit einem Inline-Style...</p>';
            //3. Variante
            echo "<p style=\"color: green\">Ein Absatz in PHP mit einem Inline-Style...</p>";
        ?>
    </body>
</html>
