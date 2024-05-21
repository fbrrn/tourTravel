<?php

    $host = 'sql305.infinityfree.com';
    $port = 3306;
    $db = 'if0_34516232_tourandtravel';
    $user = 'if0_34516232';
    $password = 'O7wZcEARtJ';

    try{
        $pdo = new PDO("mysql:host=".$host.";port=".$port.";dbname=".$db, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(Exception $ex){
        echo $ex->getMessage();
        die();
    }
?>