<?php
    
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'addtocartmodel.inc.php';
    require_once 'addtocartcontroller.inc.php';

    if (isset($_GET['product_id']) && isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "customer")) {

        $productid = (int) $_GET['product_id'];
        $productquantity = (int) getProductQuantity($pdo, $productid);

        try {

            $increasing = $_SESSION['user_cart'][$productid] + 1;

            if ($increasing <= $productquantity) {

                $_SESSION['user_cart'][$productid] += 1;
                header("Location: mycartdetails.php");
                $pdo = null;
                $stmt = null;
                die();
    
            }
    
            else {
    
                $_SESSION['increasing_error'] = "Insufficient Amount";
                header("Location: mycartdetails.php");
    
            }

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else {

        header("Location: mycartdetails.php");
        die();

    }

?>

