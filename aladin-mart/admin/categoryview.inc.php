<?php

    declare(strict_types=1);

    function categoryAddedStatus() {

        if (isset($_SESSION['category_adding_error'])) {

            $errors = $_SESSION["category_adding_error"];
            echo "<h3> Error: </h3>";

            foreach ($errors as $key => $value) {

                $errorkey = ucwords(str_replace("_", " ", $key));
                $errorname = ucwords(str_replace("_", " ", $errors[$key]));
                echo '<p class="form-error">Error: ' . htmlspecialchars($errorkey) . ' Solve: ' . htmlspecialchars($errorname) . '</br></p>';

            }

            unset($_SESSION['category_adding_error']);
        }
        
        else if (isset($_GET['category_added']) && $_GET['category_added'] == "successful") {

            echo '<p class="form-success">Successfully New Category Added</br></p>';
        
        }

    }

    function subcategoryAddedStatus() {

        if (isset($_SESSION['sub_category_adding_error'])) {

            $errors = $_SESSION["sub_category_adding_error"];
            echo "<h3> Error: </h3>";

            foreach ($errors as $key => $value) {

                $errorkey = ucwords(str_replace("_", " ", $key));
                $errorname = ucwords(str_replace("_", " ", $errors[$key]));
                echo '<p class="form-error">Error: ' . htmlspecialchars($errorkey) . ' Solve: ' . htmlspecialchars($errorname) . '</br></p>';

            }

            unset($_SESSION['sub_category_adding_error']);
        }
        
        else if (isset($_GET['sub_category_added']) && $_GET['sub_category_added'] == "successful") {

            echo '<p class="form-success">Successfully New Sub Category Added</br></p>';
        
        }

    }


?>