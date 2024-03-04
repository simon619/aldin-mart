<?php
    declare(strict_types=1);

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';
    require_once 'productview.inc.php';

    if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] != "vendor" && $_SESSION['user_type'] != "admin")) {

        $vendorid = $_SESSION['user_id'];
        header('Location: ../index.php');

    }

    $vendorname = (String) $_SESSION['user_name'];
    $vendorid = $_SESSION['user_id'];
    echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $vendorname))) . '</br>';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
    </head>
    <body>

        <?php
        
            if (isset($_GET['vendor_id']) && ((int) $_GET['vendor_id'] == $vendorid || $_SESSION['user_type'] == "admin")) {

                $vendorid = (int) $_GET['vendor_id'];
                $products = getProductsForAVendor($pdo, $vendorid);

                if ($products) {

                    echo '<h2>My Products</h2>';
                    showProductsForAVendor($products, $vendorid);

                }

                else {

                    echo'
                        </br>
                            <a href="../vendor/vendorhomepage.php?loggedin=successful">
                                <button>Back To Product List</button>
                            </a>    
                        </br></br>';

                    echo '<p class="form-error">Not Products Found</br></p>';

                }
                

            }

            else {

                header('Location: ../index.php');

            }
            
        
        ?>

    </body>
</html>