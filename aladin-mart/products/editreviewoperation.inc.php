<?php
    
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_SESSION['user_id']) &&  isset($_SESSION['user_type']) && $_SESSION['user_type'] == "customer")) {

        $reviewid = (int) $_POST['review_id'];
        $customerid = (int) $_SESSION['user_id'];
        $productid = (int) $_POST['product_id'];
        $reviewerid = (int) $_POST['reviewer_id'];
        $newreviewmessage = $_POST['newreviewmessage'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if ($newreviewmessage && ($customerid == $reviewerid)) {

                editReview($pdo, $newreviewmessage, $reviewid);
                header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');
                die();
    
            }

            else {

                header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');
                die();

            }

            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else {

        header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');
        die();

    }

?>