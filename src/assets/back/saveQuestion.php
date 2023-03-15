<?php


header('Access-Control-Allow-Origin: *');
require("dbconnection.php");
require("cleanString.php");

echo "<html><head><title>test</title></head><body>sssss";

foreach ($_POST as $champ => $valeur) {
    echo "$champ = $valeur<br>";
}


echo "<br>file: ";

if (isset($_FILES)) {
    echo "ok<br>";
} else {
    echo "no ok";
}
print_r($_FILES);

$imgLink = $_FILES['imgFile']['tmp_name'];


$type = $pdo->prepare('SELECT `name` FROM `question_type` WHERE id=?;');
$type->execute(array($_POST['typeId']));
$type = $type->fetch();
$type = $type['name'];
$type = strtolower(cleanString($type));
echo "<br> type:" . $type;

for ($i = 1; $i < 4; $i++) {
   echo '** reponse '.$i.' :'.$_POST['answer'.$i.'text'];
    
 }


try {
    //insert question into DB
    $req = $pdo->prepare('INSERT INTO `question`( `question`, `answer`, `img_link`, `caption`, `info_link`, `optional_info`, `optional_link`, `photo_credits`, `question_type_id`,expo_id) VALUES ( :question, :answer, :imgLink, :caption, :infoLink, :optionalInfo, :optionalLink,:photoCredit, :typeId,:expoId)');
    $req->execute(array(
        'question' => $_POST['question'],
        'answer' => $_POST['answer'],
        'imgLink' => $imgLink,
        'caption' => $_POST['caption'],
        'infoLink' => $_POST['infoLink'],
        'optionalInfo' => $_POST['optionalInfo'],
        'optionalLink' => $_POST['optionalInfo'],
        'photoCredit' => $_POST['photoCredit'],
        'typeId' => $_POST['typeId'],
        'expoId' => $_POST['expoId']

    ));


    //gather lastid
    $lastId = $pdo->lastInsertId();


    //define new link
    $newImgLink = $type . '/' . $_POST['expoId'] . "/" . $lastId . ".jpg";


    //replace updated imglink in DB
    $req = $pdo->prepare('UPDATE `question` SET `img_link`=:newImgLink WHERE id=:lastId;');
    $req->execute(array(
        'newImgLink' => $newImgLink,
        'lastId' => $lastId,


    ));
   
   //Set answer propositions in DB
    for ($i = 1; $i < 4; $i++) {
        echo ("*** answer" . $i . " " .$_POST['answer'.$i.'text']. "****corec:" .$_POST['answer'.$i.'correct'] . "<br>");
        $text = $_POST['answer'.$i.'text'];

        $correct = $_POST['answer'.$i.'correct'];

        $req = $pdo->prepare('INSERT INTO `question_answer`(`text`, `correct`, `question_id`) VALUES (:text,:correct,:questionId)');
        $req->execute(array(
            'text' => $text,
            'correct' => $correct,
            'questionId' => $lastId,

        ));
    } 
} catch (Exception $e) {
echo $e->getMessage();
http_response_code(417);
    die('Erreur : ' . $e->getMessage());
}


try {

    $dirPath = '../img/question/' . $type . '/' . $_POST['expoId'];
echo '<br>dirpath:'.$dirPath.'<br>';
    $mkdirSucess = mkdir($dirPath, 0777, true);
    if (!$mkdirSucess) {
        echo ("dir isn't writable or exists");
    }


    if (!is_dir($dirPath) or !is_writable($dirPath)) {
        // Error if directory doesn't exist or isn't writable.
        echo ('<br>directory doesnt exist or isnt writable.');
    } elseif (is_file('../img/question/' . $newImgLink) and !is_writable('../img/question/' . $newImgLink)) {
        // Error if the file exists and isn't writable.
        echo (" <br>Error if the file exists and isn't writable.");
    }
    echo '<br> file put content ';

    $writtingSucess = move_uploaded_file($imgLink, '../img/question/' . $newImgLink);



    if (!$writtingSucess) {
        echo ("<br>file not uploaded");
    
        exit;
    }
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}



echo ("<br>last id:" . $lastId);
echo "</body></html>";
