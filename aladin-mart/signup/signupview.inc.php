<?php

    declare(strict_types=1);

    function checkSignUpStatus() {

        if (isset($_SESSION['error_at_signup'])) {

            $errors = $_SESSION["error_at_signup"];
            echo "<h3> Error: </h3>";

            foreach ($errors as $key => $value) {

                echo '<p class="form-error">' . $errors[$key] . '</br></p>';

            }

            unset($_SESSION['error_at_signup']);
            
        }
        
        else if (isset($_GET['signup']) && $_GET['signup'] == "successful") {

            echo '<p class="form-success">Successfully Signed Up</br></p>';
        
        }

    }


?>