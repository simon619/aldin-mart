<?php
    
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';

    if (isset($_GET['product_id']) && isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "customer")) {

        $productid = (int) $_GET['product_id'];

        try {

            $decreaseing = $_SESSION['user_cart'][$productid] - 1;

            if ($decreaseing <= 0) {

                unset($_SESSION['user_cart'][$productid]);
                header("Location: mycartdetails.php");
    
            }
    
            else {
    
                $_SESSION['user_cart'][$productid] -= 1;
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

