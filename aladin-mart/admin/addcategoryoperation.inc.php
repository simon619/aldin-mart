<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $categorynametemp = $_POST['categoryname'];
        $categoryname = strtolower((str_replace(" ", "_", $categorynametemp)));

        try {

            require_once 'categorycontroller.inc.php';
            require_once 'categorymodel.inc.php';
            $categoryaddingerrors = array();

            if (categoryEmptyCheck($categoryname)) {

                $categoryaddingerrors['name_error'] = "Please Give The Category A Name";

            }

            if (categoryNameDuplicateCheck($pdo, $categoryname)) {

                $categoryaddingerrors['duplicate_error'] = "The Given Category Name Already Exists";

            }

            if ($categoryaddingerrors) {

                $_SESSION['category_adding_error'] = $categoryaddingerrors;
                header('Location: addcategoryandsubcategory.php');
                die();

            }

            else {

                addACategory($pdo, $categoryname);
                header('Location: addcategoryandsubcategory.php?category_added=successful');
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

        header('Location: addcategoryandsubcategory.php');
        die();

    }
 
?>