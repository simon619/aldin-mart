<?php

    declare(strict_types=1);

    function createAUserOnDB(object $pdo, String $userfirstname, String $userlastname, String $userpassword, String $useremail, String| null $usernumber, String $usertype, String| null $usershopname) {

        $query = "INSERT INTO users (user_first_name, user_last_name, user_password, user_email, user_number, user_type, user_shop_name) VALUES (?, ?, ?, ?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userfirstname, $userlastname, $userpassword, $useremail, $usernumber, $usertype, $usershopname]);
        
    }


    function checkUserDataDuplicationFromDB(object $pdo, String $usernumber, String $useremail) {
        
        $query = "SELECT user_number, user_email FROM users WHERE user_number = ? OR user_email = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$usernumber, $useremail]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function uniqueShopNameCheckOnDB(object $pdo, String $usershopname) {

        $query = "SELECT id FROM users WHERE user_shop_name = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$usershopname]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

?>