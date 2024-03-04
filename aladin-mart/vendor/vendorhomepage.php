<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../track/trackcontroller.inc.php';
    require_once '../track/trackmodel.inc.php';
    require_once '../track/trackview.inc.php';

    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "vendor") {

        header('Location: ../index.php');

    }
    
    $vendorid = $_SESSION['user_id'];
    $vendorname = (String) $_SESSION['user_name'];
    echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $vendorname))) . '</br>';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <style>
            h1,
            h2 {
                margin: 0;
            }
            .vendorHomeCardContainer {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 2rem 3rem;
            }
            .vendorHomeCard {
                width: 20%;
                box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.153);
                padding: 1rem;
                border-radius: 10px;
                display: flex;
                flex-direction: column;
                row-gap: 1rem;
                align-items: center;
            }
        </style>
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
                <a href="../profile/userprofile.php?current_user_id=' . $vendorid .'">
                    <button>My Profile</button>
                </a>    
            </br>';
        
            $numberofproducttypes = getNumberOfProductTypes($pdo, $vendorid);
            $totalnumberofproducts = getTotalNumberOfProducts($pdo, $vendorid);
            $productsold = getMySoldProducts($pdo, $vendorid);

            echo '<div class="vendorHomeCardContainer">
                    <div class="vendorHomeCard">
                        <h1>Number Of Product Types</h1>
                        <h2>' . $numberofproducttypes .'</h2>
                    </div>
                    <div class="vendorHomeCard">
                        <h1>Total Products In Stock</h1>
                        <h2>' . $totalnumberofproducts . '</h2>
                    </div>
                    <div class="vendorHomeCard">
                        <h1>Sold Count</h1>
                        <h2>' . $productsold . '</h2>
                    </div>
                </div>';

        ?>

        </br>
        <h2>Add A Product: </h2>
        <a href="../products/addproducts.php">
            <button>Add Products</button>
        </a>    
        </br>

        </br>
        <h2>My Product: </h2>

        <?php

            echo'</br>
                <a href="../products/productslist.php?vendor_id=' . $vendorid . '">
                    <button>Product List</button>
                </a>    
            </br>';
        
        ?>

        <h2>My Transactions: </h2>
        <?php
        
            echo '</br>
                    <a href="../cart/vendortransactionlist.php?vendor_id=' . $vendorid . '">
                        <button>Product List</button>
                    </a>    
                </br>';
        ?>

        <h2>Search By Date</h2>
        <form action="" method="get">
            <label for="track">Pick Date:</label>
            <input type="date" id="track" name="track" value="<?php echo date('Y-m-d'); ?>">
            <input type="submit">
        </form>
        
        <?php
        
            if (isset($_GET['track'])) {

                $date = (String) $_GET['track'];
                $trackingproducts = trackMyProductsByDate($pdo, $vendorid, $date);

                if ($trackingproducts) {

                    echo '<h3>Selected Date; ' . htmlspecialchars($date) . '</br></h3>';
                    showTrackedProducts($trackingproducts);

                }

                else {

                    echo '<p class="form-error">No Transaction Occured On That Day</br></p>';

                }

            }

            else {

                echo '<p>Select A Date</br></p>';

            }
        
        ?>
        
        

    </body>
</html>