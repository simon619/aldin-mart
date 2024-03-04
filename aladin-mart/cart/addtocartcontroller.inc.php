<?php

    declare(strict_types=1);

    function getProductDeliveryDistrictId(object $pdo, int $productid) {

        return getProductDeliveryDistrictIdFromDB($pdo, $productid);

    }

    function getProductInformationForCart(object $pdo, int $productid) {

        return getProductInformationForCartFromDB($pdo, $productid);

    }

    function getProductQuantity(object $pdo, int $productid) {

        return getProductQuantityFromDB($pdo, $productid);

    }

    function addToSoldTable(object $pdo, int $customerid, int $productid, int $vendorid, int $purchasequantity, float $productretailprice, String $customernumber, float $totalprice, int $districtid, String $productdeliveryaddress) {

        addToSoldTableOnDB($pdo, $customerid, $productid, $vendorid, $purchasequantity, $productretailprice, $customernumber, $totalprice, $districtid, $productdeliveryaddress);

    }

    function getVendorTransaction(object $pdo, int $vendorid, int $selectionid) {

        return getVendorTransactionFromDB($pdo, $vendorid, $selectionid);

    }

    function changeStatus(object $pdo, int $transactionid, int $newstatusid) {

        changeStatusOnDB($pdo, $transactionid, $newstatusid);

    }

    function getAllTransaction(object $pdo, int $selectionid) {

        return getAllTransactionFromDB($pdo, $selectionid);

    }

?>