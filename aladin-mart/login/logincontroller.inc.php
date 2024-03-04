<?php

    declare(strict_types=1);

    function loginEmpty(String $useremail, String $userpassword) {

        return (empty($useremail) || empty($userpassword)) ? true : false;

    }

    function getUserData(Object $pdo, String $useremail) {

        return getUserDataFromDB($pdo, $useremail);

    }

    function userExistanceValidation(bool | array $result) {

        return (!$result) ? true : false;
        
    }

    function userInformationValidation(object $pdo, String $useremail, String $userpassword) {

        $result = userInformationValidationFromDB($pdo, $useremail, $userpassword);
        return userExistanceValidation($result);
        
    }

?>