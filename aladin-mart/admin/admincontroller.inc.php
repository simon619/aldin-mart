<?php

    declare(strict_types=1);

    function getVendorByPrefix(object $pdo, String $prefixname) {

        return getVendorByPrefixFromDB($pdo, $prefixname);
           
    }

    function changeProfileStatus(object $pdo, int $userid, int $newstatus) {

        changeProfileStatusOnDB($pdo, $userid, $newstatus);

    }

    function getCustomerByPrefix(object $pdo, String $prefixname) {

        return getCustomerByPrefixFromDB($pdo, $prefixname);

    }

    function getUsersEarnSpendData(object $pdo, String $prefixname, int $userstype) {

        return getUsersEarnSpendDataFromDB($pdo, $prefixname, $userstype);

    }

?>