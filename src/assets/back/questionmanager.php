<?php

header('Content-Type: multipart/form-data;');
require("dbconnection.php");

$method = $_SERVER['REQUEST_METHOD'];


//print_r($_POST);
//print_r($_REQUEST);


if ($method == 'DELETE') {
    $inputId= $_GET['id'];
    echo ('method delete id=' + $inputId);

    try {
        $req = $pdo->prepare("DELETE FROM `Question` WHERE id=:inputId");
        $req->bindValue(':inputId', $inputId, PDO::PARAM_INT);
        $req->execute();
        echo $req->debugDumpParams();
    } catch (Exception $e) {
        echo $e->getMessage();
        http_response_code(417);
        die('Erreur : ' . $e->getMessage());
    }
}


if ($_POST['_method'] == 'PUT') {
    $updatedQuestion = json_decode($_POST['updatedQuestion'], true);
    print_r ($updatedQuestion);
    echo '$$$$$$$$$$$$%%%%%%%%%%\\\\\\\\';

    print_r($updatedQuestion['answers'][0]['text']);

    try {

        $req = $pdo->prepare("UPDATE `question` SET `question`=:question,`answer`=:answer, `caption`=:caption,`caption_details`=:captionDetails,`info_link`=:infoLink,`question_type_id`=:typeId,`expo_id`=:expoId WHERE id=:inputId");
        $req->bindValue(':question', $updatedQuestion['question'], PDO::PARAM_STR);
        $req->bindValue(':answer',  $updatedQuestion['answer'], PDO::PARAM_STR);
        $req->bindValue(':caption',  $updatedQuestion['caption'], PDO::PARAM_STR);
        $req->bindValue(':captionDetails',  $updatedQuestion['caption_details'], PDO::PARAM_STR);
        $req->bindValue(':infoLink',  $updatedQuestion['info_link'], PDO::PARAM_STR);
        $req->bindValue(':typeId',  $updatedQuestion['question_type_id'], PDO::PARAM_INT);
        $req->bindValue(':expoId',  $updatedQuestion['expo_id'], PDO::PARAM_INT);
        $req->bindValue(':inputId',  $updatedQuestion['id'], PDO::PARAM_INT);
        $req->execute();


        
        //Set answer propositions in DB
    for ($i = 0; $i < 3; $i++) {
     echo  $i.$updatedQuestion['answers'][$i]['text'].'correc:'.$updatedQuestion['answers'][$i]['correct'].'id:'.$updatedQuestion['answers'][$i]['id'];
        $req = $pdo->prepare("UPDATE `question_answer` SET `text`=:inputText,`correct`=:correct WHERE id=:inputId");
        $req->bindValue(':inputText', $updatedQuestion['answers'][$i]['text'], PDO::PARAM_STR);
        $req->bindValue(':correct',  $updatedQuestion['answers'][$i]['correct'], PDO::PARAM_STR);
        $req->bindValue(':inputId', $updatedQuestion['answers'][$i]['id'], PDO::PARAM_INT);
        $req->execute();
     }

    } catch (Exception $e) {
        echo $e->getMessage();
        http_response_code(417);
        die('Erreur : ' . $e->getMessage());
    }
    echo 'put done';

} 


if ($method == 'GET') {

try {
    $questions = array();

    $response = $pdo->query('SELECT * FROM question  ORDER BY  RAND();');

  while ($questionData = $response->fetch()) {

        $answersData = $pdo->prepare('SELECT id,text,correct FROM  question_answer WHERE question_answer.question_id=? ORDER BY RAND();');
        $answersData->execute(array($questionData['id']));
        $answers = array();
        while ($answer = $answersData->fetch()) {
            $answers[] = $answer;
        }
        $questionData['answers'] = $answers;
        $typeData = $pdo->prepare('SELECT * FROM  question_type WHERE question_type.id=?;');
        $typeData->execute(array($questionData['question_type_id']));
        $type = array();
        if ($type = $typeData->fetch()) {
        }
        $questionData['type'] = $type;
        $questions[]=$questionData;
        
    }
    $arrayObject = json_encode($questions);
    echo ($arrayObject);
} catch (Exception $e) {
    echo $e->getMessage();
    http_response_code(417);
    die('Erreur : ' . $e->getMessage());
}



}
