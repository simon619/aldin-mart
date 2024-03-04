<?php

    declare(strict_types=1);

    function getVendorByPrefixFromDB(object $pdo, String $prefixname) {

        $lowercaseprefix = strtolower($prefixname);

        if ($lowercaseprefix == "all") {

            $query = "SELECT v.id, v.user_first_name, v.user_last_name, v.user_email, v.user_number, v.profile_status, v.user_shop_name, 
            v.profile_created FROM users v WHERE v.user_type = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute(["vendor"]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            

        }

        else {

            $query = "SELECT v.id, v.user_first_name, v.user_last_name, v.user_email, v.user_number, v.profile_status, v.user_shop_name, v.profile_created 
            FROM users v WHERE v.user_type = ? AND (v.user_first_name LIKE ? OR v.user_last_name LIKE ?);";
            $stmt = $pdo->prepare($query);
            $stmt->execute(["vendor", $lowercaseprefix . '%', $lowercaseprefix . '%']);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }

    }

    function getCustomerByPrefixFromDB(object $pdo, String $prefixname) {

        $lowercaseprefix = strtolower($prefixname);

        if ($lowercaseprefix == "all") {

            $query = "SELECT c.id, c.user_first_name, c.user_last_name, c.user_email, c.user_number, c.profile_status, c.profile_created 
            FROM users c WHERE c.user_type = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute(["customer"]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        }

        else {

            $query = "SELECT c.id, c.user_first_name, c.user_last_name, c.user_email, c.user_number, c.profile_status, c.profile_created 
            FROM users c WHERE c.user_type = ? AND (c.user_first_name LIKE ? OR c.user_last_name LIKE ?);";
            $stmt = $pdo->prepare($query);
            $stmt->execute(["customer", $lowercaseprefix . '%', $lowercaseprefix . '%']);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }

    }

    function changeProfileStatusOnDB(object $pdo, int $userid, int $newstatus) {

        $query = "UPDATE users SET profile_status = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newstatus, $userid]);

    }

    function getUsersEarnSpendDataFromDB(object $pdo, String $prefixname, int $userstype) {

        $lowercaseprefix = strtolower($prefixname);

        if ($userstype == 0) {

            $query = "SELECT u.user_first_name, u.user_last_name, u.user_email, u.user_number, sum(total_price) AS total_cost, sum(purchase_quantity) AS total_quantity 
            FROM cart_table ct JOIN users u ON u.id = ct.customer_id WHERE ct.customer_id = any (SELECT id FROM users WHERE user_type = ? AND (user_first_name LIKE ? OR
            user_first_name LIKE ?)) GROUP BY ct.customer_id;";
            $stmt = $pdo->prepare($query);
            $stmt->execute(["customer", $lowercaseprefix . '%', $lowercaseprefix . '%']);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }
        
        else if ($userstype == 1) {

            $query = "SELECT u.user_first_name, u.user_last_name, u.user_email, u.user_number, sum(total_price) AS total_cost, sum(purchase_quantity) AS total_quantity 
            FROM cart_table ct JOIN users u ON u.id = ct.vendor_id WHERE ct.vendor_id = any (SELECT id FROM users WHERE user_type = ? AND (user_first_name LIKE ? OR
            user_first_name LIKE ?)) GROUP BY ct.vendor_id;";
            $stmt = $pdo->prepare($query);
            $stmt->execute(["vendor", $lowercaseprefix . '%', $lowercaseprefix . '%']);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }

    }

?>