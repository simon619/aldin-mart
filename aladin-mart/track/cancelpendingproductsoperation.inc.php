<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../track/trackcontroller.inc.php';
    require_once '../track/trackmodel.inc.php';
    require_once '../track/trackview.inc.php';

    $userid = (isset($_SESSION['user_id'])) ? (int) $_SESSION['user_id'] : -1; 

    if (isset($_GET['transaction_id']) && isset($_GET['customer_id']) && isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "customer") && ((int) $_GET['customer_id'] == $userid)) {

        $transactionid = (int) $_GET['transaction_id'];
        $customerid = $_GET['customer_id'];

        cancelOrder($pdo, $transactionid, $customerid);
        $_SESSION['cancelled'] = "Your Order Has Been Cancelled";
        header('Location: customerproductpendinglist.php?customer_id=' . $customerid . '');
        die();

    }

?>

