<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../cart/addtocartcontroller.inc.php';
    require_once '../cart/addtocartmodel.inc.php';
    require_once '../cart/addtocartview.inc.php';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
    </head>
    <body>

        <?php

            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "vendor") {

                $vendorid = $_SESSION['user_id'];
                header('Location: ../index.php');

            }

            $vendorname = (String) $_SESSION['user_name'];
            $vendorid = (int) $_SESSION['user_id'];
            echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $vendorname))) . '</br>';
            echo'</br>
                    <a href="../vendor/vendorhomepage.php?loggedin=successful">
                        <button>Back To Vendor Homepage</button>
                    </a>    
                </br></br>';

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
            
            if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "vendor") && isset($_GET['selectionid'])) {

                $selectionid = (int) $_GET['selectionid'];
                $transactions = getVendorTransaction($pdo, $vendorid, $selectionid);

                if ($transactions) {

                    showtransactions($transactions);

                }

                else {

                    echo '<p class="form-error">No Transaction Found</br></p>';

                }

        }
        
        ?>

    </body>
</html>