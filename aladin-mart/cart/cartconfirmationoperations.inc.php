<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../products/productmodel.inc.php';
    require_once '../products/productcontroller.inc.php';
    require_once 'addtocartcontroller.inc.php';
    require_once 'addtocartmodel.inc.php';
    require_once '../signup/signupcontroller.inc.php';

    if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "customer"))  {

        $productdeliveryaddress = $_POST['productdeliveryaddress'];
        $customernumber = $_POST['customerphonenumber'];
        $customerid = (int) $_SESSION['user_id'];
        $mycarts = $_SESSION['user_cart'];

        try {

            $confirmationerror = null;

            if (!$productdeliveryaddress) {

                $confirmationerror = "Please Add Your Address For Confirmation";

            }

            if (!$customernumber) {

                $confirmationerror = "Please Add Your Phone Number";

            }

            if (count($mycarts) <= 0) {

                $confirmationerror = "You Have Not Inserted Any Product On Your Cart";


            }

            if (phoneNumberValidation($customernumber)) {

                $confirmationerror = "Invalid Phone Number";

            }

            if ($confirmationerror) {

                $_SESSION['confirmation_error'] = $confirmationerror;
                header("Location: mycartdetails.php");
                die();

            }

            else {

                foreach($mycarts as $key => $value) {

                    $productid = (int) $key;
                    $data = getProductInformationForCart($pdo, $productid);
                    $productretailprice = (float) $data['product_retail_price'];
                    $vendorid = $data['id'];
                    $purchasequantity =  (String) $mycarts[$key];
                    $totalprice = $productretailprice * $mycarts[$key];
                    $districtid = (int) $_SESSION['user_district_id'];
                    addToSoldTable($pdo, $customerid, $productid, $vendorid, $purchasequantity, $productretailprice, $customernumber, $totalprice, $districtid, $productdeliveryaddress);

                }

                $_SESSION['order_confirmed'] = "Your Order Has Been Successfully Confirmed";
                unset($_SESSION['user_cart']);
                header("Location: ../customer/customerhomepage.php");
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

        header("Location: mycartdetails.php");
        die();

    }

?>

