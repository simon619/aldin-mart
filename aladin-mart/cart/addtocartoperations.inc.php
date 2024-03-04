<?php
    
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../products/productmodel.inc.php';
    require_once '../products/productcontroller.inc.php';
    require_once 'addtocartmodel.inc.php';
    require_once 'addtocartcontroller.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $productid = (int) $_POST['product_id'];
        $customerid = (int) $_POST['customer_id'];
        $purchasequantity = (int) $_POST['purchasequantity'];
        $currentuserid = (int) $_SESSION['user_id'];
        $vendorid = (int) $_POST['vendor_id'];
        $productquantity = (int) $_POST['product_quantity'];
        $cartproduct = array();

        try {

            $addcarterrors = array();

            if ($purchasequantity > $productquantity) {
                
                $addcarterrors['insufficient_quantitiy'] = "Please Enter Valid Number";

            }

            if ($purchasequantity <= 0) {

                $addcarterrors['invalid_quantitiy'] = "Please Enter A Whole Number";
                

            }

            $productdeliverydistrictsids = getProductDeliveryDistrictId($pdo, $productid);
            $customerlocation = (int) $_SESSION['user_district_id'];

            $exits = false;
            foreach ($productdeliverydistrictsids as $key => $value) {

                if ((int) $value['district_id'] == 1) {

                    $exits = true;
                    break;

                }

                if ($customerlocation == $value['district_id']) {

                    $exits = true;
                    break;

                }

            }

            if (!$exits) {

                $addcarterrors['invalid_district'] = "This Product Can Not Be Deliverd On That District";

            }

            if ($_SESSION['user_cart'][$productid]) {

                $productplus = $_SESSION['user_cart'][$productid] + $purchasequantity;
                
                if ($productplus > $productquantity) {

                    $addcarterrors['unable_to_add_product'] = "Insufficient Product Amount";


                } 

            }

            if ($addcarterrors) {

                $_SESSION['cart_error'] = $addcarterrors;
                header('Location: ../products/productdetail.php?product_id=' . $productid . '&vendor_id=' . $vendorid . '');
                die();

            }

            else {
                
                $exists = false;

                foreach ($_SESSION['user_cart'] as $key => $value) {

                    if ($key == $productid) {

                        $exists = true;
                        $_SESSION['user_cart'][$key] += $purchasequantity;

                    }

                }

                if (!$exists) {

                    // $cartproduct[$productid] = $purchasequantity;
                    $_SESSION['user_cart'][$productid] = $purchasequantity;

                }

                $_SESSION['cart_success'] = "Product Added To Cart";
                header('Location: ../products/productdetail.php?product_id=' . $productid . '&vendor_id=' . $vendorid . '');
                die();

            }

            $pdo = null;
            $stmt = null;

        }
        
        catch (PDOException $e) {

            header('Location: ../products/productdetail.php?product_id=' . $productid . '&vendor_id=' . $vendorid .'');
            die("Query Faild: ". $e->getMessage()."</br>");

        }

    }

    else {

        header('Location: ../products/productdetail.php?product_id=' . $productid . '&vendor_id='. $vendorid .'');
        die();

    }

?>