<?php

require("dbconnection.php");

        try {
            $result_array = array();
            $response = $pdo->query('SELECT * FROM `artwork` ORDER BY id DESC;');

            while ($data = $response->fetch()) {
                //add artist
                $artist=$pdo->prepare('SELECT * FROM `artist` WHERE id=?;');
                $artist->execute(array($data['artist_id']));
                
                
                $data['artist']=$artist->fetch();
                //add expo
                $expo=$pdo->prepare('SELECT * FROM `expo` WHERE id=?;');
                $expo->execute(array($data['expo_id']));
                $data['expo']=$expo->fetch();
                //add type
                $type=$pdo->prepare('SELECT * FROM `artwork_type` WHERE id=?;');
                $type->execute(array($data['type_id']));
                $typeData=$type->fetch();
                $data['type']=$typeData['name'];
                $result_array[] = $data;
                
 
            }
        } catch (Exception $e) {


            die('Erreur : ' . $e->getMessage());
        }
        $arrayObjects = json_encode($result_array);
        echo($arrayObjects);
