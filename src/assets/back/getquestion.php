<?php

require("dbconnection.php");
try {
    $questionData = array();

    $response = $pdo->query('SELECT * FROM question  ORDER BY  RAND() LIMIT 1 ;');

    if ($questionData = $response->fetch()) {

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
    }
} catch (Exception $e) {


    die('Erreur : ' . $e->getMessage());
}
$arrayObject = json_encode($questionData);
echo ($arrayObject);
