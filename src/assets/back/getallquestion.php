<?php

require("dbconnection.php");
try {
    $result_array = array();
    $questionData = array();

    $response = $pdo->query('SELECT * FROM question  ORDER BY  id DESC ;');

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
        $result_array[] =  $questionData;
    }
} catch (Exception $e) {


    die('Erreur : ' . $e->getMessage());
}
$arrayObject = json_encode($result_array);
echo ($arrayObject);
