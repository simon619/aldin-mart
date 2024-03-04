<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';

    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "admin") {

        header('Location: ../index.php');

    }

    $adminname = (String) $_SESSION['user_name'];
    $adminid = (int) $_SESSION['user_id'];
    echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $adminname))) . '</br>';

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
        <?php
        
            echo '</br>
                    <a href="../profile/userprofile.php?current_user_id=' . $adminid .'">
                        <button>My Profile</button>
                    </a>    
                </br>';
        ?>
        
        </br>
        <h2>Add A Category: </h2>
        <a href="addcategoryandsubcategory.php">
            <button>Add Category / Subcategory</button>
        </a>    
        </br>
        
        <h2>My Transactions: </h2>
        <?php
        
            echo '</br>
                    <a href="../cart/allvendortransactionlist.php">
                        <button>All Vendor Transaction List</button>
                    </a>    
                </br>';
        ?>

        <h2>Vendor List</h2>
        <?php
        
            echo '</br>
                    <a href="vendorlist.php">
                        <button>Vendor List</button>
                    </a>    
                </br>';
        ?>

        <h2>Customer List</h2>
        <?php
        
            echo '</br>
                    <a href="customerlist.php">
                        <button>Customer List</button>
                    </a>    
                </br>';
        ?>

        <h2>Get User's Spend and Earn</h2>
        <?php
        
            echo '</br>
                    <a href="earnandspendlist.php">
                        <button>Go To List</button>
                    </a>    
                </br>';
        ?>

    </body>
</html>