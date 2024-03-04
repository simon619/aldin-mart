<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'addtocartmodel.inc.php';
    require_once 'addtocartcontroller.inc.php';

    if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "vendor")) {

        $newstatusid = $_POST['statusid'];
        $transactionid = (int) $_POST['transaction_id'];

        try {

            changeStatus($pdo, $transactionid, $newstatusid);
            header("Location: vendortransactionlist.php");
            die();

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

        $pdo = null;
        $stmt = null;

    }

    else {

        header("Location: vendortransactionlist.php");
        die();

    }


?>