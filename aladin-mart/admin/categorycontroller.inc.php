<?php

    declare(strict_types=1);

    function categoryEmptyCheck(String | null $categoryname) {

        return (empty($categoryname)) ? true : false;

    }

    function categoryNameDuplicateCheck(object $pdo, String $categoryname) {

        $result = categoryNameDuplicateCheckFromDB($pdo, $categoryname);
        return ($result) ? true : false;

    }

    function addACategory(object $pdo, String $categoryname) {

        addACategoryOnDB($pdo, $categoryname);

    }

    function getCategoryName(object $pdo) {

        return getCategoryNameFromDB($pdo);

    }

    function subcategoryEmptyCheck(String | null $subcategoryname) {

        return (empty($subcategoryname)) ? true : false;

    }

    function subcategoryNameDuplicateCheck(object $pdo, String | null $subcategoryname) {

        return (subcategoryNameDuplicateCheckFromDB($pdo, $subcategoryname)) ? true : false;

    }

    function addASubcategory(object $pdo, String $subcategoryname, int $categoryid) {

        addASubcategoryOnDB($pdo, $subcategoryname, $categoryid);

    }

    function getSubcategoryName(object $pdo) {

        return getSubcategoryNameFromDB($pdo);

    }

?>