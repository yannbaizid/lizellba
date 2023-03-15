<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

require("dbconnection.php");
$errorMessage="errors:";
$data=json_decode(file_get_contents('php://input'),true);
//$imgDir='../img/expos/';




//save image on server
$image=$data['image'];

$explodeData     = explode(',', $image);
$image=$explodeData[sizeof($explodeData)-1];

$image = str_replace(' ','+',$image);
$image = base64_decode($image);

//Save record on DB

//define curator and expoName
$curatorName=$data['curatorName'];
$expoName=$data['expoName'];
$typeId=$data['typeId'];
$errorMessage=$errorMessage.',curatorname:'.$curatorName;
$errorMessage=$errorMessage.',Exponame:'.$expoName;

//define date of creation and filename=date whithout punctuation
date_default_timezone_set('Europe/Paris');
$date=date('Y-m-d H:i:s');
$rdInt=$rdm=rand( 0 , 999 );
$fileName= str_replace(array("-", ":", " "), "", $date).'_'.$rdInt.'.jpg';

//echo '*filename:'.$fileName;
//echo '*,filesize :'.filesize($image).',*';
try {
    $imgDir="../img/expos/";
    if (!is_dir($imgDir) or !is_writable($imgDir)) {
        // Error if directory doesn't exist or isn't writable.
        $errorMessage=$errorMessage.'directory doesnt exist or isnt writable.';
     
    } elseif (is_file($imgDir.$fileName) and !is_writable($imgDir.$fileName)) {
        // Error if the file exists and isn't writable.
        $errorMessage=$errorMessage." Error if the file exists and isn't writable.";
    
    }

   $writtingSucess=file_put_contents($imgDir.$fileName, $image);

   
   if (empty( $writtingSucess)) {
    $errorMessage=$errorMessage."file empty/not readable";
   echo $errorMessage."*imgDir:".$imgDir."filename: $filename *";

    exit;

}

 }
    catch (Exception $e) {
        echo $e->getMessage();
        echo $errorMessage."*imgDir:".$imgDir."filename: $filename *";
        http_response_code(417);
        die();
    }
        

try{
    $req = $pdo->prepare('INSERT INTO expo_photo(file_name,curator_name,expo_name,date_creation,type_id) VALUES(:inputFileName,:curatorName,:expoName,:dateCreation,:inputType)');
    $req->execute(array(
        'inputFileName' => $fileName,
        'curatorName' => $curatorName,
        'expoName' => $expoName,
        'dateCreation' => $date,
        'inputType'=> $typeId,
    ));
       //gather lastid
       $lastId = $pdo->lastInsertId();
       echo $lastId;
     

}
catch (PDOException $e) {
   echo $errorMessage.' failed trying to DB connect';
    echo   $e->getMessage();
    http_response_code(417);
}


    
