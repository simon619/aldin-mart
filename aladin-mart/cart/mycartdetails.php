<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../products/productmodel.inc.php';
    require_once '../products/productcontroller.inc.php';
    require_once 'addtocartcontroller.inc.php';
    require_once 'addtocartmodel.inc.php';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script> -->
    </head>
    <body>

        </br>
            <a href="../index.php">
                <button>Back To Homepage</button>
            </a>    
        </br>

        <?php

            if (isset($_SESSION['increasing_error'])) {

                echo '<p class="form-error">' . htmlspecialchars($_SESSION['increasing_error']) . '</br></p>';
                unset($_SESSION['increasing_error']);

            }

            if (isset($_SESSION['confirmation_error'])) {

                echo '<p class="form-error">' . htmlspecialchars($_SESSION['confirmation_error']) . '</br></p>';
                unset($_SESSION['confirmation_error']);

            }
        
            echo '<h1>Your Cart</h1></br>';
            if (isset($_SESSION['user_cart'])) {
               
                echo '<table align = "left" border = "1" cellpadding = "3" cellspacing = "0">';
                echo '<tr>
                        <th>Product Image</th>
                        <th>Product Titile</th>
                        <th>Product Category</th>
                        <th>Shop Name</th>
                        <th>Vendor Phone Number</th>
                        <th>Vendor Email</th>
                        <th>Product Price</th>
                        <th>Purchased Quantity</th>
                        <th>Total Price</th>
                        <th>District Location</th>
                        <th>Increase</th>
                        <th>Decrease</th>
                    </tr>';

                    $mycarts = $_SESSION['user_cart'];
                    foreach($mycarts as $key => $value) {

                        $productid = (int) $key;
                        $data = getProductInformationForCart($pdo, $productid);
                        $producttitle = ucwords(str_replace("_", " ", $data['product_title']));
                        $productimagelocationname = '../products/' . $data['product_image_location'];
                        $productsubcategory = ucwords(str_replace("_", " ", $data['sub_category_name']));
                        $productretailprice = (float) $data['product_retail_price'];
                        $productshopname = ucwords(str_replace("_", " ", $data['user_shop_name']));
                        $vendornumber = $data['user_number'];
                        $vendoremail = $data['user_email'];
                        $purchasequantity =  (String) $mycarts[$key];
                        $totalprice = $productretailprice * $mycarts[$key];
                        $totalprice = (String) $totalprice;
                        $productretailprice = (String) $productretailprice;
                        $districtid = (int) $_SESSION['user_district_id'];
                        $districtname = ucwords(str_replace("_", " ", getDistrictName($pdo, $districtid)));

                        echo '<tr>
                            <td><img src=' . $productimagelocationname .' alt="HTML5 Icon" width="55" height="50"></td>
                            <td>' . htmlspecialchars($producttitle) . '</td>
                            <td>' . htmlspecialchars($productsubcategory) . '</td>
                            <td>' . htmlspecialchars($productshopname) . '</td>
                            <td>' . htmlspecialchars($vendornumber) . '</td>
                            <td>' . htmlspecialchars($vendoremail) . '</td>
                            <td>' . htmlspecialchars($productretailprice) . ' Tk</td>
                            <td>' . htmlspecialchars($purchasequantity) . '</td>
                            <td>' . htmlspecialchars($totalprice) . ' Tk</td>
                            <td>' . htmlspecialchars($districtname) . '</td>
                            <td>
                                <a href="productincrease.inc.php?product_id=' . $productid . '">
                                    <button>Increase</button>
                                </a>
                            </td>
                            <td>
                                <a href="productdecrease.inc.php?product_id=' . $productid . '">
                                    <button>Decrease</button>
                                </a>
                            </td>  
                        </tr>';

                    }

                    echo '</br>';                   

            }

            else if (isset($_SESSION['user_cart']) && count($_SESSION['user_cart']) == 0) {

                echo '<h3>No Product in Your Cart</h3>';

            }
            
            else {

                echo '<h3>No Product in Your Cart</h3>';

            }

        ?>

        <?php
        
        echo '<form action="cartconfirmationoperations.inc.php" method="post">
                <label for="customerphonenumber">Enter Your Mobile Number: </label></br>
                <input id="customerphonenumber" type="tel" name="customerphonenumber" placeholder="Enter Your Phone Number" pattern="+8801-[0-9]{9}"></br>
                <label for="productdeliveryaddress">Enter Your Delivery Address: </label></br>
                <textarea id="productdeliveryaddress" name="productdeliveryaddress" rows="4" cols="50"></textarea></br>
                <input type="submit" name="submit" class="submitBtn" value="CONFIRM">
            </form></br></br>'; 
        
        ?>

    </body>
</html>