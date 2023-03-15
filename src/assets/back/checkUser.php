<?php
require("dbconnection.php");
$pwd = $_GET['pwd'];
echo $pwd;
$hash='';
try {
    $response = $pdo->query("SELECT * FROM `user` WHERE name= 'admin';");

    while ($data = $response->fetch()) { 
    echo $data;
    echo $data['name'];
    $hash=$data['password'];
    }
    
if (password_verify($pwd,  $hash)) {
echo 'ok tu peux passer';

}
else {http_response_code(500);}

} catch (Exception $e) {


    die('Erreur : ' . $e->getMessage());
}

