<?php

    declare(strict_types=1);

    function getMyProfileFromDB(object $pdo, int $currentuserid) {

        $query = "SELECT id, user_first_name, user_last_name, user_type, user_email, user_number, user_shop_name 
        FROM users WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$currentuserid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function editUserFirstNameOnDB(object $pdo, int $userid, String $userfirstname) {

        $query = "UPDATE users SET user_first_name = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userfirstname, $userid]);

    }

    function editUserLastNameOnDB(object $pdo, int $userid, String $userlastname) {

        $query = "UPDATE users SET user_last_name = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userlastname, $userid]);

    }

    function editUserPasswordOnDB(object $pdo, int $userid, String $userpassword) {

        $query = "UPDATE users SET user_password = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userpassword, $userid]);

    }

    function emailUniqueCheckFromDB($pdo, $useremail) {

        $query = "SELECT id FROM users WHERE user_email = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$useremail]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function phoneUniqueCheckFromDB($pdo, $usernumber) {

        $query = "SELECT id FROM users WHERE user_number = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$usernumber]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function editUserEmailOnDB(object $pdo, int $userid, String $useremail) {

        $query = "UPDATE users SET user_email = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$useremail, $userid]);

    }

    function editUserNumberOnDB(object $pdo, int $userid, String $usernumber) {

        $query = "UPDATE users SET user_number = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$usernumber, $userid]);

    }

    function editUserShopNameOnDB(object $pdo, int $userid, String $usershopname) {

        $query = "UPDATE users SET user_shop_name = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$usershopname, $userid]);

    }

?>