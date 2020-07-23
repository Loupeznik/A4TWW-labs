<?php

DEFINE('DBUSER','dbuser');
DEFINE('DBPW','dbuser1337');

class db {
    public function dbConnect() {

        try {
    
            $dbc = new PDO('mysql:host=localhost;dbname=projekt', DBUSER, DBPW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    
            //print 'debug'; //debug
            return $dbc;

        } catch (PDOException $e) {
            if ($e->getCode() == '1049') { //1049 - neznámá databáze
                //print $e->getMessage(); //debug
                return false;
            } else {
                //print $e->getMessage(); //debug
                print '<div class="alert alert-danger">Při připojování databáze nastala chyba.</div>';
            }
        }

    }

    public function dbCreate() { //vytvoření databáze

        try {
            $dbc = new PDO('mysql:host=localhost', DBUSER, DBPW);
            $dbc->exec('CREATE DATABASE projekt');
            
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Při tvorbě databáze nastala chyba: ' . $e->getMessage() . '</div>';
        }

    }

    public function dbConstruct() { //vytvoření tabulky

        $dbc = $this->dbConnect();
        $query = 'CREATE TABLE zakaznici (zakaznikID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, jmeno VARCHAR(30) NOT NULL, prijmeni VARCHAR(30) NOT NULL, bydliste VARCHAR(50) NOT NULL, mesto VARCHAR(30) NOT NULL, psc INT NOT NULL) CHARACTER SET utf8 COLLATE utf8_unicode_ci';

        try {
            $dbc->exec($query);
        } catch (PDOException $e) {
            print '<div class="alert alert-danger">Nepodařilo se vytvořit tabulku Zákazníci.</div>';
            //print $e->getMessage();
        }

    }

    public function dbFill() { //naplnění databáze ukázkovými daty

        $dbc = $this->dbConnect();

        try {
            $sql = file_get_contents('files/data.sql');
            $dbc->exec($sql);
        } catch (PDOException $e) {
            print '<div class="alert alert-danger">Nepodařilo se naplnit tabulku Zákazníci.</div>';
            //print $e->getMessage();
        }

    }

    public function checkRecords($type) { //kontroluje, zda existuje tabulka Zakaznici, případně zda v ní existují data
        
        $dbc = $this->dbConnect();
        
        if ($type == 'table') {
            try {
                $res = $dbc->query('SELECT 1 FROM zakaznici');
                if ($res) return true; else return false;
            } catch (Exception $e) {
                return false;
            }
        } else if ($type == 'data') {
            $res = $dbc->prepare('SELECT zakaznikID FROM zakaznici');
            $res->execute();
            $count = $res->rowCount();
            if ($count > 0) return true; else return false;
        } else if ($type == 'db') {
            if ($this->dbConnect()) return true; else return false;
        } else die();
    }

    public function getData($orderby) { //získání dat z databáze

        $dbc = $this->dbConnect();

        if ($orderby == NULL) $orderby = 'zakaznikID ASC';

        foreach($dbc->query('SELECT * FROM zakaznici ORDER BY ' . $orderby) as $row) {
            print 
            '<tr><td>' . $row['zakaznikID'] .'</td><td>' . $row['jmeno'] . '</td><td>' . $row['prijmeni'] . '</td><td>' . $row['bydliste'] . '</td><td>' . $row['mesto'] . 
            '</td><td>' . $row['psc'] . '</td><td><a href="index.php?'. http_build_query(array_merge($_GET, array('zakaznikID'=>$row['zakaznikID']))) . '#card">
            <button class="btn btn-outline-info btn-sm">Zobrazit záznam</button></a></td></tr>';
            //print var_dump($dbc->query('SELECT * FROM zakaznici ORDER BY ' . $orderby));
        }

    }

    public function getDataSearch($param,$input) { //získání dat z databáze dle parametrů vyhledávání

        $dbc = $this->dbConnect();
        $input = trim($input);
        $param = trim($param);
        $input = '%' . $input . '%';

        $stmt = $dbc->prepare('SELECT * FROM zakaznici WHERE ' . $param . ' LIKE :input');
        $stmt->execute(['input' => $input]);
        $res = $stmt->fetchAll();
        if (empty($res)) {
            print '<div class="alert alert-danger">Zákazník neexistuje</div>';
            //print $param . '<br>' . $input; //debug
        } else {
            foreach ($res as $row) {
                print 
                '<tr><td>' . $row['zakaznikID'] .'</td><td>' . $row['jmeno'] . '</td><td>' . $row['prijmeni'] . '</td><td>' . $row['bydliste'] . '</td><td>' . $row['mesto'] . 
                '</td><td>' . $row['psc'] . '</td><td><a href="index.php?'. http_build_query(array_merge($_GET, array('zakaznikID'=>$row['zakaznikID']))) . '#card">
                <button class="btn btn-outline-info btn-sm">Zobrazit záznam</button></a></td></tr>';
            }
        }

    }

    public function insertRecord($jmeno,$prijmeni,$ulice,$cp,$mesto,$psc) { //vložení záznamu do databáze

        $dbc = $this->dbConnect();

        $bydliste = $ulice . ' ' . $cp;

        $regex = $jmeno . $prijmeni . $mesto;

        if (!preg_match("/[0-9]+/", $regex)) {

            try {
                $query = 'INSERT INTO zakaznici VALUES (NULL,?,?,?,?,?)';
                $dbc->prepare($query)->execute([$jmeno,$prijmeni,$bydliste,$mesto,$psc]);
                print '<script>alert("Zákazník úspěšně přidán")</script>';
                print pageRefresher;
            } catch(PDOException $e) {
                print '<script>alert("Nastala chyba: ' . $e->getMessage() . '")</script>';
            }

        } else {
            print '<div class="alert alert-danger">Některé z polí (jméno, příjmení, město) obsahují nepovolené znaky, pokuste se záznam opravit.</div>';
        }

    }

    public function deleteRecord($id) { //odstranění záznamu z databáze

        $dbc = $this->dbConnect();

        try {
            $query = 'DELETE FROM zakaznici WHERE zakaznikID = ?';
            $dbc->prepare($query)->execute([$id]);
            print '<script>alert("Zákazník úspěšně odebrán")</script>';
            print pageRefresher;
        } catch(PDOException $e) {
            print '<script>alert("Nastala chyba: ' . $e->getMessage() . '")</script>';
        }

    }

    public function showRecord($id,$type) { //zobrazení podrobností o záznamu

        $dbc = $this->dbConnect();

        if ($type == 'show') $form = 'disabled'; else $form = '';

        $query = $dbc->prepare('SELECT * FROM zakaznici WHERE zakaznikID = ?');
        $query->execute([$id]);

        foreach($query->fetchAll() as $row) {
            print '
            <h5 class="card-title">Podrobnosti zákazníka</h5>
            <p class="card-text">
            <form method="POST" id="detail">
                <div class="form-group">
                    <label>Jméno</label>
                    <input class="form-control card-form" type="text" placeholder="Křestní jméno" value="' . $row['jmeno'] . '" name="updateJmeno" required ' . $form . '>
                </div>
                <div class="form-group">
                    <label>Příjmení</label>
                    <input class="form-control card-form" type="text" placeholder="Příjmení" value="' . $row['prijmeni'] . '" name="updatePrijmeni" required ' . $form . '>
                </div>
                <div class="form-group">
                    <label>Bydliště</label>
                    <input class="form-control card-form" type="text" placeholder="Bydliště" value="' . $row['bydliste'] . '" name="updateBydliste" required ' . $form . '>
                </div>
                <div class="form-group">
                    <label>Město</label>
                    <input class="form-control card-form" type="text" placeholder="Město" value="' . $row['mesto'] . '" name="updateMesto" required ' . $form . '>
                </div>
                <div class="form-group">
                    <label>Město</label>
                    <input class="form-control card-form" type="number" placeholder="PSČ" value="' . $row['psc'] . '" name="updatePsc" required ' . $form . '>
                </div>';
                if ($form == '') {
                    print '
                    <input type="submit" class="btn btn-primary" value="Aktualizovat údaje zákazníka" name="submitUpdate">
                    ';
                }
                print '</form></p>';
                if($_POST['submitUpdate']) $this->updateRecord($id,$_POST['updateJmeno'],$_POST['updatePrijmeni'],$_POST['updateBydliste'],$_POST['updateMesto'],$_POST['updatePsc']);
        }

    }

    private function updateRecord($id,$jmeno,$prijmeni,$bydliste,$mesto,$psc) { //aktualizace záznamu

        $dbc = $this->dbConnect();
        
        $regex = $jmeno . $prijmeni . $mesto;

        if (!preg_match("/[0-9]+/", $regex)) {

            try {
                $query = 'UPDATE zakaznici SET jmeno = ?, prijmeni = ?, bydliste = ?, mesto = ?, psc = ? WHERE zakaznikID = ?';
                /*$res = */$dbc->prepare($query)->execute([$jmeno,$prijmeni,$bydliste,$mesto,$psc,$id]);
                //print var_dump($res); //debug
                print pageRefresher;
            } catch(PDOException $e) {
                print '<script>alert("Nastala chyba: ' . $e->getMessage() . '")</script>';
            }

        } else { 
        print '<div class="alert alert-danger">Některé z polí (jméno, příjmení, město) obsahují nepovolené znaky, pokuste se záznam opravit.</div>';
        }
    
    }

    public function showColumn($id,$col) { //zobrazení dat pouze jednoho sloupce a záznamu

        $dbc = $this->dbConnect();

        $query = $dbc->prepare('SELECT ' . $col . ' FROM zakaznici WHERE zakaznikID = ?');
        $query->execute([$id]);

        foreach($query->fetchAll() as $row) {
            return $row[$col];
        }

    }

    public function showRecordID($id) { //vypsat jediný záznam

        $dbc = $this->dbConnect();

        $query = $dbc->prepare('SELECT * FROM zakaznici WHERE zakaznikID = ?');
        $query->execute([$id]);

        foreach($query->fetchAll() as $row) {
            print 
            '<tr><td>' . $row['zakaznikID'] .'</td><td>' . $row['jmeno'] . '</td><td>' . $row['prijmeni'] . '</td><td>' . $row['bydliste'] . '</td><td>' . $row['mesto'] . 
            '</td><td>' . $row['psc'] . '</td><td><a href="index.php?'. http_build_query(array_merge($_GET, array('zakaznikID'=>$row['zakaznikID']))) . '#card">
            <button class="btn btn-outline-info btn-sm">Zobrazit záznam</button></a></td></tr>
            ';
        }

    }

}
