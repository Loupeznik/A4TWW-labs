<?php
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
require_once 'params.php';
$db = new db();
?>

<html>
<head>
<title>Úkol cvičení 11</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">Výpis návštěvníků</h1>
    <div class="container">
    <form method="POST" action="">
        <input type="submit" name="submitAll" value="Zobrazit seznam všech návštěvníků" class="btn btn-primary" style="width: 100%; margin-bottom: 15px;"><br>
        Vyhledat návštěvníka dle jména či příjmení:<br> 
        <input type="text" name="input" class="form-control"><br><input type="submit" name="submitValue" value="Vyhledat návštěvníka" class="btn btn-primary">
    </form>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Jméno</th>
                <th scope="col">Příjmení</th>
                <th scope="col">Email</th>
            </tr>
            <tbody>
            <?php
                if ($_POST['submitAll']) $db->getData(); else if ($_POST['submitValue'] && $_POST['input']) $db->getDataSearch($_POST['input']);
            ?>
            </tbody>
        </table>
    </div>
    </div>
    <h2 class="text-center">Vložit nového návštěvníka</h2>
    <div class="container">
    <form method="POST" action="">
        Jméno: <input type="text" name="jmeno" class="form-control" required> <br>
        Příjmení: <input type="text" name="prijmeni" class="form-control" required> <br>
        Email: <input type="email" name="mail" class="form-control"> <br>
        <input type="submit" name="submit" class="btn btn-primary" value="Odeslat">
    </form>
    <?php
        if ($_POST['submit']) $db->insertData($_POST['jmeno'],$_POST['prijmeni'],$_POST['email']);
    ?>
    </div>
</body>
</html>
