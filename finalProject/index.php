<?php
include 'db.php';
include 'params.php';

$page = $_GET['strana'];
if (!isset($_GET['strana'])) $page = 'main';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>A4TWW - Projekt PHP</title>
<meta author="Dominik Zarsky">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="files/search.webp" rel="shortcut icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="styly.css">
<link href="main.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="jumbotron">
  <h1 class="display-4">Aplikace pro práci nad databází zákazníků</h1>
  <p class="lead">Aplikace pro projekt do předmětu A4TWW - <i>Technologie WWW</i></p>
</div>
    <nav>
        <ul class="nav nav-tabs nav-fill">
            <li class="nav-item"><a class="nav-link <?php if($page == 'main') print 'active'; ?>" href="index.php?strana=main">Hlavní strana</a></li>
            <li class="nav-item"><a class="nav-link <?php if($page == 'zakaznici') print 'active'; ?>" href="index.php?strana=zakaznici">Výpis zákazníků</a></li>
            <li class="nav-item"><a class="nav-link <?php if($page == 'search') print 'active'; ?>" href="index.php?strana=search">Vyhledávání zákazníků</a></li>
        </ul>
    </nav>

    <div class="container">
        <?php
            showPage($page);
        ?>
        
    </div>
<!--
    <footer class="fixed-bottom bg-dark" id="ftr">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <p class="footerText">&copy; <?php //print $year; ?> Dominik Žárský <br>
                        Dynamická webová prezentace vytvořena pro předmět A4TWW
                    </p> 
                </div>
            </div>    
        </footer>
-->
</body>

</html>
