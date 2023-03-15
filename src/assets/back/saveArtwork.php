<?php


header('Access-Control-Allow-Origin: *');
require("dbconnection.php");
require("cleanString.php");

echo "<html><head><title>test</title></head><body>sssss";

foreach ($_POST as $champ => $valeur) {
    echo "$champ = $valeur<br>";
}


print_r($_POST);

echo "<br>file: ";

if (isset($_FILES)) {
    echo "ok<br>";
} else {
    echo "no ok";
}
print_r($_FILES);

$imgLink = $_FILES['imgFile']['tmp_name'];


try {

    $artistresult = $pdo->prepare('SELECT `name`,surname FROM `artist` WHERE id=?;');
    $artistresult->execute(array($_POST['artistId']));
    $artistresult = $artistresult->fetch();
    $artist = $artistresult['surname'] . '_' . $artistresult['name'];
    echo "<br>artist:" . $artist;
    $artist = strtolower(cleanString($artist));
    echo "<br>" . $artist;



    $req = $pdo->prepare('INSERT INTO `artwork`(`src`, `name`, `height`, `width`, `caption`, `artist_id`, `expo_id`, `type_id`,`year` ) VALUES (:imgLink, :inputName, :height, :width, :caption,:artistId, :expoId, :typeId, :inputYear);');
    $req->execute(array(
        'imgLink' => $imgLink,
        'inputName' => $_POST['name'],
        'height' => $_POST['height'],
        'width' => $_POST['width'],
        'caption' => $_POST['caption'],
        'artistId' => $_POST['artistId'],
        'expoId' => $_POST['expoId'],
        'typeId' => $_POST['typeId'],
        'inputYear' => $_POST['year']

    ));

    $lastId = $pdo->lastInsertId();
} catch (Exception $e) {

    http_response_code(500);
    die('Erreur : ' . $e->getMessage());
}

$newImgLink = $artist . '/' . $_POST['typeId'] . "/" . $lastId . ".png";

try {
$dirPath='../img/artwork/';
    $mkdirSucess=mkdir($dirPath . $artist . '/' . $_POST['typeId'], 0777, true);
    if (!$mkdirSucess) {
        echo ("dir isn't writable");
    }

    
    if (!is_dir($imgDir) or !is_writable($imgDir)) {
        // Error if directory doesn't exist or isn't writable.
        echo ('directory doesnt exist or isnt writable.');
    } elseif (is_file($dirPath . $newImgLink) and !is_writable($dirPath . $newImgLink)) {
        // Error if the file exists and isn't writable.
        echo (" Error if the file exists and isn't writable.");
    }
    echo ' file put content ';
    $writtingSucess = move_uploaded_file($imgLink, $dirPath. $newImgLink);


    
    if (!$writtingSucess) {
        echo ("file not uploaded");
        http_response_code(500);
        exit;
    }

    echo ('link: ./artwork/' . $newImgLink);
} catch (Exception $e) {
    echo $e->getMessage();
    http_response_code(500);
    die();
}




try {

    $req = $pdo->prepare('UPDATE `artwork` SET `src`=:newImgLink WHERE id=:lastId;');
    $req->execute(array(
        'newImgLink' => $newImgLink,
        'lastId' => $lastId,


    ));

    $lastId = $pdo->lastInsertId();
} catch (Exception $e) {

    http_response_code(500);
    die('Erreur : ' . $e->getMessage());
}


echo ("<br>last id:" . $lastId);
echo "</body></html>";
