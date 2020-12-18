<?php
header('Access-Control-Allow-Origin: *');
        try {

            $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $response = $bdd->query('SELECT * FROM question  ORDER BY  RAND() LIMIT 1 ;');

           if ($questionData = $response->fetch()) {

                $answersData=$bdd->prepare('SELECT id,text,correct FROM  answer WHERE answer.question_id=? ORDER BY RAND();');
                $answersData->execute(array($questionData['id']));
                $answers=array();
                while ($answer=$answersData->fetch()) {
                    $answers[]=$answer;
                }
                $questionData['answers']=$answers;
                $result= $questionData;
 
            }
        } catch (Exception $e) {


            die('Erreur : ' . $e->getMessage());
        }
        $arrayObject = json_encode($questionData);
        echo($arrayObject);

        ?>
