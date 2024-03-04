<?php

    declare(strict_types=1);

    function loggedInStatus() {
        
        if (isset($_SESSION['errors_on_login'])) {
            
            $errors = $_SESSION["errors_on_login"];

            echo "<h3> Error: </h3>";
            foreach ($errors as $key => $value) {

                echo '<p class="form-error">' . $errors[$key] . '</br></p>';
            
            }

            unset($_SESSION['errors_on_login']);

        }

        if (isset($_SESSION['blocked_error'])) {

            echo '<p class="form-error">' . htmlspecialchars($_SESSION['blocked_error']) . '</br></p>';
            unset($_SESSION['blocked_error']);

        }

        else if (isset($_GET['loggedin']) && $_GET['loggedin'] == "successful") {

            $username = (String) $_SESSION['user_name'];
            $username = str_replace("_", " ", $username);
            echo 'Logged In Successfully !</br> Welcome ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $username))) . '';

        }
        
    }

?>