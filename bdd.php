<?php

try{
    $dbh = new PDO('mysql:host=eu-cdbr-west-03.cleardb.net;dbname=my_cinema','b343eb1c6f7662',"fd1f61ad",[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}