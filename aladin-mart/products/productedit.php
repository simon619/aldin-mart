<?php
    declare(strict_types=1);

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';
    require_once 'productview.inc.php';
    require_once '../admin/categorycontroller.inc.php';
    require_once '../admin/categorymodel.inc.php';

    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "vendor") {

        header('Location: ../index.php');

    }

    $vendorname = (String) $_SESSION['user_name'];
    $vendorid = (int) $_SESSION['user_id'];
    echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $vendorname))) . '</br>';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    </head>
    <body>

        <style>

            .productContainer {
                width: 100%;
                display: flex;
                align-items: center;
                background-color: #fff;
                gap: 50px;
            }
            .imgContainer {
                width: 100px;
                height: 100px;
            }
            .imgContainer img {
                width: 100%;
                height: 100%;
            }
            .descriptionContainer {
                display: flex;
                flex-direction: column;
                gap: 30px;
                margin-top: 30px;
            }
            .ed-frm{
                border: 2px solid black;
                border-radius: 10px;
                width: 50%;
                padding: 5px;
            }
            /* form{
                border: 2px solid black;
                border-radius: 10px;
                padding: 5px;
            } */
            .box
            {
            max-width:500px;
            width:50%;
            background-color:#f9f9f9;
            border:1px solid #ccc;
            border-radius:5px;
            padding:16px;
            margin:0 auto;
            }
            .ck-editor__editable[role="textbox"] {
                            /* editing area */
                            min-height: 300px;
                        }
            .error
            {
            color:  red;
            }
            .submitBtn{
                padding: 5px 10px;
                background-color: red;
                color: white;
                border: none;
                border-radius: 5px;
                margin-top: 10px;
            }
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }

        </style>

        <?php

            if (isset($_GET['vendor_id']) && isset($_GET['product_id']) && ((int) $_GET['vendor_id'] == $vendorid)) {
                   
                $productid = (int) $_GET['product_id'];
                $product = getAProductDetailsForEdit($pdo, $vendorid, $productid);
                $productdeliverydistricts = getProductDeliveryLocations($pdo, $productid);
                showAProductDetailsForEdit($product, $productdeliverydistricts);

            }

            else {

                header('Location: ../index.php');

            }

            $productchangeserrors = array(); 
        
        ?>

        <h2>Product Information Edit</h2>

        <?php
        
            productEditCheck();
            echo '</br>';
        
        ?>
         
            
        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproducttitle">
            <label for="producttitle">Change Product Name: </label>
            <input required id="producttitle" type="text" name="producttitle" placeholder="Enter New Product Title">
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>
        
        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductsubcategory">
            <label for="subcategoryid">Change Product Subcategory: </label>
            <select id="subcategoryid" name="subcategoryid">
                
                <?php

                    $subcategorynames = getSubcategoryName($pdo);

                    foreach ($subcategorynames as $keys => $values) {

                        echo "<option value=" . $values['id'] . ">" . htmlspecialchars(ucwords(str_replace("_", " ", $values['sub_category_name']))) . "</option>";

                    }
                    
                ?>

            </select>
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>

        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductwholesaleprice">
            <label for="productwholesaleprice">Change Product Wholesale Price: </label>
            <input required id="productwholesaleprice" type="number" name="productwholesaleprice" placeholder="Enter New Product Wholesale Price">
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>

        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductretailprice">
            <label for="productretailprice">Change Product Retail Price:  </label>
            <input required id="productretailprice" type="number" name="productretailprice" placeholder="Enter New Product Retail Price">
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>

        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductbrandname">
            <label for="productbrandname">Change Product Brand Name:  </label>
            <input required id="productbrandname" type="text" name="productbrandname" placeholder="Enter New Product Brand Name">
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>

        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductsku">
            <label for="productsku">Change Product SKU:  </label>
            <input required id="productsku" type="text" name="productsku" placeholder="Enter New Product Retail Price">
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>

        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductquantity">
            <label for="productquantity">Change Product Quantity:  </label>
            <input required id="productquantity" type="number" name="productquantity" placeholder="Enter New Product Retail Price">
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>

        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductwarranty">
            <label for="productwarranty">Change Product Warranty:  </label>
            <input required id="productwarranty" type="number" name="productwarranty" placeholder="Enter New Product Warranty">
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>

        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductsold">
            <label for="productsold">Change Product Sold Amount:  </label>
            <input required id="productsold" type="number" name="productsold" placeholder="Enter New Product Sold Amount">
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>

        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductdescription">
            <div class="ed-frm">
                <label class="xyz" for="productdescription">Change Product Description:</label>
                <textarea name="productdescription" id="productdescription" rows="10" cols="80">
                    This is my textarea to be replaced with HTML editor.
                </textarea>
                </br>
                <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
            </div>
        </form>

        <script>

            ClassicEditor
                .create( document.querySelector( '#productdescription' ))
                .catch( (error) => {
                    console.error( error );
                });

        </script>

        </br>

        <form action="producteditoperations.inc.php" method="post">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductspecification">
            <div class="ed-frm">
                <label class="xyz" for="productspecification">Enter Product Specification:</label>
                <textarea name="productspecification" id="productspecification" rows="10" cols="80">
                    This is my textarea to be replaced with HTML editor.
                </textarea>
                </br>
                <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
            </div>
        </form>

        <script>

            ClassicEditor
                .create( document.querySelector( '#productspecification' ))
                .catch( (error) => {
                    console.error( error );
                });

        </script>

        </br>

        <form action="producteditoperations.inc.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorid ?>">
            <input type="hidden" name="product_id" value="<?php echo $productid ?>">
            <input type="hidden" name="edit_type" value="nproductdeliverylocation">
            <p><b>Change Delivered Location:</b></p>
            <select name='newdistricts[]' multiple="multiple">  
                <option selected value = '1'>All</option>
                <option value = '2'>Dhaka</option>
                <option value = '3'>Faridpur</option>
                <option value = '4'>Gazipur</option>
                <option value = '5'>Gopalganj</option>
                <option value = '6'>Jamalpur</option>
                <option value = '7'>Kishoreganj</option>
                <option value = '8'>Madaripur</option>
                <option value = '9'>Manikganj</option>
                <option value = '10'>Munshiganj</option>
                <option value = '11'>Mymensingh</option>
                <option value = '12'>Narayanganj</option>
                <option value = '13'>Narsingdi</option>
                <option value = '14'>Netrokona</option>
                <option value = '15'>Rajbari</option>
                <option value = '16'>Shariatpur</option>
                <option value = '17'>Sherpur</option>
                <option value = '18'>Tangail</option>
                <option value = '19'>Bogra</option>
                <option value = '20'>Joypurhat</option>
                <option value = '21'>Naogaon</option>
                <option value = '22'>Natore</option>
                <option value = '23'>Nawabganj</option>
                <option value = '24'>Pabna</option>
                <option value = '25'>Rajshahi</option>
                <option value = '26'>Sirajgonj</option>
                <option value = '27'>Dinajpur</option>
                <option value = '28'>Gaibandha</option>
                <option value = '29'>Kurigram</option>
                <option value = '30'>Lalmonirhat</option>
                <option value = '31'>Nilphamari</option>
                <option value = '32'>Panchagarh</option>
                <option value = '33'>Rangpur</option>
                <option value = '34'>Thakurgaon</option>
                <option value = '35'>Barguna</option>
                <option value = '36'>Barisal</option>
                <option value = '37'>Bhola</option>
                <option value = '38'>Jhalokati</option>
                <option value = '39'>Patuakhali</option>
                <option value = '40'>Pirojpur</option>
                <option value = '41'>Bandarban</option>
                <option value = '42'>Brahmanbaria</option>
                <option value = '43'>Chandpur</option>
                <option value = '44'>Chittagong</option>
                <option value = '45'>Comilla</option>
                <option value = '46'>Cox's Bazar</option>
                <option value = '47'>Feni</option>
                <option value = '48'>Khagrachari</option>
                <option value = '49'>Lakshmipur</option>
                <option value = '50'>Noakhali</option>
                <option value = '51'>Rangamati</option>
                <option value = '52'>Habiganj</option>
                <option value = '53'>Maulvibazar</option>
                <option value = '54'>Sunamganj</option>
                <option value = '55'>Sylhet</option>
                <option value = '56'>Bagerhat</option>
                <option value = '57'>Chuadanga</option>
                <option value = '58'>Jessore</option>
                <option value = '59'>Jhenaidah</option>
                <option value = '60'>Khulna</option>
                <option value = '61'>Kushtia</option>
                <option value = '62'>Magura</option>
                <option value = '63'>Meherpur</option>
                <option value = '64'>Narail</option>
                <option value = '65'>Satkhira</option>
            </select>
            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
        </form>

        </br>


    </body>
</head>


