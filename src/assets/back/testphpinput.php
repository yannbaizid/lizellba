<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

require("dbconnection.php");

$data=json_decode(file_get_contents('php://input'),true);
$imgDir='../img/expos/';
//save image on server
$image=$data['image'];
echo '*image before'.$image.'*';
$explodeData= explode(';', $image);
$image=$explodeData[sizeof($explodeData)-1];
$explodeData     = explode(',', $image);
$image=$explodeData[sizeof($explodeData)-1];
$image = base64_decode($image);
echo '*image '.$image.'*';

//Save record on DB

//define curator and expoName
$curatorName=$data['curatorName'];
$expoName=$data['expoName'];

//define date of creation and filename=date whithout punctuation
date_default_timezone_set('Europe/Paris');
$date=date('Y-m-d H:i:s');
$fileName= str_replace(array("-", ":", " "), "", $date).'.jpg';

echo '*filename:'.$fileName;
echo '*,filesize :'.filesize($fileName).',*';
echo '*,filesize :'.filesize($fileName).',*';
try {

    if (!is_dir($imgDir) or !is_writable($imgDir)) {
        // Error if directory doesn't exist or isn't writable.
        echo ('directory doesnt exist or isnt writable.');
    } elseif (is_file('./img/expos/'.$fileName.'.jpg') and !is_writable('./img/expos/'.$fileName.'.jpg')) {
        // Error if the file exists and isn't writable.
       echo(" Error if the file exists and isn't writable.");
    }
    echo ' file put content ';
   $writtingSucess=file_put_contents('./img/expos/'.$fileName, $image);

   
   if (empty( $writtingSucess)) {
    echo("file empty/not readable");
    exit;
}
echo $writtingSucess;
 }
    catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
        

try{
    $req = $pdo->prepare('INSERT INTO expo_photo(file_name,curator_name,expo_name,date_creation) VALUES(:fileName,:curatorName,:expoName,:dateCreation)');
    $req->execute(array(
        'fileName' => $fileName,
        'curatorName' => $curatorName,
        'expoName' => $expoName,
        'dateCreation' => $date
	));
}
catch (PDOException $e) {
    echo   $e->getMessage();
}

    


echo "  done";
