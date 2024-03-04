<?php

    declare(strict_types=1);

    function getMyProfile(object $pdo, int $currentuserid) {

        return getMyProfileFromDB($pdo, $currentuserid);

    }

    function editFieldEmptyCheck(String | null $userdata) {

        return (empty($userdata)) ? true : false;

    }

    function editUserFirstName(object $pdo, int $userid, String $userfirstname) {

        editUserFirstNameOnDB($pdo, $userid, $userfirstname);

    }

    function editUserLastName(object $pdo, int $userid, String $userlastname) {

        editUserLastNameOnDB($pdo, $userid, $userlastname);

    }

    function editUserPassword(object $pdo, int $userid, String $userpassword) {

        return editUserPasswordOnDB($pdo, $userid, $userpassword);

    }

    function emailUniqueCheck(object $pdo, String | null $useremail) {

        return (emailUniqueCheckFromDB($pdo, $useremail)) ? true : false;

    }

    function phoneUniqueCheck(object $pdo, String | null $usernumber) {

        return (phoneUniqueCheckFromDB($pdo, $usernumber)) ? true : false;

    }

    function editUserEmail(object $pdo, int $userid, String $useremail) {

        editUserEmailOnDB($pdo, $userid, $useremail);

    }

    function editUserNumber(object $pdo, int $userid, String $usernumber) {

        editUserNumberOnDB($pdo, $userid, $usernumber);

    }

    function editUserShopName(object $pdo, int $userid, String $usershopname) {

        editUserShopNameOnDB($pdo, $userid, $usershopname);

    }
  
?>