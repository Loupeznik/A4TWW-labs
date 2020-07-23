<?php
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
require_once 'params.php';
$db = new db();
?>

<html>
<head>
<title>Úkol cvičení 09</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">Kniha návštěv</h1>
    <div class="container">
        <form method="POST" action="">
                Jméno: <input type="text" name="jmeno" class="form-control" required> <br>
                Email: <input type="email" name="mail" class="form-control" required> <br>
                Komentář:<br> <textarea cols="20" rows="5" name="text" class="form-control" required></textarea> <br>
                <input type="submit" name="submit" class="btn btn-primary" value="Odeslat">
        </form>
        <?php
            if($_POST['submit'])  $db->insertData($_POST['jmeno'],$_POST['mail'],$_POST['text']);
        ?>
    </div>
    <h2 class="text-center">Komentáře</h2>
    <div class="container">
        <?php
        $db->getData();
        ?>
    </div>
</body>
</html>