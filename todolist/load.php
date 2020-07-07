<?php

$dbh = new PDO('mysql:host=localhost;dbname=todolist', "root", "oui");

$sth = $dbh->query("SELECT * FROM tasks");
$result = $sth->fetchall();

echo json_encode($result);