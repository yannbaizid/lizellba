<?php
header('Access-Control-Allow-Origin: *');
        try {
            $result_array = array();
            $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '22JambonPoulet', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $reponse = $bdd->query('SELECT * FROM `expo_photo`;');

            while ($donnee = $reponse->fetch()) {

                $result_array[] = $donnee;
 
            }
        } catch (Exception $e) {


            die('Erreur : ' . $e->getMessage());
        }
        $arrayObjects = json_encode($result_array);
        echo($arrayObjects);

        ?>
