<?php

require("dbconnection.php");
        try {
            $result_array = array();
           
            $reponse = $pdo->query('SELECT * FROM `artwork-type`;');

            while ($data = $reponse->fetch()) {

                $result_array[] = $data;
 
            }
        } catch (Exception $e) {


            die('Erreur : ' . $e->getMessage());
        }
        $arrayObjects = json_encode($result_array);
        echo($arrayObjects);

        ?>
