<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../admin/categorycontroller.inc.php';
    require_once '../admin/categorymodel.inc.php';
    require_once 'productview.inc.php';

    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "vendor") {

        header('Location: ../index.php');

    }

    $username = (String) $_SESSION['user_name'];
    $username = str_replace("_", " ", $username);
    $vendorid = $_SESSION['user_id'];
    echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $username))) . '</br>';


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
            .ed-frm{
                width: 50%;
            }
            form{
                border: 2px solid black;
                border-radius: 10px;
                padding: 5px;
            }
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

        </br>
        <a href="../logout/logout.inc.php">
            <button>Log Out</button>
        </a>    
        </br>
        
        </br>
        <a href="../vendor/vendorhomepage.php">
            <button>Back To Vendor HomePage</button>
        </a>    
        </br>
            
        <h2>Add New Product</h2>
        <form action="addproductoperations.inc.php" method="post"  enctype="multipart/form-data">
            <label for="producttitle">Enter Product Name: </label>
            <input required id="producttitle" type="text" name="producttitle" placeholder="Enter Product Title">
            </br>
            <label for="subcategoryid">Enter Sub Category Name: </label>
            <select id="subcategoryid" name="subcategoryid">
                
                <?php

                    $subcategorynames = getSubcategoryName($pdo);

                    foreach ($subcategorynames as $keys => $values) {

                        echo "<option value=" . $values['id'] . ">" . htmlspecialchars(ucwords(str_replace("_", " ", $values['sub_category_name']))) . "</option>";

                    }
                    
                ?>

            </select>
            </br>
            <label for="productwholesaleprice">Enter Product Wholesale Price: </label>
            <input required id="productwholesaleprice" type="number" name="productwholesaleprice" placeholder="Enter Product Wholesale Title">
            </br>
            <label for="productretailprice">Enter Product Retail Price: </label>
            <input required id="productretailprice" type="number" name="productretailprice" placeholder="Enter Product Retail Title">
            </br>
            <label for="productbrandname">Enter Product Brand Name: </label>
            <input id="productbrandname" type="text" name="productbrandname" placeholder="Enter Product Brand Name">
            </br>
            <label for="productsku">Enter Product SKU: </label>
            <input required id="productsku" type="text" name="productsku" placeholder="Enter Product SKU">
            </br>
            <label for="productquantity">Enter Product Quantity: </label>
            <input required id="productquantity" type="number" name="productquantity" placeholder="Enter Product Quantity">
            </br>
            <label for="productwarranty">Enter Product warranty Year:</label>
            <input type="number" id="productwarranty" name="productwarranty">
            </br>
            <div class="ed-frm">
                <label class="xyz" for="productdescription">Enter Product Description:</label>
                <textarea name="productdescription" id="productdescription" rows="10" cols="80">
                    This is my textarea to be replaced with HTML editor.
                </textarea>
                </br>
                <label class="xyz" for="productspecification">Enter Product Specification:</label>
                <textarea name="productspecification" id="productspecification" rows="10" cols="80">
                    This is my textarea to be replaced with HTML editor.
                </textarea>
                </br>
            </div>
            <p><b>Enter Product Image Location:</b></p>
            <input type="file" name="productimagelocation" id="productimagelocation">
            </br>
            <p><b>Enter Product Delivery Location:</b></p>
            <select name='districts[]' multiple="multiple">  
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

        <script>
            ClassicEditor
                .create( document.querySelector( '#productspecification' ))
                .catch( (error) => {
                    console.error( error );
                });

            ClassicEditor
                .create( document.querySelector( '#productdescription' ))
                .catch( (error) => {
                    console.error( error );
                });
        </script>

        <?php
       
            productAddedCheck();
        
        ?>
         
    </body>
</html>