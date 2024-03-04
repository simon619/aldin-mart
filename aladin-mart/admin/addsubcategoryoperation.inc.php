<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $categoryid = ($_POST['categoryid']) ? $_POST['categoryid'] : null;
        $subcategorytemp = $_POST['subcategoryname'];
        $subcategoryname = strtolower((str_replace(" ", "_", $subcategorytemp)));

        try {

            require_once 'categorycontroller.inc.php';
            require_once 'categorymodel.inc.php';

            $subcategoryaddingerrors = array();

            if (subcategoryEmptyCheck($subcategoryname)) {

                $subcategoryaddingerrors['empty_name'] = "Please Insert A Sub Category Name";

            }

            if (subcategoryNameDuplicateCheck($pdo, $subcategoryname)) {

                $subcategoryaddingerrors['duplicate_subcategory_name'] = "Please Insert An Unique Subcategory Name";

            }

            if ($categoryid == null || $subcategoryaddingerrors) {

                $_SESSION['sub_category_adding_error'] = $subcategoryaddingerrors;
                header('Location: addcategoryandsubcategory.php');
                die();

            }

            else {

                addASubcategory($pdo, $subcategoryname, $categoryid);
                header('Location: addcategoryandsubcategory.php?sub_category_added=successful');
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