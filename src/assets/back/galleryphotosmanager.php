<?php

header('Content-Type: multipart/form-data;');
require("dbconnection.php");

$method = $_SERVER['REQUEST_METHOD'];


//print_r($_POST);
//print_r($_REQUEST);


if ($method == 'DELETE') {
    $inputId = $_GET['id'];
    echo ('method delete id=' + $inputId);

    try {
        $req = $pdo->prepare("DELETE FROM `expo_photo` WHERE id=:inputId");
        $req->bindValue(':inputId', $inputId, PDO::PARAM_INT);
        $req->execute();
        echo $req->debugDumpParams();




        //Delete corresponding img file:
        $filename = "../img/expos/";
        $filename = $filename . $updatedPhoto['id'];
       $deleteSuccess= unlink($filename);

       echo "$filename delete sucess: $deleteSuccess";
    } catch (Exception $e) {
        echo $e->getMessage();
        http_response_code(417);
        die('Erreur : ' . $e->getMessage());
    }
}


if ($_POST['_method'] == 'PUT') {
    $updatedPhoto = json_decode($_POST['updatedPhoto'], true);
    print_r($updatedPhoto);
    echo '$$$$$$$$$$$$%%%%%%%%%%\\\\\\\\';

    print_r($updatedPhoto['expo_names'][0]['text']);

    try {

        $req = $pdo->prepare("UPDATE `expo_photo` SET curator_name=:curator_name, expo_name=:expo_name WHERE id=:inputId");
        $req->bindValue(':curator_name', $updatedPhoto['curator_name'], PDO::PARAM_STR);
        $req->bindValue(':expo_name',  $updatedPhoto['expo_name'], PDO::PARAM_STR);

        $req->bindValue(':inputId',  $updatedPhoto['id'], PDO::PARAM_INT);
        $req->execute();

        //Set expo_name propositions in DB

    } catch (Exception $e) {
        echo $e->getMessage();
        http_response_code(417);
        die('Erreur : ' . $e->getMessage());
    }
    echo 'put done';
}


if ($method == 'GET') {

    try {
        $photos = array();

        $response = $pdo->query('SELECT * FROM question  ORDER BY  id DESC;');

        while ($questionData = $response->fetch()) {
            $photos[] = $questionData;
        }
        $arrayObject = json_encode($photos);
        echo ($arrayObject);
    } catch (Exception $e) {
        echo $e->getMessage();
        http_response_code(417);
        die('Erreur : ' . $e->getMessage());
    }
}
