<?php

$dbh = new PDO('mysql:host=localhost;dbname=todolist', "root", "oui");

if (isset($_POST["todo"])) {
    for ($i = 0; $i < count($_POST["todo"]); $i++) {
        $dbh->query('INSERT INTO `tasks`(`value`, `list`) VALUES ("' . $_POST["todo"][$i] . '","todo")');
    }
}

if (isset($_POST["done"])) {
    for ($i = 0; $i < count($_POST["done"]); $i++) {
        $dbh->query('INSERT INTO `tasks`(`value`, `list`) VALUES ("' . $_POST["done"][$i] . '","done")');
    }
}

var_dump($_POST);
