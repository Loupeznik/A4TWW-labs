<?php

class db {

    public function connect() {
        
        $user = 'user';
        $pwd = 'user123';

        $dbc = new PDO('mysql:host=localhost;dbname=MyGuests', $user, $pwd);

        return $dbc;

    }

    public function getData() {

        $dbc = $this->connect();

        foreach($dbc->query('SELECT * FROM MyGuests') as $row) {
            print '<tr><td>' . $row['id'] .'</td><td>' . $row['firstname'] . '</td><td>' . $row['lastname'] . '</td><td>' . $row['email'] . '</td></tr>';
        }

    }

    public function getDataSearch($input) {

        $dbc = $this->connect();
        $input = trim($input);

        /*foreach($dbc->prepare($stmt)->execute(['input' => $input])->fetch() as $row) { //nefunguje, zkusit postupně
            print '<tr><td>' . $row['id'] .'</td><td>' . $row['firstname'] . '</td><td>' . $row['lastname'] . '</td><td>' . $row['email'] . '</td></tr>';
        }*/

        $stmt = $dbc->prepare("SELECT * FROM MyGuests WHERE firstname LIKE :input OR lastname LIKE :input");
        $stmt->execute(['input' => $input]); 
        $output = $stmt->fetchAll();
        if (empty($output)) {
            print '<div class="alert alert-danger">Návštěvník neexistuje</div>';
        } else {
            foreach ($output as $row) {
                print '<tr><td>' . $row['id'] .'</td><td>' . $row['firstname'] . '</td><td>' . $row['lastname'] . '</td><td>' . $row['email'] . '</td></tr>';
            }
        }
 
    }

    public function insertData($firstname,$lastname,$email) {

        $dbc = $this->connect();

            if (strlen($firstname) > 30 || strlen($lastname) > 30 || strlen($email) > 50) {
                print '<div class="alert alert-danger">Zadané údaje přesahují limit znaků, zkontrolujte délku zadaných údajů</div>';
            } else {
                $stmt = 'INSERT INTO MyGuests VALUES (NULL, ?, ?, ?)';
                $dbc->prepare($stmt)->execute([$firstname,$lastname,$email]);
                print '<div class="alert alert-success">Záznam úspěšně uložen</div>';
            }

    }

}
