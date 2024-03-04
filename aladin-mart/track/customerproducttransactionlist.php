<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../track/trackcontroller.inc.php';
    require_once '../track/trackmodel.inc.php';
    require_once '../track/trackview.inc.php';

    if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] != "customer" && $_SESSION['user_type'] != "admin")) {

        header('Location: ../index.php');

    }
    
    $username = (String) $_SESSION['user_name'];
    $userid = (int) $_SESSION['user_id'];
    echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $username))) . '</br>';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
    </head>
    <body>

        <?php

            if (isset($_GET['customer_id'])) {

                $customerid = (int) $_GET['customer_id'];
                $_SESSION['current_customer_id'] = $customerid;

            }
        
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "admin") {

                echo '</br>
                    <a href="../admin/customerlist.php">
                        <button>Customer List</button>
                    </a>    
                </br>';


            }

            else if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "customer") {

                echo '</br>
                        <a href="../customer/customerhomepage.php">
                            <button>Customer Homepage</button>
                        </a>    
                    </br>';

            }
        
        ?>

        <?php

            echo '<form action="" method="get">
                <label for="selectionid">Transaction Type: </label>
                <select id="selectionid" name="selectionid">
                    <option value="5" selected>All</option>
                    <option value="0">Pending</option>
                    <option value="1">Packaging Process</option>
                    <option value="2">Handed Over to Carrier</option>
                    <option value="3">delivered</option>
                    <option value="4">cancelled</option>
                </select>
                <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
            </form>';
        
            if (isset($_SESSION['user_id']) && ((int) $_SESSION['user_id'] == $_SESSION['current_customer_id'] || $_SESSION['user_type'] == "admin") && isset($_GET['selectionid'])) {
                
                $customerid = $_SESSION['current_customer_id'];
                $selectionid = (int) $_GET['selectionid'];
                $transactions = getCustomerTransactions($pdo, $customerid, $selectionid);
                

                if ($transactions) {

                    showCustomerTransactions($transactions);

                }

                else {

                    echo '<p class="form-error">No Transaction Found</br></p>';

                }

            }


        ?>

    </body>
</html>