<?php
    
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_SESSION['user_id']) &&  isset($_SESSION['user_type']) && $_SESSION['user_type'] == "customer")) {

        $productid = $_POST['product_id'];
        $customerid = (int) $_POST['customer_id'];
        $review = (int) $_POST['review'];
        $reviewmessage = $_POST['reviewmessage'];
        $reviewmessage = ($_POST['reviewmessage']) ? strtolower((str_replace(" ", "_", $reviewmessage))) : null;
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (!$reviewmessage) {

                setReview($pdo, $review, $productid);
                header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid .'');
                die();

            }
            

            if ($reviewmessage) {

                setReview($pdo, $review, $productid);
                setReviewmessage($pdo, $productid, $customerid, $review, $reviewmessage);
                header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid .'');
                die();

            }

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else {

        header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid .'');
        die();

    }


?>