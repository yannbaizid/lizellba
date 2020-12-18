<?php
header('Access-Control-Allow-Origin: *');
        try {
            $result_array = array();
            $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $reponse = $bdd->query('SELECT * FROM `tabletest`;');

            while ($donnee = $reponse->fetch()) {

                $artist=$bdd->prepare('SELECT * FROM `author` WHERE id=?;');
                $artist->execute(array($donnee['id_author']));
                $donnee['artist']=$artist->fetch();
                $result_array[] = $donnee;
 
            }
        } catch (Exception $e) {


            die('Erreur : ' . $e->getMessage());
        }
        $arrayObjects = json_encode($result_array);
        echo($arrayObjects);

        ?>
