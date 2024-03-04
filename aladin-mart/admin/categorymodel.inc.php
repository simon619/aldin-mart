<?php

    declare(strict_types=1);

    function categoryNameDuplicateCheckFromDB($pdo, $categoryname) {

        $query = "SELECT category_name FROM categories WHERE category_name = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$categoryname]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function addACategoryOnDB(object $pdo, String $categoryname) {

        $query = "INSERT INTO categories (category_name) VALUES (?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$categoryname]);

    }

    function getCategoryNameFromDB(object $pdo) {

        $query = "SELECT id, category_name FROM categories";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function addASubcategoryOnDB(object $pdo, String $subcategoryname, int $categoryid) {

        $query = "INSERT INTO subcategories (sub_category_name, category_id) VALUES (?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$subcategoryname, $categoryid]);

    }

    function subcategoryNameDuplicateCheckFromDB(object $pdo, String |null $subcategoryname) {

        $query = "SELECT sub_category_name FROM subcategories WHERE sub_category_name = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$subcategoryname]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    function getSubcategoryNameFromDB(object $pdo) {

        $query = "SELECT id, sub_category_name FROM subcategories";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

?>