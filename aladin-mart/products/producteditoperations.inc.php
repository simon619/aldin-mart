<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';
    require_once 'productview.inc.php';
    require_once '../admin/categorycontroller.inc.php';
    require_once '../admin/categorymodel.inc.php';

    if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproducttitle") {

        $newproducttitletemp = $_POST['producttitle'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];
        $newproducttitle = strtolower((str_replace(" ", "_", $newproducttitletemp)));

        $product = getAProductDetails($pdo, $vendorid, $productid);

        $productchangeserrors = array();

        try {

            if (empty($newproducttitle)) {

                $productchangeserrors['empty_title'] = "Please Insert A Title"; 
    
            }
    
            if ($newproducttitle) {
    
                if (productDuplicateCheck($pdo, $newproducttitle, $vendorid)) {
    
                    $productchangeserrors['product_duplicate'] = "Please Insert An Unique Title";
    
                }
    
            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id=' . $vendorid . '');
    
            }
    
            else {
                
                $oldphotolocationname = $product['product_image_location'];
    
                $extindex = strpos($oldphotolocationname, ".");
                $imageextention = substr($oldphotolocationname, $extindex, strlen($oldphotolocationname));
    
                $folder = "uploads/";
                $photoname = (String) $vendorid . '_' . $newproducttitle;
                $newname = str_replace(" ", "_", $photoname);
                $newname = str_replace(".", "", $newname);
                $newname = str_replace(":", "", $newname);
                $newname = str_replace("?", "", $newname);
                $newname = str_replace("!", "", $newname);
                $newphotolocationname = $folder . $newname . $imageextention;  
                
                rename($oldphotolocationname,  $newphotolocationname);
                changeProductTitle($pdo, $vendorid, $productid, $newproducttitle, $newphotolocationname);
                $changestatus = "Product Title Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');
    
            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }


    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductsubcategory") {

        try {

            $newsubcategoryid = (int) $_POST['subcategoryid'];
            $productid = (int) $_POST['product_id'];
            $vendorid = (int) $_POST['vendor_id'];
            ChangeProductSubcategory($pdo, $vendorid, $productid, $newsubcategoryid);
            $changestatus = "Product Subcategory Has Been Changed Successfully";
            header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductwholesaleprice") {

        $newproductwholesaleprice  = (float) $_POST['productwholesaleprice'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (empty($newproductwholesaleprice)) {

                $productchangeserrors['empty_wholesaleprice'] = "Please Insert A Title"; 

            }

            if ($newproductwholesaleprice) {

                if (priceErrorCheckForEdit($newproductwholesaleprice)) {

                    $productchangeserrors['invalid_wholesaleprice'] = "Please Insert A Valid Numner"; 

                }

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductWholesaleprice($pdo, $vendorid, $productid, $newproductwholesaleprice);
                $changestatus = "Product Wholesale Price Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');

            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductretailprice") {

        $newproductretailprice = (float) $_POST['productretailprice'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (empty($newproductretailprice)) {

                $productchangeserrors['empty_retailprice'] = "Please Insert A Title"; 

            }

            if ($newproductretailprice) {

                if (priceErrorCheckForEdit($newproductretailprice)) {

                    $productchangeserrors['invalid_retailprice'] = "Please Insert A Valid Numner"; 

                }

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductRetailsaleprice($pdo, $vendorid, $productid, $newproductretailprice);
                $changestatus = "Product Retail Price Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');

            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }
    
    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductbrandname") {

        $newproductbrandname = $_POST['productbrandname'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (empty($newproductbrandname)) {

                $productchangeserrors['empty_brandname'] = "Please Insert A Brand Name";

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductBrandname($pdo, $vendorid, $productid, $newproductbrandname);
                $changestatus = "Product Brand Name Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');

            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductsku") {

        $newproductsku = $_POST['productsku'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (empty($newproductsku)) {

                $productchangeserrors['empty_sku'] = "Please Insert SKU";

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductSku($pdo, $vendorid, $productid, $newproductsku);
                $changestatus = "Product SKU Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');

            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }
    
    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductquantity") {

        $newproductquantity = (int) $_POST['productquantity'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (empty($newproductquantity) || !is_int($newproductquantity)) {

                $productchangeserrors['empty_sku_or_invalid_quantity'] = "Please Insert SKU Or Valid Number";

            }

            if ($newproductquantity) {

                if (priceErrorCheckForEdit($newproductquantity)) {

                    $productchangeserrors['invalid_quantity'] = "Please Enter Valid Quantity";

                }

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductQuantity($pdo, $vendorid, $productid, $newproductquantity);
                $changestatus = "Product Quantity Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');

            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductwarranty") {
    
        $newproductwarranty = (int) $_POST['productwarranty'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (empty($newproductwarranty) || !is_int($newproductwarranty)) {

                $productchangeserrors['empty_sku_or_invalid_quantity'] = "Please Insert A Warranty Or Valid Number";

            }

            if ($newproductwarranty) {

                if (priceErrorCheckForEdit($newproductwarranty)) {

                    $productchangeserrors['invalid_quantity'] = "Please Enter Valid Quantity";

                }

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductWarranty($pdo, $vendorid, $productid, $newproductwarranty);
                $changestatus = "Product Warranty Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');

            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductsold") {

        $newproductsoldamount = (int) $_POST['productsold'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (empty($newproductsoldamount) || !is_int($newproductsoldamount)) {

                $productchangeserrors['invalid_quantity'] = "Please Insert A Sold Number Or Valid Number";

            }

            if ($newproductsoldamount) {

                if (priceErrorCheckForEdit($newproductsoldamount)) {

                    $productchangeserrors['invalid_quantity'] = "Please Enter Valid Quantity";

                }

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductSoldAmount($pdo, $vendorid, $productid, $newproductsoldamount);
                $changestatus = "Product Sold Amount Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');

            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }
    
    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductdescription") {

        $newproductdescription = $_POST['productdescription'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (empty($newproductdescription)) {

                $productchangeserrors['empty_description'] = "Please Insert Description";

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductDescription($pdo, $vendorid, $productid, $newproductdescription);
                $changestatus = "Product Description Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');
                
            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductspecification") {

        $newspecification = $_POST['productspecification'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];

        try {

            if (empty($newspecification)) {

                $productchangeserrors['empty_specification'] = "Please Insert Specification";

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductSpecification($pdo, $vendorid, $productid, $newspecification);
                $changestatus = "Product Specification Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');
                
            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductimagelocation") {

        $newproductimagelocation = $_FILES['productimagelocation'];
        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];
        $product = getAProductDetails($pdo, $vendorid, $productid);
        $oldproductimagelocation = $product['product_image_location'];
        $producttitle = $product['product_title'];

        try {

            if ($newproductimagelocation) {

                $allowedextentionforimage = array("jpg", "jpeg", "png");
                $productphotoextension = pathinfo($newproductimagelocation['name'], PATHINFO_EXTENSION);

                if (!(($newproductimagelocation["type"] == "image/png") || ($newproductimagelocation["type"] == "image/jpg") || ($newproductimagelocation["type"] == "image/jpeg")) && in_array($productphotoextension, $allowedextentionforimage)) {

                    $productchangeserrors['invalid_image_format'] = "Please Insert A JPEG/PNG FILE";

                }

                if ($newproductimagelocation["error"] > 0) {

                    $productchangeserrors['too_many_errors'] = "Uploaded File Has too Many Errors";
                
                }


                $folder = "uploads/";
                $photoname = $vendorid . '_' . $producttitle;
                $newname = str_replace(" ", "_", $photoname);
                $newname = str_replace(".", "", $newname);
                $newname = str_replace(":", "", $newname);
                $newname = str_replace("?", "", $newname);
                $newname = str_replace("!", "", $newname);        
                $newproductimagelocation['name'] = $newname;
                
                unlink($oldproductimagelocation);
                move_uploaded_file($newproductimagelocation['tmp_name'], $folder . $newproductimagelocation['name'] . '.' . $productphotoextension);
                $newproductimagelocationname = $folder . $newproductimagelocation['name'] . '.' . $productphotoextension;

            }

            else {

                $newproductimagelocationname = "uploads/no_image.jpg";

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductImageLocation($pdo, $vendorid, $productid, $newproductimagelocationname);
                $changestatus = "Product Image Has Been Changed Successfully";
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '&status='. $changestatus .'');
                
            }

            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nproductdeliverylocation") {

        $productid = (int) $_POST['product_id'];
        $vendorid = (int) $_POST['vendor_id'];
        $newdistrictids = $_POST['newdistricts'];

        try {

            if (!$newdistrictids) {

                $productchangeserrors['empty_district_id'] = "Please Add Districts";

            }

            if ($productchangeserrors) {

                $_SESSION['product_edit_error'] = $productchangeserrors;
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

            else {

                changeProductDistrictId($pdo, $productid, $newdistrictids);
                header('Location: productedit.php?product_id=' . $productid . '&vendor_id='. $vendorid . '');

            }

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else {

        header('Location: productedit.php');
        die();

    }

 
?>