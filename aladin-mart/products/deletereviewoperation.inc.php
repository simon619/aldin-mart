<?php
    
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';

    if (isset($_GET['reviewer_id']) && isset($_GET['product_id']) && isset($_GET['vendor_id']) && isset($_GET['review_id']) && isset($_SESSION['user_id'])) {

        $reviewid = (int) $_GET['review_id'];
        $customerid = (int) $_SESSION['user_id'];
        $reviewerid = (int) $_GET['reviewer_id'];
        $productid = (int) $_GET['product_id'];
        $vendorid = (int) $_GET['vendor_id'];
        

        try {

            if ($customerid == $reviewerid) {

                deleteReview($pdo, $reviewid);
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