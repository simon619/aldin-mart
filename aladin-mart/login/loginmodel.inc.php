<?php

    declare(strict_types=1);

    function getUserDataFromDB(object $pdo, String $useremail) {
        
        $query = "SELECT * FROM users WHERE user_email = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$useremail]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function userInformationValidationFromDB(object $pdo, String $useremail, string $userpassword) {

        $query = "SELECT * FROM users WHERE user_email = ? AND user_password = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$useremail, $userpassword]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }
    
?>