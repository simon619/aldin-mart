<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'adminmodel.inc.php';
    require_once 'admincontroller.inc.php';
    require_once 'adminview.inc.php';

    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "admin") {

        header('Location: ../index.php');

    }

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
    </head>
    <body>

        </br>
        <a href="../admin/adminhomepage.php">
            <button>Admin Homepage</button>
        </a>    
        </br>

        <?php

            if (isset($_SESSION['current_customer_id'])) {

                unset($_SESSION['current_customer_id']);

            }

            $vendorname = (String) $_SESSION['user_name'];
            $vendorid = (int) $_SESSION['user_id'];
            echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $vendorname))) . '</br>';

            if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "admin")) {

                echo '<h3>Enter Prefix of Customer Name</h3>
                    <form action="" method="get">
                        <label for="prefixname">Product Name: </label>
                        <input required id="prefixname" type="text" name="prefixname" placeholder="Enter Vendor Name">
                        </br>
                    <button type="submit">Submit</button>
                </form></br>';

                if (isset($_GET['prefixname'])) {

                    $prefixname = $_GET['prefixname'];
                    $customers = getCustomerByPrefix($pdo, $prefixname);
                    
                    if ($customers[0]['user_first_name']) {

                        showCustomers($customers);

                    }

                    else {

                        echo '<p class="form-error">No Customer Found</br></p>';

                    }

                }


                else {

                    echo '<p class="form-error">Type Customer Name</br></p>';

                }

            }
        
        ?>
    
    </body>
</html>