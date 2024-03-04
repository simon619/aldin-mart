<?php

    declare(strict_types=1);

    function isEmpty(String $userfirstname, String $userlastname, String $userpassword, String $useremail) {

        return (empty($userfirstname) || empty($userlastname) || empty($userpassword) || empty($useremail)) ? true : false;

    }

    function phoneNumberValidation($phonenumber) {

        $pattern = "/^\+880-[0-9]{10}$/";
        return (preg_match($pattern, $phonenumber) == 0) ? true : false; 

    }

    function emailValidation(String $email) {

        return (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;

    }


    function checkUserDataDuplication(object $pdo, String $usernumber, String $useremail) {

        return (checkUserDataDuplicationFromDB($pdo, $usernumber, $useremail)) ? true : false;

    }


    function createAUser(object $pdo, String $userfirstname, String $userlastname, String $userpassword, String $useremail, String | null $usernumber, String $usertype, String | null $usershopname) {

        createAUserOnDB($pdo, $userfirstname, $userlastname, $userpassword, $useremail, $usernumber, $usertype, $usershopname);

    }

    function uniqueShopNameCheck(object $pdo, String $usershopname) {

        uniqueShopNameCheckOnDB($pdo, $usershopname);

    }

?>