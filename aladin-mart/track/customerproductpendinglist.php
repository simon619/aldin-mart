<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../track/trackcontroller.inc.php';
    require_once '../track/trackmodel.inc.php';
    require_once '../track/trackview.inc.php';

    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "customer") {

        header('Location: ../index.php');

    }
    
    $customername = (String) $_SESSION['user_name'];
    $customerid = (int) $_SESSION['user_id'];
    echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $customername))) . '</br>';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
    </head>
    <body>

         </br>
            <a href="../customer/customerhomepage.php">
                <button>Customer Homepage</button>
            </a>    
        </br>

        <?php
        
            if (isset($_SESSION['cancelled'])) {

                echo '<p class="form-success">' . $_SESSION['cancelled'] . '</br></p>';
                unset($_SESSION['cancelled']);

            }
        
        ?>

        <h2>My Pending List</h2>

        <?php
        
            if (isset($_SESSION['user_id']) && ((int) $_SESSION['user_id'] == $customerid || $_SESSION['user_type'] == "admin")) {

                $pendingtransactions = getCustomerTransactions($pdo, $customerid, 0);

                if ($pendingtransactions) {

                    showCustomerPendingTransactions($pendingtransactions);

                }

                else {

                    echo '<p class="form-error">No Transaction Found</br></p>';

                }

            }
        
        ?>


    </body>
</html>