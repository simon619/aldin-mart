<?php

    $dsn = "mysql:host=localhost;dbname=aladin_mart";
    $dbusername = "root";
    $dbpassword = "pwroot";
    
    try {

        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }

    catch (PDOException $e) {

        die("Connection Faild: ". $e->getMessage()."</br>");

    }
    
?>