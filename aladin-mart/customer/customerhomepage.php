<?php
    declare(strict_types=1);

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';

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
        <a href="../logout/logout.inc.php">
            <button>Log Out</button>
        </a>    
        </br>
        
        </br>
        <a href="../index.php">
            <button>Home Page</button>
        </a>    
        </br>

        <?php

            echo '</br>
                    <a href="../profile/userprofile.php?current_user_id=' . $customerid .'">
                        <button>My Profile</button>
                    </a>    
                </br>';

        
            if (isset($_SESSION['order_confirmed'])) {

                echo '<p class="form-success">' . htmlspecialchars($_SESSION['order_confirmed']) . '</br></p>';

            }

            echo "<h2>My Cart</h2>";
            if (isset($_SESSION['user_type']) && isset($_SESSION['user_id']) && ($_SESSION['user_type'] == "customer") && isset($_SESSION['user_cart'])) {

                echo '<a href="../cart/mycartdetails.php">
                        <button>My Carts</button>
                    </a>
                    </br></br>';

            }

            else {

                echo '<h3>No Product in Your Cart</br></h3>';

            }
        
        ?>

        <h2>My Transactions: </h2>
        <?php
        
            echo '</br>
                    <a href="../track/customerproducttransactionlist.php?customer_id=' . $customerid . '">
                        <button>All My Purchase History</button>
                    </a>    
                </br>';
        ?>

        <h2>My Pending Products</h2>
        <?php
        
            echo '</br>
                    <a href="../track/customerproductpendinglist.php?user_id=' . $customerid . '">
                        <button>All My Pending Products</button>
                    </a>    
                </br>';
        ?>

    </body>
</html>