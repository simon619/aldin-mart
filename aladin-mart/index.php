<?php

    require_once 'serverside/configsession.inc.php';
    require_once 'serverside/db.inc.php';
    require_once 'login/loginview.inc.php';
    require_once 'products/productmodel.inc.php';
    require_once 'products/productcontroller.inc.php';
    require_once 'products/productview.inc.php';
    loggedInStatus();

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
            integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous">
        </script>
        <script src="asset/navbar.js"></script>
        <style>
            .productsContainer {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                row-gap: 30px;
                /* border: 1px solid red; */
            }

           .singleProdCard {
                width: 19%;
                /* border: 1px solid red; */                
            }
            
             .imgContainer {
                width: 100%;
                /* margin: 0 auto; */
            }
            .imgContainer img{
                width: 100%;
            }

        </style>
    </head>
    <body>

        </br>
        </br>
        </br>
        <?php 
            function districtSelection(object $pdo) {

                $districts = getAllDistricts($pdo);

                echo '<form action="serverside/setdistrict.inc.php" method="post">
                        <select id="districtid" name="districtid">';
                    foreach ($districts as $keys => $values) {

                        if ($values['id'] == 1) {

                            continue;

                        }
                        echo "<option value=" . $values['id'] . ">" . htmlspecialchars(ucwords(str_replace("_", " ", $values['district_name']))) . "</option>";
                    }
                echo '</select><button type="submit">Submit</button></form>';

                // if (isset($_GET['districtid'])) {

                //     $_SESSION['user_district_id'] = (int) $_GET['districtid'];
                //     header('Location: index.php');
                
                // }

            }

            if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "customer") && !isset($_SESSION['user_district_id'])) {

                echo "<p><b>Please Enter Your District Name In Order To Purchase Product</b></p>";
                districtSelection($pdo);

            }

            else if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "customer") && isset($_SESSION['user_district_id']) && (count($_SESSION['user_cart']) == 0)) {

                $districtid = (int) $_SESSION['user_district_id'];
                $districtname = (String) getDistrictName($pdo, $districtid);

                echo "<p><b>Your District Name: " . htmlspecialchars(ucwords(str_replace("_", " ", $districtname))) . "";
                echo "<p><b>Change Your District Location</b></p>";
                echo "<p>Once You Put A Product To The Cart You Can Not Change Your Location Until You Re Login</p></br>";
                districtSelection($pdo);

            }

            else if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "customer") && isset($_SESSION['user_district_id']) && (count($_SESSION['user_cart']) > 0)) {

                $districtid = (int) $_SESSION['user_district_id'];
                $districtname = (String) getDistrictName($pdo, $districtid);

                echo "<p><b>Your District Name: " . htmlspecialchars(ucwords(str_replace("_", " ", $districtname))) . "";
                echo "<p><b>You Can't Change Your District Location Now As Your Already Have Added A Product On Your Cart</b></p></br>";

            }
            
            echo "</br></br>";
        
            function showProductTest($pdo, $subcatid) {

                $query = "SELECT * FROM products WHERE subcategory_id = ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$subcatid]);
                $html = "";
                $html .= "<ul class='dropdown-menu'>";

                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $productid = $result['id'];
                    $vendorid = $result['vendor_id'];
                    $producttitle = ucwords(str_replace("_", " ", $result['product_title']));
                    $child = "no-child";
                    $html .= "<li class = '$child " . "parent-" .
                    $subcatid .
                    "'><a href='products/productdetail.php?product_id=" . $productid . "&vendor_id=" . $vendorid . "'>" . htmlspecialchars($producttitle) . 
                    "</a></li>";


                }

                $html .= "</ul>";
                return $html;

            }

            function showSubCategoryTest($pdo, $catid) {

                $query = "SELECT * FROM subcategories WHERE category_id = ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$catid]);
                $html = "";
                $html .= "<ul class='dropdown-menu'>";

                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    
                    $subcategoryid = $result['id'];
                    $parentDepth0 = "parent-depth-all";
                    $html .= "<li class= '$parentDepth0 " . 'parent-' .
                    $catid . "'><a href='products/productlistbysubcategory.php?subcategory_id=" . $subcategoryid . "' class='dropdown-toggle' data-toggle='dropdown'>" . 
                    $result['sub_category_name'] . " <b class='caret caret-right'></b></a>";
                    $html .= showProductTest($pdo, $subcategoryid);
                    $html .= "</li>";

                }

                $html .= "</ul>";
                return $html;

            }

            function showCategoryTest($pdo) {

                $query = "SELECT * FROM categories;";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                $html = "";
                $html .= "<ul class='dropdown-menu'>";
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $categoryid = $result['id'];
                    $parentDepth0 = "parent-depth-0";
                    $html .= "<li class= '$parentDepth0 " . 'parent-' . 0 ."'><a href='products/productlistbycategory.php?category_id=" . $categoryid . "' class='dropdown-toggle' data-toggle='dropdown'>" . 
                    $result['category_name'] . " <b class='caret caret-right'></b></a>";
                    $html .= showSubCategoryTest($pdo, $categoryid);
                    $html .= "</li>";

                }

                $html .= "</ul>";
                return $html;

            }

            if (isset($_SESSION['user_type']) && isset($_SESSION['user_id']) && ($_SESSION['user_type'] == "customer") && isset($_SESSION['user_cart'])) {

                echo '<a href="cart/mycartdetails.php">
                        <button>My Carts</button>
                    </a>
                    </br></br>';

            }
        
            if (isset($_SESSION['user_type']) && isset($_SESSION['user_id']) && $_SESSION['user_type'] == "vendor") {

               echo '
                
                    <a href="vendor/vendorhomepage.php">
                        <button>Vendor Home Page</button>
                    </a>    
                    </br>
                    </br>';
                

            }

            if (isset($_SESSION['user_type']) && isset($_SESSION['user_id']) && $_SESSION['user_type'] == "customer") {

                echo '
                 
                     <a href="customer/customerhomepage.php">
                         <button>Customer Home Page</button>
                     </a>    
                     </br>
                     </br>';
                 
             }

            else {

                echo '
                    <h2>Login: </h2>
                    <a href="login/login.php">
                        <button>Log in / Sign Up</button>
                    </a>    
                    </br>
                    </br>';

            }
        ?>
        <div class="container">
            <nav class="navbar navbar-default">
                <!-- <div class="navbar-header">
                    <a href="" class="navbar-brand">Code with sk</a>
                </div> -->
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li>
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">Product Category<b class="caret"></b></a>
                        <?php

                            echo showCategoryTest($pdo);
                        
                        ?>
                        </li>
                    </ul>
                </div>
            </nav>
            <?php

                $products = getAllProducts($pdo);

                if ($products) {

                    if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "customer") && isset($_SESSION['user_district_id'])) {

                        showAllProducts($products);
                        echo "<h2>Top Reviewed</h2></br></br>";
                        $productssortbyreview = getProductsSortByReview($pdo);
                        showAllProducts($productssortbyreview);
                        echo "<h2>Rcently Added</h2></br></br>";
                        $recentproducts = getRecentProducts($pdo);
                        showAllProducts($recentproducts);

                    }
                    
                    else if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "admin" || $_SESSION['user_type'] == "vendor")) {

                        showAllProducts($products);
                        echo "<h2>Top Reviewed</h2></br></br>";
                        $productssortbyreview = getProductsSortByReview($pdo);
                        showAllProducts($productssortbyreview);
                        echo "<h2>Rcently Added</h2></br></br>";
                        $recentproducts = getRecentProducts($pdo);
                        showAllProducts($recentproducts);

                    }

                    else if ((isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "customer") && !isset($_SESSION['user_district_id']))) {

                        echo "<h2>Customer, Please Enter Your Location</h2>";

                    }

                    else {

                        showAllProducts($products);
                        echo "<h2>Top Reviewed</h2></br></br>";
                        $productssortbyreview = getProductsSortByReview($pdo);
                        showAllProducts($productssortbyreview);
                        echo "<h2>Rcently Added</h2></br></br>";
                        $recentproducts = getRecentProducts($pdo);
                        showAllProducts($recentproducts);

                    }
                    
                }

                else {

                    echo "<h2>No Product Found</h2>";

                }

            ?>      
        </div>

    </body>
</html>