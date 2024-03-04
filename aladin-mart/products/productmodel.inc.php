<?php

    declare(strict_types=1);

    function productDuplicateCheckOnDB(object $pdo, String $producttitle, int $vendorid) {

        $query = "SELECT id FROM products WHERE product_title = ? AND vendor_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$producttitle, $vendorid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function skuDuplicateCheck(object $pdo, String | null $productsku) {

        $query = "SELECT id FROM products WHERE product_sku = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productsku]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function addAProductOnDB(object $pdo, int $vendorid, String $producttitle, int $subcategoryid, float $productwholesaleprice, float $productretailprice, String | null $productbrandname, String $productsku, int $productquantity, int $productwarranty, String | null $productdescription, String | null $productspecification, String | null $productimagelocationname) {

        $query1 = "INSERT INTO products (vendor_id, product_title, subcategory_id, product_wholesale_price, product_retail_price, product_brandname, product_sku, product_quantity, product_warranty, product_description, product_specification, product_image_location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $pdo->prepare($query1);
        $stmt->execute([$vendorid, $producttitle, $subcategoryid, $productwholesaleprice, $productretailprice, $productbrandname, $productsku, $productquantity, $productwarranty, $productdescription, $productspecification, $productimagelocationname]);

        $query2 = "SELECT id FROM products ORDER BY id  DESC LIMIT  0, 1;";
        $stmt = $pdo->prepare($query2);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $productid = $result['id'];
        $query3 = "INSERT INTO reviews (product_id) VALUES (?);";
        $stmt = $pdo->prepare($query3);
        $stmt->execute([$productid]);

    }

    function getLastProductIDFromDB(object $pdo) {

        $query = "SELECT id FROM products ORDER BY id  DESC LIMIT  0, 1;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function getProductsForAVendorFromDB(object $pdo, int $vendorid) {

        $query = "SELECT p.id, p.product_title, c.category_name, s.sub_category_name, p.product_wholesale_price, p.product_retail_price, p.product_quantity, p.product_sold,
        p.product_image_location, p.product_created FROM products p JOIN subcategories s ON s.id = p.subcategory_id JOIN categories c ON s.category_id = c.id 
        WHERE p.vendor_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$vendorid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function getAProductDetailsFromDB(object $pdo, int $vendorid, int $productid) {

        $query = "SELECT p.id, p.vendor_id, p.product_title, c.category_name, s.sub_category_name, p.product_retail_price, p.product_brandname, p.product_sku, p.product_quantity, p.product_warranty, 
        p.product_description, p.product_specification, p.product_image_location, p.product_created, u.user_first_name, u.user_last_name, u.user_email, u.user_number, u.user_shop_name 
        FROM products p JOin users u ON u.id = p.vendor_id JOIN subcategories s ON s.id = p.subcategory_id JOIN categories c ON s.category_id = c.id WHERE p.vendor_id = ? AND p.id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$vendorid, $productid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }
    
    function getAProductDetailsForEditFromDB(object $pdo, int $vendorid, int $productid) {

        $query = "SELECT p.vendor_id, p.product_title, s.sub_category_name, p.product_wholesale_price, p.product_retail_price, p.product_brandname, p.product_sku, p.product_quantity, p.product_warranty, 
        p.product_sold, p.product_description, p.product_specification, p.product_image_location FROM products p JOIN subcategories s ON p.subcategory_id = s.id WHERE p.id = ? AND p.vendor_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productid, $vendorid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function changeProductTitleOnDB(object $pdo, int $vendorid, int $productid, String $newproducttitle, String $newphotolocationname) {

        $query = "UPDATE products SET product_title = ?, product_image_location = ? WHERE id = ? AND vendor_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproducttitle, $newphotolocationname, $productid, $vendorid]);

    }

    function changeProductSubcategoryOnDB(object $pdo, int $vendorid , int $productid, int $newsubcategoryid) {

        $query = "UPDATE products SET subcategory_id = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newsubcategoryid, $vendorid, $productid]);

    }

    function changeProductWholesalepriceOnDB(object $pdo, int $vendorid , int $productid, int | float $newproductwholesaleprice) {

        $query = "UPDATE products SET product_wholesale_price = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproductwholesaleprice, $vendorid, $productid]);

    }

    function changeProductRetailsalepriceOnDB(object $pdo, int $vendorid , int $productid, int | float $newproductretailprice) {

        $query = "UPDATE products SET product_retail_price = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproductretailprice, $vendorid, $productid]);

    }

    function changeProductBrandnameOnDB(object $pdo, int $vendorid , int $productid, String $newproductbrandname) {

        $query = "UPDATE products SET product_brandname = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproductbrandname, $vendorid, $productid]);

    }

    function changeProductSkuOnDB(object $pdo, int $vendorid , int $productid, String $newproductsku) {

        $query = "UPDATE products SET product_sku = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproductsku, $vendorid, $productid]);

    }

    function changeProductQuantityOnDB(object $pdo, int $vendorid , int $productid, int $newproductquantity) {

        $query = "UPDATE products SET product_quantity = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproductquantity, $vendorid, $productid]);

    }

    function changeProductWarrantyOnDB(object $pdo, int $vendorid , int $productid, int $newproductwarranty) {

        $query = "UPDATE products SET product_warranty = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproductwarranty, $vendorid, $productid]);

    }

    function changeProductSoldAmountOnDB(object $pdo, int $vendorid , int $productid, int $newproductsoldamount) {

        $query = "UPDATE products SET product_sold = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproductsoldamount, $vendorid, $productid]);

    }

    function changeProductDescriptionOnDB(object $pdo, int $vendorid, int $productid, String $newproductdescription) {

        $query = "UPDATE products SET product_description = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproductdescription, $vendorid, $productid]);

    }

    function changeProductSpecificationOnDB(object $pdo, int $vendorid, int $productid, String $newspecification) {

        $query = "UPDATE products SET product_specification = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newspecification, $vendorid, $productid]);

    }
    
    function changeProductImageLocationOnDB(object $pdo, int $vendorid , int $productid, String $newproductimagelocationname) {

        $query = "UPDATE products SET product_image_location = ? WHERE vendor_id = ? AND id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newproductimagelocationname, $vendorid, $productid]);

    }

    function  changeProductDistrictIdOnDB($pdo, $productid, $newdistrictids) {

        $query1 = "DELETE FROM product_delivery_locations WHERE $productid = ?;";
        $stmt = $pdo->prepare($query1);
        $stmt->execute([$productid]);

        foreach ($newdistrictids as $key => $values) {

            $query2 = "INSERT INTO product_delivery_locations (product_id, district_id) VALUES (?, ?);";
            $stmt = $pdo->prepare($query2);
            $districtid = (int) $newdistrictids[$key];
            $stmt->execute([$productid, $districtid]);

        }

    }

    function getAllProductsFromDB(object $pdo) {

        $query = "SELECT p.id, p.vendor_id, p.product_image_location, p.product_title, p.product_retail_price, (((1 * r.product_1_star_count) + (2 * r.product_2_star_count) + (3 * r.product_3_star_count) + 
        (4 * r.product_4_star_count) + (5 * r.product_5_star_count)) / (r.product_1_star_count + r.product_2_star_count + r.product_3_star_count + r.product_4_star_count + r.product_5_star_count)) 
        AS product_review FROM products p JOIN reviews r ON r.product_id = p.id;";  
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function setReviewOnDB(object $pdo, int $review, int $productid) {

        if ($review == 1) {

            $query = "UPDATE reviews SET product_1_star_count = product_1_star_count + 1 WHERE product_id = ?;";

        }

        else if ($review == 2) {

            $query = "UPDATE reviews SET product_2_star_count = product_2_star_count + 1 WHERE product_id = ?;";

        }

        else if ($review == 3) {

            $query = "UPDATE reviews SET product_3_star_count = product_3_star_count + 1 WHERE product_id = ?;";

        }

        else if ($review == 4) {

            $query = "UPDATE reviews SET product_4_star_count = product_4_star_count + 1 WHERE product_id = ?;";

        }

        else if ($review == 5) {

            $query = "UPDATE reviews SET product_5_star_count = product_5_star_count + 1 WHERE product_id = ?;";

        }

        $stmt = $pdo->prepare($query);
        $stmt->execute([$productid]);

    }

    function getProductReviewFromDB(object $pdo, int $productid) {

        $query = "SELECT (((1 * r.product_1_star_count) + (2 * r.product_2_star_count) + (3 * r.product_3_star_count) + 
        (4 * r.product_4_star_count) + (5 * r.product_5_star_count)) / (r.product_1_star_count + r.product_2_star_count + r.product_3_star_count + r.product_4_star_count + r.product_5_star_count)) 
        AS product_review FROM reviews r WHERE r.product_id = ?;";  
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['product_review'];

    }

    function setReviewmessageOnDB(object $pdo, int $productid, int $customerid, int $review, String | null $reviewmessage) {

        $query = "INSERT INTO review_messages (reviewer_id, product_id, review_value, review_message) VALUES (?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$customerid, $productid, $review, $reviewmessage]);

    }

    function getProductReviewMessagesFromDB(object $pdo, int $productid) {

        $query = "SELECT c.user_first_name, c.user_last_name, r.id, r.reviewer_id, r.review_value, r.review_message FROM review_messages r JOIN users c 
        ON c.id = r.reviewer_id WHERE product_id = ? ORDER BY r.id;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function deleteReviewFromDB(object $pdo, int $reviewid) {

        $query = "DELETE FROM review_messages WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$reviewid]);

    }

    function editReviewOnDB(object $pdo, String | null $newreviewmessage, int $reviewid) {

        $query = "UPDATE review_messages SET review_message = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newreviewmessage, $reviewid]);

    }

    function setQuestionOnDB(object $pdo, int $customerid, int $vendorid, int $productid, String $question) {

        $query = "INSERT INTO questions_and_answers (customer_id, vendor_id, product_id, question) VALUES (?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$customerid, $vendorid, $productid, $question]);

    }

    function getQAsForCustomerFromDB(object $pdo, int $productid) {

        $query = "SELECT c.user_first_name, c.user_last_name, qa.id, qa.customer_id, qa.vendor_id, qa.question, qa.answer FROM questions_and_answers qa JOIN 
        users c ON c.id = qa.customer_id JOIN products p ON p.id = qa.product_id WHERE p.id = ? ORDER BY qa.id;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function deleteQuestionFromDB(object $pdo, int $qaid) {

        $query = "DELETE FROM questions_and_answers WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$qaid]);

    }
    
    function editQuestionOnDB(object $pdo, String $newquestion, int $qaid) {

        $query = "UPDATE questions_and_answers SET question = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newquestion, $qaid]);

    }

    function editAnswerOnDB(object $pdo, String $newanswer, int $qaid) {

        $query = "UPDATE questions_and_answers SET answer = ? WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newanswer, $qaid]);

    }

    function addDeliveryLocationOnDB(object $pdo, int $productid, array $districtids) {

        foreach ($districtids as $key => $values) {

            $query = "INSERT INTO product_delivery_locations (product_id, district_id) VALUES (?, ?);";
            $stmt = $pdo->prepare($query);
            $districtid = (int) $districtids[$key];
            $stmt->execute([$productid, $districtid]);

        }

    }

    function getProductDeliveryLocationsFromDB(object $pdo, int $productid) {

        $query = "SELECT d.district_name FROM product_delivery_locations dl JOIN products p ON p.id = dl.product_id JOIN districts d ON d.id = dl.district_id 
        WHERE p.id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function getAllDistrictsFromDB(object $pdo) {

        $query = "SELECT * FROM districts;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }

    function getDistrictNameFromDB(object $pdo, int $districtid) {

        $query = "SELECT district_name FROM districts WHERE id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$districtid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['district_name'];

    }

    function getAllProductsByCategoryFromDB(object $pdo, int $categoryid) {

        $query = "SELECT p.id, c.category_name, p.vendor_id, p.product_image_location, p.product_title, p.product_retail_price, (((1 * r.product_1_star_count) + (2 * r.product_2_star_count) + (3 * r.product_3_star_count) + 
        (4 * r.product_4_star_count) + (5 * r.product_5_star_count)) / (r.product_1_star_count + r.product_2_star_count + r.product_3_star_count + r.product_4_star_count + r.product_5_star_count)) 
        AS product_review FROM products p JOIN reviews r ON r.product_id = p.id JOIN subcategories sc ON sc.id = p.subcategory_id JOIN categories c ON sc.category_id = c.id WHERE c.id = ?;";  
        $stmt = $pdo->prepare($query);
        $stmt->execute([$categoryid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function getAllProductsBySubcategoryFromDB(object $pdo, int $subcategoryid) {

        $query = "SELECT p.id, sc.sub_category_name, p.vendor_id, p.product_image_location, p.product_title, p.product_retail_price, (((1 * r.product_1_star_count) + (2 * r.product_2_star_count) + (3 * r.product_3_star_count) + 
        (4 * r.product_4_star_count) + (5 * r.product_5_star_count)) / (r.product_1_star_count + r.product_2_star_count + r.product_3_star_count + r.product_4_star_count + r.product_5_star_count)) 
        AS product_review FROM products p JOIN reviews r ON r.product_id = p.id JOIN subcategories sc ON sc.id = p.subcategory_id WHERE sc.id = ?;";  
        $stmt = $pdo->prepare($query);
        $stmt->execute([$subcategoryid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function getProductsSortByReviewFromDB(object $pdo) {

        $query = "SELECT p.id, p.vendor_id, p.product_image_location, p.product_title, p.product_retail_price, (((1 * r.product_1_star_count) + (2 * r.product_2_star_count) + (3 * r.product_3_star_count) + 
        (4 * r.product_4_star_count) + (5 * r.product_5_star_count)) / (r.product_1_star_count + r.product_2_star_count + r.product_3_star_count + r.product_4_star_count + r.product_5_star_count)) 
        AS product_review FROM products p JOIN reviews r ON r.product_id = p.id ORDER BY product_review DESC LIMIT 0, 10;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function getRecentProductsFromDB(object $pdo) {

        $query = "SELECT p.id, p.vendor_id, p.product_image_location, p.product_title, p.product_retail_price, (((1 * r.product_1_star_count) + (2 * r.product_2_star_count) + (3 * r.product_3_star_count) + 
        (4 * r.product_4_star_count) + (5 * r.product_5_star_count)) / (r.product_1_star_count + r.product_2_star_count + r.product_3_star_count + r.product_4_star_count + r.product_5_star_count)) 
        AS product_review FROM products p JOIN reviews r ON r.product_id = p.id ORDER BY p.id DESC LIMIT 0, 10;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

?>