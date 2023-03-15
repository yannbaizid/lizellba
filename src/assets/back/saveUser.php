<?php
require("dbconnection.php");
$pwd = $_GET['pwd'];
$name = $_GET['name'];
$hash = password_hash($pwd, PASSWORD_DEFAULT);


try {
    $result_array = array();
    $req = $pdo->prepare('INSERT INTO `user`(`name`, `password` ) VALUES (:inputName, :inputPassword);');
    $req->execute(array(
        'inputName' => $name,
        'inputPassword' => $hash
    ));
} catch (Exception $e) {


    die('Erreur : ' . $e->getMessage());
}

