<?php

    declare(strict_types=1);

    function productEmptyCheck(String | null $producttitle, String | int | float | null $productwholesaleprice, String | int | float | null $productretailprice, String | int | float | null $productquantity, String | int | float | null $productsku) {

        return (empty($producttitle) || empty($productwholesaleprice) || empty($productquantity) || empty($productretailprice) || empty($productsku)) ? true : false;

    }

    function priceErrorCheck(int | float | null $productwholesaleprice, int | float | null  $productretailprice) {

        return ($productretailprice < 0.00 || $productwholesaleprice < 0.00) ? true : false;

    }

    function numberCheck(int | float | null $productquantity) {

        return (!is_int($productquantity) || $productquantity < 0) ? true : false; 

    }

    function productDuplicateCheck(object $pdo, String $producttitle, int $vendorid) {

        return (productDuplicateCheckOnDB($pdo, $producttitle, $vendorid)) ? true : false;

    }

    function addAProduct(object $pdo, int $vendorid, String $producttitle, int $subcategoryid, float $productwholesaleprice, float $productretailprice, String | null $productbrandname, String $productsku, int $productquantity, int $productwarranty, String | null $productdescription, String | null $productspecification, String $productimagelocationname) {

        addAProductOnDB($pdo, $vendorid, $producttitle, $subcategoryid, $productwholesaleprice, $productretailprice, $productbrandname, $productsku, $productquantity, $productwarranty, $productdescription, $productspecification, $productimagelocationname);

    }

    function getLastProductID(object $pdo) {

        return getLastProductIDFromDB($pdo);

    }

    function getProductsForAVendor(object $pdo, int $vendorid) {

        return getProductsForAVendorFromDB($pdo, $vendorid);

    }

    function getAProductDetails(object $pdo, int $vendorid , int $productid) {

        return getAProductDetailsFromDB($pdo, $vendorid, $productid);

    }

    function getAProductDetailsForEdit(object $pdo, int $vendorid , int $productid) {

        return getAProductDetailsForEditFromDB($pdo, $vendorid, $productid);

    }

    function changeProductTitle(object $pdo, int $vendorid , int $productid, String $newproducttitle, String $newphotolocationname) {

        changeProductTitleOnDB($pdo, $vendorid, $productid, $newproducttitle, $newphotolocationname);

    }

    function ChangeProductSubcategory(object $pdo, int $vendorid , int $productid, int $newsubcategoryid) {

        changeProductSubcategoryOnDB($pdo, $vendorid, $productid, $newsubcategoryid);

    }

    function priceErrorCheckForEdit(int | float $newnumber) {

        return ($newnumber < 0.00) ? true : false;

    }

    function changeProductWholesaleprice(object $pdo, int $vendorid , int $productid, int | float $newproductwholesaleprice) {

        changeProductWholesalepriceOnDB($pdo, $vendorid, $productid, $newproductwholesaleprice);

    }

    function changeProductRetailsaleprice(object $pdo, int $vendorid , int $productid, int | float $newproductretailprice) {

        changeProductRetailsalepriceOnDB($pdo, $vendorid, $productid, $newproductretailprice);

    }

    function changeProductBrandname(object $pdo, int $vendorid , int $productid, String $newproductbrandname) {

        changeProductBrandnameOnDB($pdo, $vendorid, $productid, $newproductbrandname);

    }

    function changeProductSku(object $pdo, int $vendorid , int $productid, String $newproductsku) {

        changeProductSkuOnDB($pdo, $vendorid, $productid, $newproductsku);
        
    }

    function changeProductQuantity(object $pdo, int $vendorid , int $productid, int $newproductquantity) {

        changeProductQuantityOnDB($pdo, $vendorid, $productid, $newproductquantity);

    }

    function changeProductWarranty(object $pdo, int $vendorid , int $productid, int $newproductwarranty) {

        changeProductWarrantyOnDB($pdo, $vendorid, $productid, $newproductwarranty);

    }

    function changeProductSoldAmount(object $pdo, int $vendorid , int $productid, int $newproductsoldamount) {

        changeProductSoldAmountOnDB($pdo, $vendorid, $productid, $newproductsoldamount);

    }

    function changeProductDescription(object $pdo, int $vendorid , int $productid, String $newproductdescription) {

        changeProductDescriptionOnDB($pdo, $vendorid, $productid, $newproductdescription);

    }

    function changeProductSpecification(object $pdo, int $vendorid , int $productid, String $newspecification) {

        changeProductSpecificationOnDB($pdo, $vendorid, $productid, $newspecification);

    }

    function changeProductImageLocation(object $pdo, int $vendorid , int $productid, String $newproductimagelocationname) {

        changeProductImageLocationOnDB($pdo, $vendorid, $productid, $newproductimagelocationname);

    }

    function changeProductDistrictId(object $pdo, int $productid, array $newdistrictids) {

        changeProductDistrictIdOnDB($pdo, $productid, $newdistrictids);

    }

    function getAllProducts(object $pdo) {

        return getAllProductsFromDB($pdo);

    }

    function setReview(object $pdo, int $review,  int $productid) {

        setReviewOnDB($pdo, $review, $productid);

    }

    function getProductReview(object $pdo, int $productid) {

        return getProductReviewFromDB($pdo, $productid);

    }

    function setReviewmessage(object $pdo, int $productid, int $customerid, int $review, String | null $reviewmessage) {

        setReviewmessageOnDB($pdo, $productid, $customerid, $review, $reviewmessage);

    }

    function getProductReviewMessages(object $pdo, int $productid) {

        return getProductReviewMessagesFromDB($pdo, $productid);

    }

    function deleteReview(object $pdo, int $reviewid) {

        deleteReviewFromDB($pdo, $reviewid);

    }

    function editReview(object $pdo, String | null $newreviewmessage, int $reviewid) {

        editReviewOnDB($pdo, $newreviewmessage, $reviewid);

    }

    function setQuestion(object $pdo, int $customerid, int $vendorid, int $productid, String $question) {

        setQuestionOnDB($pdo, $customerid, $vendorid, $productid, $question);

    }

    function getQAsForCustomer(object $pdo, int $productid) {

        return getQAsForCustomerFromDB($pdo, $productid);

    }

    function editQuestion(object $pdo, String $newquestion, int $qaid) {

        editQuestionOnDB($pdo, $newquestion, $qaid);

    }

    function editAnswer(object $pdo, String $newanswer, int $qaid) {

        editAnswerOnDB($pdo, $newanswer, $qaid);

    }

    function deleteQuestion(object $pdo, int $qaid) {

        deleteQuestionFromDB($pdo, $qaid);

    }

    function addDeliveryLocation(object $pdo, int | null $productid, array $districtids) {

        addDeliveryLocationOnDB($pdo, $productid, $districtids);

    }

    function getProductDeliveryLocations(object $pdo, int $productid) {

        return getProductDeliveryLocationsFromDB($pdo, $productid);

    }

    function getAllDistricts(object $pdo) {

        return getAllDistrictsFromDB($pdo);

    }
 
    function getDistrictName(object $pdo, int $districtid) {

        return getDistrictNameFromDB($pdo, $districtid);

    }

    function getAllProductsByCategory(object $pdo, int $categoryid) {

        return getAllProductsByCategoryFromDB($pdo, $categoryid);

    }

    function getAllProductsBySubcategory(object $pdo, int $subcategoryid) {

        return getAllProductsBySubcategoryFromDB($pdo, $subcategoryid);

    }

    function getProductsSortByReview(object $pdo) {

        return getProductsSortByReviewFromDB($pdo);

    }

    function getRecentProducts(object $pdo) {

        return getRecentProductsFromDB($pdo);

    }

?>