<?php

header('Content-Type: multipart/form-data;');
require("dbconnection.php");

$method = $_SERVER['REQUEST_METHOD'];
echo ($method);

print_r($_POST);
print_r($_REQUEST);


if ($method == 'DELETE') {
    $inputId= $_GET['id'];
    echo ('method delete id=' + $inputId);

    try {
        $req = $pdo->prepare("DELETE FROM `artwork` WHERE id=:inputId");
        $req->bindValue(':inputId', $inputId, PDO::PARAM_INT);
        $req->execute();
        echo $req->debugDumpParams();
    } catch (Exception $e) {

        die('Erreur : ' . $e->getMessage());
    }
}

print_r($updatedArtwork);
if ($_POST['_method'] == 'PUT') {
    $updatedArtwork = json_decode($_POST['updatedArtwork'], true);


    try {

        $req = $pdo->prepare("UPDATE `artwork` SET `src`=:src,`name`=:inputName,`height`=:height,`width`=:width,`caption`=:caption,`optional_info`=:optionalInfo,`year`=:inputYear WHERE id=:inputId");
        $req->bindValue(':src', $updatedArtwork['src'], PDO::PARAM_STR);
        $req->bindValue(':inputName',  $updatedArtwork['name'], PDO::PARAM_STR);
        $req->bindValue(':height',  $updatedArtwork['height'], PDO::PARAM_INT);
        $req->bindValue(':width',  $updatedArtwork['width'], PDO::PARAM_INT);
        $req->bindValue(':caption',  $updatedArtwork['caption'], PDO::PARAM_STR);
        $req->bindValue(':optionalInfo',  $updatedArtwork['optional_info'], PDO::PARAM_STR);
        $req->bindValue(':inputYear',  $updatedArtwork['year'], PDO::PARAM_INT);
        $req->bindValue(':inputId',  $updatedArtwork['id'], PDO::PARAM_INT);
        $req->execute();
    } catch (Exception $e) {

        die('Erreur : ' . $e->getMessage());
    }
}
echo 'done';
