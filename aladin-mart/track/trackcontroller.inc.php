<?php

    declare(strict_types=1);

    function trackMyProductsByDate(object $pdo, int $vendorid, String $date) {

        return trackMyProductsByDateFromDB($pdo, $vendorid, $date);

    }

    function getNumberOfProductTypes(object $pdo, int $vendorid) {

        return getNumberOfProductTypesFromDB($pdo, $vendorid);

    }

    function getTotalNumberOfProducts(object $pdo, int $vendorid) {

        return getTotalNumberOfProductsFromDB($pdo, $vendorid);

    }

    function getMySoldProducts(object $pdo, int $vendorid) {

        return getMySoldProductsFromDB($pdo, $vendorid);

    }

    function getCustomerTransactions(object $pdo, int $customerid, int $selectionid) {

        return getCustomerTransactionsFromDB($pdo, $customerid, $selectionid);

    }

    function cancelOrder(object $pdo, int $transactionid, int $customerid) {

        cancelOrderOnDB($pdo, $transactionid, $customerid);

    }

?>