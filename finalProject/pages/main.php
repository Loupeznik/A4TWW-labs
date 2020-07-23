<?php
$db = new db();
?>
<div class="row mt-3">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Aplikace</h5>
        <p class="card-text">Aplikace pracuje s MySQL databází a umožňuje vkládat, zobrazovat, upravovat, mazat a vyhledávat data zákazníků uložené v této databázi.<br><br>
        Pro předmět A4TWW na FAI UTB vytvořil Dominik Žárský<br>
        &copy; 2020
        </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Databáze</h5>
        <p class="card-text">Kliknutím na následující tlačítko aplikace zkontroluje existenci databáze se zákazníky. Pokud databáze existuje, můžete pokračovat na další sekce.
        Pokud databáze neexistuje, bude po kliknutí na ono tlačítko vytvořena.
        </p>
        <form method="POST">
            <input type="submit" class="btn btn-success" name="dbCheck" value="Zkontrolovat databázi">
        </form>
        <?php
        if ($_POST['dbCheck']) {
            if (!$db->dbConnect()) {
                try {
                    $db->dbCreate();
                    print '<div class="alert alert-success">Databáze byla vytvořena.</div>';
                } catch (Exception $e) {
                    print '<div class="alert alert-danger">Databázi se nepodařilo vytvořit (Chyba: ' . $e->getMessage() . ').</div>';
                }
            } else print '<div class="alert alert-info">Databáze již existuje, můžete pokračovat do dalších sekcí.</div>';
        } ?>
      </div>
    </div>
  </div>
</div>
