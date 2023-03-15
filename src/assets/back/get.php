<?php
require("dbconnection.php");
$table=$_GET['table']; 


        try {
            $result_array = array();
           
            $reponse = $pdo->query('SELECT * FROM '.$table);

            while ($data = $reponse->fetch()) {

                $result_array[] = $data;
 
            }
        } catch (Exception $e) {


            die('Erreur : ' . $e->getMessage());
        }
        $arrayObjects = json_encode($result_array);
        echo($arrayObjects);

        ?>
