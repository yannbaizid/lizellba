<?php

$db_server = 'lacrieeoogliz.mysql.db';
$db_NAME = 'lacrieeoogliz';
$db_USER = 'lacrieeoogliz';
$db_PWD = '9qS7aMXfKSj9SDGM';

$pdo = new PDO('mysql:host='.$db_server.';dbname=' .$db_NAME . ';charset=utf8', $db_USER, $db_PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
