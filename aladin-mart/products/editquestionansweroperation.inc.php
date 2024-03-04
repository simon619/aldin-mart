<?php
    
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_SESSION['user_id']) && isset($_POST['edit_type']) && isset($_SESSION['user_type']))) {

        $edittype = $_POST['edit_type'];
        $qaid = (int) $_POST['qa_id'];
        $currentuserid = (int) $_SESSION['user_id'];
        $productid = (int) $_POST['product_id'];
        $customerid = (int) $_POST['customer_id'];
        $newquery = $_POST['newquery'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if ($newquery && (($currentuserid == $customerid) || ($currentuserid == $vendorid))) {

                if ($edittype == "question") {

                    editQuestion($pdo, $newquery, $qaid);
                    header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');
                    die();

                }

                else if ($edittype == "answer") {

                    editAnswer($pdo, $newquery, $qaid);
                    header('Location: productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');
                    die();

                }

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