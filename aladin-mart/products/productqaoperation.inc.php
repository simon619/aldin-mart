<?php
    
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_SESSION['user_id']) &&  isset($_SESSION['user_type']) && $_SESSION['user_type'] == "customer")) {

        $question = ($_POST['question']) ? strtolower((str_replace(" ", "_", $_POST['question']))) : null;
        $productid = $_POST['product_id'];
        $customerid = (int) $_POST['customer_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if ($question) {

                setQuestion($pdo, $customerid, $vendorid, $productid, $question);
                header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid .'');
                die();

            }

            else {

                header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid .'');
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

        header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid .'');
        die();

    }

?>