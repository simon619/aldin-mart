<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'admincontroller.inc.php';
    require_once 'adminmodel.inc.php';

    if (isset($_GET['user_id']) && isset($_GET['profile_status'])) {

        $userid = (int) $_GET['user_id'];
        $newstatus = ($_GET['profile_status'] == 1) ? 0 : 1;
        $newstatus = ($_GET['profile_status'] == 0) ? 1 : 0;

        try {

            changeProfileStatus($pdo, $userid, $newstatus);
            header('Location: vendorlist.php');
            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else {

        header('Location: vendorlist.php');
        die();

    }

?>