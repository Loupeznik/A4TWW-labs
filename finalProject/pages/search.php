<?php
$db = new db();
?>
<h1>Vyhledávání zákazníků</h1>
<?php if (!$db->checkRecords('db')) print '<div class="alert alert-danger">Databáze nebyla nalezena, první je nutné ji vytvořit, to lze provést na úvodní straně.</div>'; 
if ($db->checkRecords('table') && $db->CheckRecords('data')) {
?>
<form method="POST">
    <div class="form-group">
        <label>Vyhledávat dle: </label>
        <select name="param" class="form-control" required>
            <option value='jmeno'>Jméno</option>
            <option value='prijmeni' selected>Příjmení</option>
            <option value='bydliste'>Ulice</option>
            <option value='mesto'>Město</option>
        </select>
    </div>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="searchIcon"><img src="files/search.webp" width="24px"></span>
        </div>
        <input type="text" class="form-control" name="input" placeholder="Vyhledávaná fráze" aria-label="input" aria-describedby="searchIcon" required>
        <input type="submit" name="submit" class="btn btn-primary" value="Vyhledat">
    </div>
    
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
            <?php if (formHandler) $db->getDataSearch($_POST['param'],$_POST['input']); ?>
            <?php if($_GET['zakaznikID'] && !formHandler) $db->showRecordID($_GET['zakaznikID']); ?>
            </tbody>
        </table>
    </div>

<?php if ($_GET['zakaznikID'] && !formHandler) include 'pages/detail.php'; 
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
        print 'Nepředvídatelný error';
    }
}
?>
