<?php

    declare(strict_types=1);

    function getProductDeliveryDistrictIdFromDB($pdo, $productid) {

        $query = "SELECT district_id FROM product_delivery_locations WHERE product_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function getProductInformationForCartFromDB(object $pdo, int $productid) {

        $query = "SELECT p.product_title, p.product_image_location, s.sub_category_name, p.product_retail_price, v.user_shop_name, v.id, v.user_number, 
        v.user_email FROM products p JOIN users v ON p.vendor_id = v.id JOIN subcategories s ON s.id = p.subcategory_id WHERE p.id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function getProductQuantityFromDB(object $pdo, int $productid) {

        $query = "SELECT product_quantity FROM products WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['product_quantity'];

    }

    function addToSoldTableOnDB(object $pdo, int $customerid, int $productid, int $vendorid, int $purchasequantity, float $productretailprice, String $customernumber, float $totalprice, int $districtid, String $productdeliveryaddress) {

        $query1 = "INSERT INTO cart_table (customer_id, product_id, vendor_id, purchase_quantity, product_retail_price, total_price, district_id, customer_number, purchased_on, delivery_address)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), ?);";
        $stmt = $pdo->prepare($query1);
        $stmt->execute([$customerid, $productid, $vendorid, $purchasequantity, $productretailprice, $totalprice, $districtid, $customernumber, $productdeliveryaddress]);

        $query2 = "UPDATE products SET product_quantity = product_quantity - ? WHERE id = ?;";
        $stmt = $pdo->prepare($query2);
        $stmt->execute([$purchasequantity, $productid]);

    }

    function getVendorTransactionFromDB(object $pdo, int $vendorid, int $selectionid) {

        if ($selectionid == 5) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.vendor_id = 
            ?;";

        }
        
        else if ($selectionid == 0) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.vendor_id = 
            ? AND ct.delivery_status_id = 0;";

        }

        else if ($selectionid == 1) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.vendor_id = 
            ? AND ct.delivery_status_id = 1;";

        }

        else if ($selectionid == 2) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.vendor_id = 
            ? AND ct.delivery_status_id = 2;";

        }

        else if ($selectionid == 3) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.vendor_id = 
            ? AND ct.delivery_status_id = 3;";

        }

        else if ($selectionid == 4) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.vendor_id = 
            ? AND ct.delivery_status_id = 4;";

        }

        $stmt = $pdo->prepare($query);
        $stmt->execute([$vendorid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function changeStatusOnDB(object $pdo, int $transactionid, int $newstatusid) {

        $query = "UPDATE cart_table SET delivery_status_id = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newstatusid, $transactionid]);

    }

    function getAllTransactionFromDB(object $pdo, int $selectionid) {

        if ($selectionid == 5) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id;";
            
        }

        if ($selectionid == 0) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.delivery_status_id = 0;";

        }

        if ($selectionid == 1) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.delivery_status_id = 1;";

        }

        if ($selectionid == 2) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.delivery_status_id = 2;";

        }

        if ($selectionid == 3) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.delivery_status_id = 3;";

        }

        if ($selectionid == 4) {

            $query = "SELECT ct.id, p.product_title, p.product_sku, p.product_wholesale_price, p.product_retail_price, s.sub_category_name, ct.purchase_quantity, 
            ct.total_price, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, v.user_first_name AS vendor_first_name, 
            v.user_last_name AS vendor_last_name, ct.customer_number, d.district_name, ct.delivery_address, ct.purchased_on, ds.status_name FROM cart_table 
            ct JOIN products p ON ct.product_id = p.id JOIN users c ON c.id = ct.customer_id JOIN subcategories s ON s.id = p.subcategory_id JOIN users 
            v ON v.id = ct.vendor_id JOIN districts d ON d.id = ct.district_id JOIN delivery_status ds ON ct.delivery_status_id = ds.id WHERE ct.delivery_status_id = 4;";

        }

        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

?>