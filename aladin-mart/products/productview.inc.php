<?php

    declare(strict_types=1);

    function productAddedCheck() {

        if (isset($_SESSION['product_adding_errors'])) {

            $errors = $_SESSION["product_adding_errors"];
            echo "<h3> Error: </h3>";

            foreach ($errors as $key => $value) {

                $errorkey = ucwords(str_replace("_", " ", $key));
                $errorname = ucwords(str_replace("_", " ", $errors[$key]));
                echo '<p class="form-error">Error: ' . htmlspecialchars($errorkey) . ' Solve: ' . htmlspecialchars($errorname) . '</br></p>';

            }

            unset($_SESSION['product_adding_errors']);
        }
        
        else if (isset($_GET['product_add']) && $_GET['product_add'] == "successful") {

            echo '<p class="form-success">Successfully New Product Added</br></p>';
        
        }

    }

    function showProductsForAVendor(array | bool $products, int $vendorid) {

        

        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "vendor") {

            echo'</br>
                <a href="../vendor/vendorhomepage.php?loggedin=successful">
                    <button>Back To Vendor Homepage</button>
                </a>    
            </br></br>';

        }

        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "admin") {

            echo'</br>
                <a href="../admin/vendorlist.php">
                    <button>Back To Admin\'s Vendor List</button>
                </a>    
            </br></br>';

        }

        echo '<table align = "left" border = "1">';
        echo '<tr>
                <th>Product Image</th>
                <th>Product ID</th>
                <th>Product Title</th>
                <th>Category Name</th>
                <th>Sub Category Name</th>
                <th>Product Wholesale Price</th>
                <th>Product Retail Price</th>
                <th>Product Quantity</th>
                <th>Sold Amount</th>
                <th>Product Created</th>
                <th>Detail</th>
                <th>Edit</th>
              </tr>';

        foreach ($products as $key => $product) {

            $productid = (String) $product['id'];
            $producttitle = ucwords(str_replace("_", " ", $product['product_title']));
            $categoryname = ucwords(str_replace("_", " ", $product['category_name']));
            $subcategoryname = ucwords(str_replace("_", " ", $product['sub_category_name']));
            $productwholesaleprice = (String) $product['product_wholesale_price'];
            $productretailprice = (String) $product['product_retail_price'];
            $productquantity = (String) $product['product_quantity'];
            $productsold = (String) $product['product_sold'];
            $productimagelocationname = $product['product_image_location'];
            $productcreated = $product['product_created'];

            echo '<tr>
                        <td><img src=' . $productimagelocationname .' alt="HTML5 Icon" width="55" height="50"></td>
                        <td>' . htmlspecialchars($productid) . '</td>
                        <td>' . htmlspecialchars($producttitle) . '</td>
                        <td>' . htmlspecialchars($categoryname) . '</td>
                        <td>' . htmlspecialchars($subcategoryname) . '</td>
                        <td>' . htmlspecialchars($productwholesaleprice) . ' TK </td>
                        <td>' . htmlspecialchars($productretailprice) . ' TK </td>
                        <td>' . htmlspecialchars($productquantity) . ' </td>
                        <td>' . htmlspecialchars($productsold) . ' </td>
                        <td>' . htmlspecialchars($productcreated) . '</td>
                        <td>
                            <a href="productdetail.php?product_id=' . $productid . '&vendor_id=' . $vendorid . '">
                                <button>Details</button>
                            </a>
                        </td>
                        <td>';

                        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "vendor") {

                            echo '<a href="productedit.php?product_id=' . $productid . '&vendor_id=' . $vendorid . '">
                                    <button>Edit</button>
                                </a>';

                        }

                        else {

                            echo '<p><b>Admin Can Not Edit</b></p>';

                        }
                        
                    '</td>
                    </tr>';

        }

    }

    function showAProductDetails(array | bool $product, String | int | null $productreview, array | null $productdeliverydistricts) {

        $productid = $product['id'];
        $vendorid = $product['vendor_id'];
        $producttitle = ucwords(str_replace("_", " ", $product['product_title']));
        $vendorname = ucwords(str_replace("_", " ", $product['user_first_name'])) . ' ' . ucwords(str_replace("_", " ", $product['user_last_name']));
        $vendoremail = $product['user_email'];
        $vendornumber = $product['user_number'];
        $vendorshopname = ucwords(str_replace("_", " ", $product['user_shop_name']));
        $categoryname = ucwords(str_replace("_", " ", $product['category_name']));
        $subcategoryname = ucwords(str_replace("_", " ", $product['sub_category_name']));
        $productretailprice = (String) $product['product_retail_price'];
        $productbrandname = ($product['product_brandname']) ? ucwords(str_replace("_", " ", $product['product_brandname'])) : "No Brand Name";
        $productsku = $product['product_sku'];
        $productquantity = (String) $product['product_quantity'];
        $productwarranty = (String) $product['product_warranty'];
        $productimagelocationname = $product['product_image_location'];
        $productdescription = $product['product_description'];
        $productspecification = $product['product_specification'];
        $productcreated = (String) $product['product_created'];
        $productreview = (String) $productreview;

        if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "admin")) {

            echo'
                </br>
                    <a href="../admin/vendorlist.php">
                        <button>Back To Vendor List</button>
                    </a>    
                </br>';

        }


        if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "vendor")) {

            echo'
                </br>
                    <a href="../products/productslist.php?vendor_id=' . $vendorid .'">
                        <button>Back To Product List</button>
                    </a>    
                </br>';

        }
        
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "customer") {

            echo'
                </br>
                    <a href="../index.php">
                        <button>Back To Home Page</button>
                    </a>    
                </br>';

        }

        else {

            echo'
                </br>
                    <a href="../index.php">
                        <button>Back To Home Page</button>
                    </a>    
                </br>';
            
        }
       

        echo '<main>
                <div class="productContainer">
                    <div class="imgContainer">
                        <img src=' . $productimagelocationname . ' alt="#" />
                        </div>
                        <div class="">
                        <h2>' . htmlspecialchars($producttitle) . '</h2>
                        <h3>' . htmlspecialchars($productbrandname) . '</h3>
                        <p>' . htmlspecialchars($categoryname) . '</p>
                        <p>' . htmlspecialchars($subcategoryname) . '</p>
                        <p>Retail Price: ' . htmlspecialchars($productretailprice) . '</p>
                        <p>On Stock: ' . htmlspecialchars($productquantity) . '</p>
                        <p>Product Added Date: ' . htmlspecialchars($productcreated) . '</p>
                        <p>Product SKU: ' . htmlspecialchars($productsku) . '</p>
                        <p>Product Warranty: ' . htmlspecialchars($productwarranty) . ' Year</p>
                        <p><b>Review: ' . htmlspecialchars($productreview) . ' </b></p>
                        <p><h3>Product Delivery Locations:</h3></p>';
                
                        if ($productdeliverydistricts) {

                            foreach ($productdeliverydistricts as $key => $value) {

                                $district = ucwords(str_replace("_", " ", $value['district_name']));
                                echo '<p>' . htmlspecialchars($district) . '</p>';

                            }

                            echo "</br>";

                        }

                        else {

                            echo "<p>No Location Has Been Given</br></p>";

                        }

                        if (isset($_SESSION['user_type']) && isset($_SESSION['user_id']) && $_SESSION['user_type'] == "customer" && isset($_SESSION['user_district_id'])) {

                            $customerid = (int) $_SESSION['user_id'];
                            echo '<form action="../cart/addtocartoperations.inc.php" method="post">
                                    <input type="hidden" name="product_id" value="' . $productid . '">
                                    <input type="hidden" name="customer_id" value="' . $customerid . '">
                                    <input type="hidden" name="vendor_id" value="' . $vendorid . '">
                                    <input type="hidden" name="product_quantity" value="' . $productquantity . '">
                                    <label for="purchasequantity">Quantity:  </label>
                                    <input required id="purchasequantity" type="number" name="purchasequantity" placeholder="Enter Quantity">
                                    <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                                </form>';

                        }

                        else if (isset($_SESSION['user_type']) && isset($_SESSION['user_id']) && ($_SESSION['user_type'] == "vendor" || $_SESSION['user_type'] == "admin")) {

                            echo "";

                        }

                        else {

                            echo "<b>Please Login For Purchase Or Set Location</b></br>";

                        }

                    echo '</div>
                        </div>
                        <div class="descriptionContainer">
                            <div>
                            <h2><b>Description</b></h2>
                            ' . $productdescription . '
                            </div>
                            <div>
                            <h2><b>Specification</b></h2>
                            ' . $productspecification . '
                            </div>
                            <div>
                            <h2>Vendor Info</h2>
                                Name: ' . htmlspecialchars($vendorname) . '</br>
                                Shop Name: ' . htmlspecialchars($vendorshopname) . '</br> 
                                Email: ' . htmlspecialchars($vendoremail) . '</br>
                                Phone: ' . htmlspecialchars($vendornumber) .'</br> 
                            </div>
                        </div>
                    </main>';

    }

    function showAProductDetailsForEdit(array | bool $product, array | bool $productdeliverydistricts) {
        
        $vendorid = $product['vendor_id'];
        $producttitle = ucwords(str_replace("_", " ", $product['product_title']));
        $subcategoryname = ucwords(str_replace("_", " ", $product['sub_category_name']));
        $productwholesaleprice = (String) $product['product_wholesale_price'];
        $productretailprice = (String) $product['product_retail_price'];
        $productbrandname = $product['product_brandname'];
        $productsku = $product['product_sku'];
        $productquantity = (String) $product['product_quantity'];
        $productwarranty = (String) $product['product_warranty'];
        $productsold = (String) $product['product_sold'];
        $productdescription = $product['product_description'];
        $productspecification = $product['product_specification'];
        $productimagelocationname = $product['product_image_location'];

        echo'
            </br>
                <a href="../products/productslist.php?vendor_id=' . $vendorid .'">
                    <button>Back To Product List</button>
                </a>    
            </br>';

        echo '<main>
            <div class="productContainer">
                <div class="imgContainer">
                    <img src=' . $productimagelocationname . ' alt="#" />
                    </div>
                    <div class="">
                    <h2>' . htmlspecialchars($producttitle) . '</h2>
                    <h3>' . htmlspecialchars($productbrandname) . '</h3>
                    <p>' . htmlspecialchars($subcategoryname) . '</p>
                    <p>Wholesale Price:' . htmlspecialchars($productwholesaleprice) . '</p>
                    <p>Retail Price: ' . htmlspecialchars($productretailprice) . '</p>
                    <p>On Stock: ' . htmlspecialchars($productquantity) . '</p>
                    <p>Total Sold: ' . htmlspecialchars($productsold) . '</p>
                    <p>Product SKU: ' . htmlspecialchars($productsku) . '</p>
                    <p>Product Warranty: ' . htmlspecialchars($productwarranty) . ' Year</p>
                </div>
            </div>
            <div class="descriptionContainer">
                <div>
                <h2><b>Description</b></h2>
                ' . $productdescription . '
                </div>
                <div>
                <h2><b>Specification</b></h2>
                ' . $productspecification . '
                </div>
                <div>
            </div>
        </main>';

        echo '<h2>Product Delivery Locations:</h2></br>';
        if ($productdeliverydistricts) {

            foreach ($productdeliverydistricts as $key => $value) {

                $district = ucwords(str_replace("_", " ", $value['district_name']));
                echo '<p>' . htmlspecialchars($district) . '</p>';

            }

            echo "</br>";

        }

        else {

            echo "<p>No Location Has Been Given</br></p>";

        }
        
    }

    function productEditCheck() {

        if (isset($_SESSION['product_edit_error'])) {

            $errors = $_SESSION["product_edit_error"];
            echo "<h3> Error: </h3>";

            foreach ($errors as $key => $value) {

                $errorkey = ucwords(str_replace("_", " ", $key));
                $errorname = ucwords(str_replace("_", " ", $errors[$key]));
                echo '<p class="form-error">Error: ' . htmlspecialchars($errorkey) . ' Solve: ' . htmlspecialchars($errorname) . '</br></p>';

            }

            unset($_SESSION['product_edit_error']);
            
        }
        
        else if (isset($_GET['status'])) {

            echo '<p class="form-success">' . htmlspecialchars($_GET['status']) . '</br></p>';
            unset($_GET['status']);
        
        }

    }

    function showAllProducts(array | bool $products) {

        echo '<div class="productsContainer">';

        foreach ($products as $key => $product) {

            $productid = $product['id'];
            $vendorid = $product['vendor_id'];
            $productimagelocationtemp = $product['product_image_location'];
            $productimagelocation = 'products/' . $productimagelocationtemp;
            $producttitle = ucwords(str_replace("_", " ", $product['product_title']));
            $productsretailprice = (String) $product['product_retail_price'];
            $productreview = (String) $product['product_review'];

            echo '     
    
                <div class="singleProdCard">
                    <div class="imgContainer">
                        <a href="products/productdetail.php?product_id=' . $productid . '&vendor_id=' . $vendorid . '"> 
                            <img src="' . $productimagelocation . '" alt="#" />
                        </a>
                    </div>
                    <div class="cardContent">
                        <h3>Product Name: ' . htmlspecialchars($producttitle) . ' </h3>
                        <p>Price: ' . htmlspecialchars($productsretailprice) . ' TK</p>
                        <p>Reviews: ' . htmlspecialchars($productreview) . '</p>
                    </div>
                </div>';

        }

        echo '</div>';

    }

    function showAllProductsByCategory(array $products, String $categoryname) {

        echo '<h2>Category: ' . htmlspecialchars($categoryname) .'</br></h2>';
        echo '<div class="productsContainer">';

        foreach ($products as $key => $product) {

            $productid = $product['id'];
            $vendorid = $product['vendor_id'];
            $productimagelocationtemp = $product['product_image_location'];
            $productimagelocation = 'products/' . $productimagelocationtemp;
            $producttitle = ucwords(str_replace("_", " ", $product['product_title']));
            $productsretailprice = (String) $product['product_retail_price'];
            $productreview = (String) $product['product_review'];

            echo '     
    
                <div class="singleProdCard">
                    <div class="imgContainer">
                        <a href="productdetail.php?product_id=' . $productid . '&vendor_id=' . $vendorid . '"> 
                            <img src="../' . $productimagelocation . '" alt="#" />
                        </a>
                    </div>
                    <div class="cardContent">
                        <h3>Product Name: ' . htmlspecialchars($producttitle) . ' </h3>
                        <p>Price: ' . htmlspecialchars($productsretailprice) . ' TK</p>
                        <p>Reviews: ' . htmlspecialchars($productreview) . '</p>
                    </div>
                </div>';

        }

        echo '</div>';

    }

    function showAllProductsBySubcategory(array $products, String $subcategoryname) {

        echo '<h2>Subcategory: ' . htmlspecialchars($subcategoryname) .'</br></h2>';
        echo '<div class="productsContainer">';

        foreach ($products as $key => $product) {

            $productid = $product['id'];
            $vendorid = $product['vendor_id'];
            $productimagelocationtemp = $product['product_image_location'];
            $productimagelocation = 'products/' . $productimagelocationtemp;
            $producttitle = ucwords(str_replace("_", " ", $product['product_title']));
            $productsretailprice = (String) $product['product_retail_price'];
            $productreview = (String) $product['product_review'];

            echo '     
    
                <div class="singleProdCard">
                    <div class="imgContainer">
                        <a href="productdetail.php?product_id=' . $productid . '&vendor_id=' . $vendorid . '"> 
                            <img src="../' . $productimagelocation . '" alt="#" />
                        </a>
                    </div>
                    <div class="cardContent">
                        <h3>Product Name: ' . htmlspecialchars($producttitle) . ' </h3>
                        <p>Price: ' . htmlspecialchars($productsretailprice) . ' TK</p>
                        <p>Reviews: ' . htmlspecialchars($productreview) . '</p>
                    </div>
                </div>';

        }

        echo '</div>';

    }

?>