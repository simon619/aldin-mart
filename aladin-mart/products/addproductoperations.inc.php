<?php
    
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_SESSION['user_id']) &&  isset($_SESSION['user_type']) && $_SESSION['user_type'] == "vendor")) {

        $vendorid = (int) $_SESSION['user_id'];
        $producttitletemp = $_POST['producttitle'];
        $producttitle = ($producttitletemp) ? strtolower((str_replace(" ", "_", $producttitletemp))) : null;
        $subcategoryid = $_POST['subcategoryid'];
        $productwholesaleprice = $_POST['productwholesaleprice'];
        $productretailprice = $_POST['productretailprice'];
        $productbrandnametemp = ($_POST['productbrandname']) ? $_POST['productbrandname'] : null;
        $productbrandname = ($productbrandnametemp) ? strtolower((str_replace(" ", "_", $productbrandnametemp))) : "no_brand_name";
        $productsku = $_POST['productsku'];
        $productquantity = $_POST['productquantity'];
        $productwarranty = ($_POST['productwarranty']) ? $_POST['productwarranty'] : 0;
        $productdescription = ($_POST['productdescription']) ? $_POST['productdescription'] : "no_description";
        $productspecification = ($_POST['productspecification']) ? ($_POST['productspecification']) : "no_specification";
        $productimagelocation = $_FILES['productimagelocation'];
        $districtids = $_POST['districts'];

        try {

            $productaddingerrors = array();

            if (productEmptyCheck($producttitle, $productwholesaleprice, $productretailprice, $productquantity, $productwarranty, $productsku)) {

                $productaddingerrors['insert_data'] = "Please Insert Data Correctly";

            }

            if ($producttitle) {

                if (productDuplicateCheck($pdo, $producttitle, $vendorid)) {

                    $productaddingerrors['duplicate_product_name'] = "Inserted Product Already Exists";

                }

            }

            if (skuDuplicateCheck($pdo, $productsku)) {

                $productaddingerrors['duplicate_product_sku'] = "Please Insert An Unique SKU";

            }

            if (priceErrorCheck($productwholesaleprice, $productretailprice)) {

                $productaddingerrors['invalid_price'] = "Please Add Valid Product Price";

            }

            if (numberCheck($productquantity)) {

                $productaddingerrors['number_error'] = "Enter Valid Number In Warranty or Quantity";

            }

            if ($productimagelocation) {

                $allowedextentionforimage = array("jpg", "jpeg", "png");
                $productphotoextension = pathinfo($productimagelocation['name'], PATHINFO_EXTENSION);

                if (!(($productimagelocation["type"] == "image/png") || ($productimagelocation["type"] == "image/jpg") || ($productimagelocation["type"] == "image/jpeg")) && in_array($productphotoextension, $allowedextentionforimage)) {

                    $productaddingerrors['invalid_image_format'] = "Please Insert A JPEG/PNG FILE";

                }

                if ($productimagelocation["error"] > 0) {

                    $productaddingerrors['too_many_errors'] = "Uploaded File Has too Many Errors";
                
                }


                $folder = "uploads/";
                $photoname = $vendorid . '_' . $producttitle;
                $newname = str_replace(" ", "_", $photoname);
                $newname = str_replace(".", "", $newname);
                $newname = str_replace(":", "", $newname);
                $newname = str_replace("?", "", $newname);
                $newname = str_replace("!", "", $newname);        
                $productimagelocation['name'] = $newname;

                move_uploaded_file($productimagelocation['tmp_name'], $folder . $productimagelocation['name'] . '.' . $productphotoextension);
                $productimagelocationname = $folder . $productimagelocation['name'] . '.' . $productphotoextension;

            }

            else {

                $productimagelocationname = "uploads/no_image.jpg";

            }
            
            if ($productaddingerrors) {

                $_SESSION['product_adding_errors'] = $productaddingerrors;
                header('Location: addproducts.php');
                die();

            }

            else {

                addAProduct($pdo, $vendorid, $producttitle, $subcategoryid, $productwholesaleprice, $productretailprice, $productbrandname, $productsku, $productquantity, $productwarranty, $productdescription, $productspecification, $productimagelocationname);
                $lastid = getLastProductID($pdo);
                $productid = $lastid['id'];
                addDeliveryLocation($pdo, $productid, $districtids);
                header('Location: addproducts.php?product_add=successful');
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

        header('Location: addproducts.php');
        die();

    }

?>