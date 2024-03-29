<?php
require("dbconnection.php");




//GET REQUESTS
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
$conditions='';
$parameters=[];
$parameters['typeId']= !empty($_GET['typeId'])  ? $_GET['typeId']  : null;
$parameters['limit']=!empty($_GET['limit'])? (int)$_GET['limit'] : 16;



    //Specific functions
    if (isset($_GET['function'])) {

        try {

            //GET MIN, MAX AND TOTAL NUMBER OF IDs in EXPO_PHOTO
            if ($_GET['function'] == 'idrange') {



                $req = $pdo->prepare('SELECT MIN(id) as min, MAX(id) as max, COUNT(*) as total FROM `expo_photo`   WHERE (type_id=:typeId or :typeId is null)');
                $req->bindValue(':typeId', $parameters['typeId'], PDO::PARAM_INT);
            }
            //GET FIRST NEXT PHOTO AFTER THE ID PROVIDED
            if ($_GET['function'] == 'prev' && isset($_GET['id'])) {


                $inputId = $_GET['id'];



                $req = $pdo->prepare('SELECT * FROM expo_photo WHERE id>:inputId ORDER BY id ASC LIMIT 1');
                $req->bindValue(':inputId', $inputId, PDO::PARAM_INT);
            } else  if ($_GET['function'] == 'next' && isset($_GET['id'])) {
                //GET FIRST PREVIOUS PHOTO BEFORE THE ID PROVIDED
                $req = $pdo->prepare('SELECT * FROM expo_photo WHERE id<:inputId ORDER BY id DESC LIMIT 1');
                $req->bindValue(':inputId', $inputId, PDO::PARAM_INT);
            }
            $req->execute();

            if ($data = $req->fetch()) {

                $jsonResult = json_encode($data);
                echo ($jsonResult);
            }
        } catch (Exception $e) {

            http_response_code(540);
            die('Erreur : ' . $e->getMessage());
        }
    } else {


        //IF ID in PARAMS, GET THAT SPECIFIC PHOTO DATA.
        if (isset($_GET['id'])) {
            $inputId = $_GET['id'];

            try {
                $req = $pdo->prepare('SELECT * FROM expo_photo WHERE id=:inputId');
                $req->bindValue(':inputId', $inputId, PDO::PARAM_INT);
                $req->execute();

                if ($data = $req->fetch()) {

                    $jsonResult = json_encode($data);
                    echo ($jsonResult);
                }
            } catch (Exception $e) {

                http_response_code(540);
                die('Erreur : ' . $e->getMessage());
            }
        }



        //IF typeId in PARAMS, WORK ON THAT SPECIFIC PHOTO DATA.
     /*    else if (isset($_GET['typeId'])) {


            $typeId = $_GET['typeId'];
            $result_array = array();

            try {
                $req = $pdo->prepare('SELECT * FROM expo_photo WHERE type_id=:typeId');
                $req->bindValue(':typeId', $typeId, PDO::PARAM_INT);
                $req->execute();

                while ($data = $req->fetch()) {
                    $result_array[]=$data;

                }
                $arrayObjects = json_encode($result_array);
                echo ($arrayObjects);
            } catch (Exception $e) {

                http_response_code(540);
                die('Erreur : ' . $e->getMessage());
            }
        }  */else {


            try {
                $result_array = array();

                //GET xLIMIT PHOTOS STARTING FROM OFFSET=PAGExLIMIT
                if ( isset($_GET['page'])) {
                   
                    $offset = ($_GET['page'] - 1) * $parameters['limit'];
                    $req = $pdo->prepare('SELECT * FROM `expo_photo`   WHERE (type_id=:typeId or :typeId is null) ORDER BY id DESC LIMIT :inputLimit OFFSET :inputOffset');
                    $req->bindValue(':inputLimit', $parameters['limit'], PDO::PARAM_INT);
                    $req->bindValue(':inputOffset', $offset, PDO::PARAM_INT);
                    $req->bindValue(':typeId', $parameters['typeId'], PDO::PARAM_INT);
                }
                //ELSE, if NO PARAMS AT ALL, GET ALL THE PHOTOS
                else {
                    $req = $pdo->prepare('SELECT * FROM expo_photo  WHERE (type_id=:typeId or :typeId is null) ORDER BY id DESC');
                    $req->bindValue(':typeId', $parameters['typeId'], PDO::PARAM_INT);
                }

                $req->execute();

                while ($data = $req->fetch()) {

                    $result_array[] = $data;
                }
            } catch (Exception $e) {

                http_response_code(540);
                die('Erreur : ' . $e->getMessage());
            }
            $arrayObjects = json_encode($result_array);
            echo ($arrayObjects);
        }
    }
}
