<?php

try{
    $dbh = new PDO("mysql:host=eu-cdbr-west-03.cleardb.net;port=3306;dbname=my_cinema","b777649fa1ef37","ab0e71bd",[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}