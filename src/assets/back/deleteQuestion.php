<?php


header('Access-Control-Allow-Origin: *');
require("dbconnection.php");


echo "<html><head><title>test</title></head><body>sssss";

$id=$_POST['id'];

echo('delete'.$id);
try {
    //insert question into DB
    $req = $pdo->prepare('DELETE FROM `question_answer` WHERE question_id=:selectedId');
    $req->execute(array(
        'selectedId' => $id,
    ));
    $req = $pdo->prepare('DELETE FROM `question` WHERE id=:selectedId');
    $req->execute(array(
        'selectedId' => $id,
    ));
    
} catch (Exception $e) {
    echo $e->getMessage();
    http_response_code(520);
    die();
}

