<?php
    $select = $_GET['sel'];
    $num1 = $_GET['num1'];
    $num2 = $_GET['num2'];
?>
<html>
<head>
<meta charset="UTF-8">
<title>Kalkulačka</title>
<style>
    red {
        color: red;
        font-weight: bold;
    }
</style> 

</head>
<body>
<!--Formulář -->
<fieldset>
    <legend>Kalkulačka</legend>
    <form method="GET" action="">
        <input type="number" name="num1" value="<?php if (($select == 'deleno' && $num2 == 0) || empty($num2)) print $num1?>">
        <select name="sel">
            <option value="plus">Sčítání (+)</option>
            <option value="minus">Odčítání (-)</option>
            <option value="krat">Násobení (*)</option>
            <option value="deleno">Dělení (/)</option>
        </select>
        <input type="number" name="num2" value="<?php if (($select == 'deleno' && $num2 == 0) || empty($num1)) print $num2?>">
        <input type="submit" value="Vypočítat" name="submit">
    </form>
</fieldset>
<!--Výsledek -->
<fieldset>
    <legend>Výsledek</legend>
    <?php
        if ($_GET['submit']) {
            if ($select == 'deleno' && $num2 == 0) {
                print '<red>Nelze dělit nulou</red>';
            } else if (empty($num1) || empty($num2)) {
                print '<red>Nebyla zadána jedna z hodnot</red>';
            } else {
                switch($select) {
                    case 'plus':
                        print $num1 . '+' . $num2 . ' = ';
                        print $num1 + $num2;
                        break;
                    case 'minus':
                        print $num1 . '-' . $num2 . ' = ';
                        print $num1 - $num2;
                        break;
                    case 'krat':
                        print $num1 . '*' . $num2 . ' = ';
                        print $num1 * $num2;
                        break;
                    case 'deleno':
                        print $num1 . '/' . $num2 . ' = ';
                        print $num1 / $num2;
                        break;
                }
            }

        }
    ?>
</fieldset>
</body>
</html>