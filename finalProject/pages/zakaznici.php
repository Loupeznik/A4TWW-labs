<?php
$db = new db();
?>
<h1>Výpis zákazníků</h1>
<?php 
if (!$db->checkRecords('db')) print '<div class="alert alert-danger">Databáze nebyla nalezena, první je nutné ji vytvořit, to lze provést na úvodní straně.</div>';
if ($db->checkRecords('table') && $db->checkRecords('data')) {
?>
<form method="POST" class="form-inline">
        <select name="sort" class="form-control">
            <option value="jmeno desc">Třídit dle jména sestupně</option>
            <option value="jmeno asc">Třídit dle jména sestupně</option>
            <option value="prijmeni desc">Třídit dle příjmení sestupně</option>
            <option value="prijmeni asc">Třídit dle příjmení vzestupně</option>
            <option value="bydliste desc">Třídit dle bydliště sestupně</option>
            <option value="bydliste asc">Třídit dle bydliště vzestupně</option>
            <option value="mesto desc">Třídit dle města sestupně</option>
            <option value="mesto asc">Třídit dle města vzestupně</option>
            <option value="psc desc">Třídit dle PSČ sestupně</option>
            <option value="psc asc">Třídit dle PSČ vzestupně</option>
        </select>
        <input type="submit" class="btn btn-primary" value="Třídit" name="submitSort">
</form>
<div class="table-responsive">
    <table class="table">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Jméno</th>
            <th scope="col">Příjmení</th>
            <th scope="col">Bydliště</th>
            <th scope="col">Město</th>
            <th scope="col">PSČ</th>
            <th scope="col">Akce</th>
        </tr>
        <tbody>
            <?php
            if (isset($_POST['submitSort'])) $db->getData($_POST['sort']); else $db->getData(NULL);
            ?>
        </tbody>
    </table>
</div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRecord">Přidat zákazníka</button>
<div class="modal fade" id="addRecord" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Přidat záznam</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST">
                Jméno: <input type="text" class="form-control" name="jmeno" required><br>
                Příjmení: <input type="text" class="form-control" name="prijmeni" required><br>
                Ulice: <input type="text" class="form-control" name="ulice" required><br>
                Číslo popisné: <input type="number" class="form-control" name="cp" required><br>
                Město: <input type="text" class="form-control" name="mesto" required><br>
                PSČ: <input type="number" class="form-control" name="psc" required><br>
                <input type="submit" name="submit" class="btn btn-primary" value="Vložit záznam">
            </form>
            <?php if (formHandler) $db->insertRecord($_POST['jmeno'],$_POST['prijmeni'],$_POST['ulice'],$_POST['cp'],$_POST['mesto'],$_POST['psc']); ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Zrušit</button>
        </div>
        </div>
    </div>
</div>
<?php
    if ($_GET['zakaznikID']) include 'pages/detail.php';
} else {
    if (!$db->checkRecords('table')) {
?>
<div class="alert alert-danger">
    <p>Tabulka Zákazníci nebyla nalezena, chcete ji vytvořit?</p>
    <form method="POST">
        <input type="submit" class="btn btn-success" value="Vytvořit tabulku" name="submit">
    </form>
</div>
<?php
if (formHandler) {
    try {
        $db->dbConstruct();
        print pageRefresher;
    } catch (Exception $e) {
        print 'Nastala chyba' . $e->getMessage();
    }
}
    } else if ($db->checkRecords('table') && !$db->checkRecords('data')) {
?>
<div class="alert alert-danger">
    <p>Tabulka zákazníci neobsahuje žádná data, chcete ji naplnit ukázkovými daty?</p>
    <form method="POST">
        <input type="submit" class="btn btn-success" value="Naplnit tabulku" name="submit">
    </form>
</div>
<?php
if (formHandler) {
    try {
        $db->dbFill();
        print pageRefresher;
    } catch (Exception $e) {
        print 'Nastala chyba' . $e->getMessage();
    }
}
    } else {
        print 'Něco se stalo';
    }
}
?>
