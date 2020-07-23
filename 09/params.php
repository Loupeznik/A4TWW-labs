<?php

class db {

    public function connect() {
        
        $user = 'pgtestuser';
        $pwd = 'pgtestpw';

        $dbc = new PDO('pgsql:host=localhost;dbname=pgtestdb', $user, $pwd);

        return $dbc;

    }

    public function getData() {

        $dbc = $this->connect();

        foreach($dbc->query('SELECT * FROM c09') as $row) {
            print '<p><b>' . substr($row['cas'], 0, -7) . '</b> ' . $row['jmeno'] . ' ' . $row['email'] . ' ' . $row['komentar'] . '</p>';
        }

    }

    public function insertData($jmeno,$email,$text) {

        $dbc = $this->connect();

        if (strlen($jmeno) || strlen($email) > 30) {
            print '<div class="alert alert-danger">Komentář nebylo možné přidat, překročen limit znaků u jména či emailu</div>';
        } else {
            $stmt = 'INSERT INTO c09 (id, jmeno, email, komentar, cas) VALUES (DEFAULT, ?, ?, ?, CURRENT_TIMESTAMP)'; //ID - SERIAL (PK, A_I); Jmeno, Email - VARCHAR(30); Komentar - FULLTEXT; Cas - TIMESTAMP
            $dbc->prepare($stmt)->execute([$jmeno,$email,$text]);
            print '<div class="alert alert-success">Komentář úspěšně přidán</div>';
        }

    }

}

