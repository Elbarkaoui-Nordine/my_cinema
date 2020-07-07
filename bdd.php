<?php
try{
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=cinema','root',"",[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}