<?php

    declare(strict_types=1);

    function trackMyProductsByDateFromDB(object $pdo, int $vendorid, String $date) {

        $query = "SELECT p.product_title, s.sub_category_name, c.category_name, u.user_first_name, u.user_last_name, ct.customer_number, d.district_name, p.product_retail_price, 
        ct.total_price, ct.purchase_quantity FROM cart_table ct JOIN products p ON p.id = ct.product_id JOIN subcategories s ON p.subcategory_id = s.id JOIN categories c ON 
        s.category_id = c.id JOIN districts d ON ct.district_id = d.id JOIN users u ON u.id = ct.customer_id WHERE ct.purchased_on = ? AND ct.vendor_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$date, $vendorid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function getNumberOfProductTypesFromDB(object $pdo, int $vendorid) {

        $query = "SELECT count(distinct(product_title)) AS product_types FROM products WHERE vendor_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$vendorid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['product_types'];

    }

    function getTotalNumberOfProductsFromDB(object $pdo, int $vendorid) {

        $query = "SELECT sum(product_quantity) AS product_number FROM products WHERE vendor_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$vendorid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['product_number'];

    }

    function getMySoldProductsFromDB(object $pdo, int $vendorid) {

        $query = "SELECT count(*) AS sold_number FROM cart_table WHERE vendor_id = ? AND delivery_status_id = 3;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$vendorid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['sold_number'];

    }

    function getCustomerTransactionsFromDB(object $pdo, int $customerid, int $selectionid) {


        if ($selectionid == 5) {

            $query = "SELECT ct.id AS transaction_id, ct.vendor_id, ct.customer_id, v.user_first_name AS vendor_first_name, v.user_last_name AS vendor_last_name, v.user_shop_name, v.user_number AS 
            vendor_number, v.user_email AS vendor_email, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, c.user_number AS 
            customer_personal_number, c.user_email AS customer_email, ct.customer_number AS customer_cart_number, ct.purchase_quantity, ct.total_price, ct.product_id, 
            p.product_title, p.product_retail_price, ct.purchased_on, ct.delivery_address, d.district_name, s.status_name FROM cart_table ct JOIN users v ON v.id = ct.vendor_id JOIN users c ON c.id = 
            ct.customer_id JOIN products p ON p.id = ct.product_id JOIN districts d ON d.id = district_id JOIN delivery_status s ON s.id = ct.delivery_status_id WHERE ct.customer_id = ?;";
    

        }

        else if ($selectionid == 0) {

            $query = "SELECT ct.id AS transaction_id, ct.vendor_id, ct.customer_id, v.user_first_name AS vendor_first_name, v.user_last_name AS vendor_last_name, v.user_shop_name, v.user_number AS 
            vendor_number, v.user_email AS vendor_email, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, c.user_number AS 
            customer_personal_number, c.user_email AS customer_email, ct.customer_number AS customer_cart_number, ct.purchase_quantity, ct.total_price, ct.product_id, p.product_title, 
            p.product_retail_price, ct.purchased_on, ct.delivery_address, d.district_name, s.status_name FROM cart_table ct JOIN users v ON v.id = ct.vendor_id JOIN users c ON c.id = 
            ct.customer_id JOIN products p ON p.id = ct.product_id JOIN districts d ON d.id = district_id JOIN delivery_status s ON s.id = ct.delivery_status_id WHERE ct.customer_id = ? AND ct.delivery_status_id = 0;";

        }

        else if ($selectionid == 1) {

            $query = "SELECT ct.id AS transaction_id, ct.vendor_id, ct.customer_id, v.user_first_name AS vendor_first_name, v.user_last_name AS vendor_last_name, v.user_shop_name, v.user_number AS 
            vendor_number, v.user_email AS vendor_email, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, c.user_number AS 
            customer_personal_number, c.user_email AS customer_email, ct.customer_number AS customer_cart_number, ct.purchase_quantity, ct.total_price, ct.product_id, 
            p.product_title, p.product_retail_price, ct.purchased_on, ct.delivery_address, d.district_name, s.status_name FROM cart_table ct JOIN users v ON v.id = ct.vendor_id JOIN users c ON c.id = 
            ct.customer_id JOIN products p ON p.id = ct.product_id JOIN districts d ON d.id = district_id JOIN delivery_status s ON s.id = ct.delivery_status_id WHERE ct.customer_id = ? AND ct.delivery_status_id = 1;";

        }

        else if ($selectionid == 2) {

            $query = "SELECT ct.id AS transaction_id, ct.vendor_id, ct.customer_id, v.user_first_name AS vendor_first_name, v.user_last_name AS vendor_last_name, v.user_shop_name, v.user_number AS 
            vendor_number, v.user_email AS vendor_email, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, c.user_number AS 
            customer_personal_number, c.user_email AS customer_email, ct.customer_number AS customer_cart_number, ct.purchase_quantity, ct.total_price, ct.product_id, 
            p.product_title, p.product_retail_price, ct.purchased_on, ct.delivery_address, d.district_name, s.status_name FROM cart_table ct JOIN users v ON v.id = ct.vendor_id JOIN users c ON c.id = 
            ct.customer_id JOIN products p ON p.id = ct.product_id JOIN districts d ON d.id = district_id JOIN delivery_status s ON s.id = ct.delivery_status_id WHERE ct.customer_id = ? AND ct.delivery_status_id = 2;";

        }

        else if ($selectionid == 3) {

            $query = "SELECT ct.id AS transaction_id, ct.vendor_id, ct.customer_id, v.user_first_name AS vendor_first_name, v.user_last_name AS vendor_last_name, v.user_shop_name, v.user_number AS 
            vendor_number, v.user_email AS vendor_email, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, c.user_number AS 
            customer_personal_number, c.user_email AS customer_email, ct.customer_number AS customer_cart_number, ct.purchase_quantity, ct.total_price, ct.product_id, 
            p.product_title, p.product_retail_price, ct.purchased_on, ct.delivery_address, d.district_name, s.status_name FROM cart_table ct JOIN users v ON v.id = ct.vendor_id JOIN users c ON c.id = 
            ct.customer_id JOIN products p ON p.id = ct.product_id JOIN districts d ON d.id = district_id JOIN delivery_status s ON s.id = ct.delivery_status_id WHERE ct.customer_id = ? AND ct.delivery_status_id = 3;";

        }

        else if ($selectionid == 4) {

            $query = "SELECT ct.id AS transaction_id, ct.vendor_id, ct.customer_id, v.user_first_name AS vendor_first_name, v.user_last_name AS vendor_last_name, v.user_shop_name, v.user_number AS 
            vendor_number, v.user_email AS vendor_email, c.user_first_name AS customer_first_name, c.user_last_name AS customer_last_name, c.user_number AS 
            customer_personal_number, c.user_email AS customer_email, ct.customer_number AS customer_cart_number, ct.purchase_quantity, ct.total_price, ct.product_id, 
            p.product_title, p.product_retail_price, ct.purchased_on, ct.delivery_address, d.district_name, s.status_name FROM cart_table ct JOIN users v ON v.id = ct.vendor_id JOIN users c ON c.id = 
            ct.customer_id JOIN products p ON p.id = ct.product_id JOIN districts d ON d.id = district_id JOIN delivery_status s ON s.id = ct.delivery_status_id WHERE ct.customer_id = ? AND ct.delivery_status_id = 4;";

        }

        $stmt = $pdo->prepare($query);
        $stmt->execute([$customerid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function cancelOrderOnDB(object $pdo, int $transactionid, int $customerid) {

        $query = "UPDATE cart_table SET purchase_quantity = 0, total_price = 0, delivery_status_id = 4 WHERE id = ? AND customer_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$transactionid, $customerid]);

    }

?>