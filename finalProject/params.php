<?php

//DEFINES
define("formHandler",$_POST['submit']);
define("pageRefresher","<meta http-equiv='refresh' content='0'>");

//PARAMS
$year = date('Y');

//FUNKCE
function showPage($pageID) {
    
    if (file_exists('pages/' . $pageID . '.php')) {
        include 'pages/' . $pageID . '.php';
    } else {
        echo '<p class="text-danger font-weight-bold text-center" style="margin-top: 50px">Stránka nebyla nalezena</p>';
    }

}
