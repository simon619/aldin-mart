<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'productmodel.inc.php';
    require_once 'productcontroller.inc.php';
    require_once 'productview.inc.php';

    // if (!isset($_SESSION['user_type'])) {

    //     header('Location: ../index.php');

    // }

    if (isset($_SESSION['user_type'])) {

        $username = (String) $_SESSION['user_name'];
        $userid = (int) $_SESSION['user_id'];
        echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $username))) . '</br>';

        if (isset($_SESSION['user_district_id'])) {

            $districtid = (int) $_SESSION['user_district_id'];
            $districtname = (String) getDistrictName($pdo, $districtid);
            echo '<p>You District Name: <b>' . $districtname .'</b></p></br>';

        }

    }
    
?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
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
            .reviewContainer {
                width: 200px;
                display: flex;
                flex-direction: column;
                row-gap: 20px;
            }

            .customerReview {
                width: 100%;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .customerReview select {
                padding: 1px 10px;
            }

            .reviewContainer textarea {
                width: 100%;
                height: 100px;
                border-radius: 5px;
                padding: 10px;
            }

            p,
            h3 {
                margin: 0;
            }
            .reviewShowContainer {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

        </style>

        <?php
        

            if (isset($_SESSION['cart_success'])) {

                echo '<p class="form-success">' . htmlspecialchars($_SESSION['cart_success']) . '</br></p>';
                unset($_SESSION['cart_success']);        

            }

            if (isset($_SESSION['cart_error'])) {

                $errors = $_SESSION["cart_error"];
                echo "<h3>Cart Adding Error: </h3>";
    
                foreach ($errors as $key => $value) {
    
                    $errorkey = ucwords(str_replace("_", " ", $key));
                    $errorname = ucwords(str_replace("_", " ", $errors[$key]));
                    echo '<p class="form-error">Error: ' . htmlspecialchars($errorkey) . ' Solve: ' . htmlspecialchars($errorname) . '</br></p>';
    
                }
    
                unset($_SESSION['cart_error']);

            }


            if (isset($_GET['vendor_id']) && isset($_GET['product_id'])) {
                   
                $productid = (int) $_GET['product_id'];
                $vendorid = (int) $_GET['vendor_id'];
                $product = getAProductDetails($pdo, $vendorid, $productid);
                $productreview = getProductReview($pdo, $productid);
                $productdeliverydistricts = getProductDeliveryLocations($pdo, $productid);
                showAProductDetails($product, $productreview, $productdeliverydistricts);
                echo '</br>';

                if (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "customer") {

                    echo '<form action="reviewoperation.inc.php" method="post">                     
                            <div class="reviewContainer">
                                <div class="customerReview">
                                    <label for="review">Review</label>
                                    <select name="review" id="review">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                    
                                <textarea name="reviewmessage" id=""></textarea>
                                <input type="hidden" name="product_id" value="' . $productid . '">
                                <input type="hidden" name="customer_id" value="' . $userid . '"?>
                                <input type="hidden" name="vendor_id" value="' . $vendorid . '">
                            </div>
                            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                        </form>';

                }
                
                $reviews = getProductReviewMessages($pdo, $productid);
                echo "<h2>Reviews</h2>";

                if ($reviews) {

                    echo '<div class="reviewShowContainer">';

                    foreach ($reviews as $key => $currentreview) {

                        $reviewid = (int) $currentreview['id'];
                        $review = (String) $currentreview['review_value'];
                        $reviewmessage = $currentreview['review_message'];
                        $reviewerid = (int) $currentreview['reviewer_id'];
                        $customername = ucwords(str_replace("_", " ", $currentreview['user_first_name'])) . ' ' . ucwords(str_replace("_", " ", $currentreview['user_last_name']));
    
                        echo '<div>
                                <p>Review: ' . htmlspecialchars($review) . '</p>
                                <h3>Name: ' . htmlspecialchars($customername) . '</h3>
                                <p>' . htmlspecialchars($reviewmessage) . '</p>
                            </div></br>';
    
                        if (isset($_SESSION['user_id']) && $userid == $reviewerid) {
    
                            echo '<a href="deletereviewoperation.inc.php?review_id=' . $reviewid . '&reviewer_id=' . $reviewerid . '&product_id=' . $productid .'&vendor_id=' . $vendorid .'">
                                    <button>Delete This Review</button>
                                </a>';
                            echo '<h2>Edit This Review</h2>';
                            echo '<form action="editreviewoperation.inc.php" method="post">
                                    <textarea name="newreviewmessage" id=""></textarea>
                                    <input type="hidden" name="review_id" value="' . $reviewid . '">
                                    <input type="hidden" name="product_id" value="' . $productid . '">
                                    <input type="hidden" name="reviewer_id" value="' . $reviewerid . '">
                                    <input type="hidden" name="vendor_id" value="' . $vendorid . '">
                                    <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                                </form>';
    
                        }
    
                    }
    
                    echo '</div>';

                }

                else {

                    echo "<h2>No Reviews And Comment</h2></br>";

                }

                echo "<h2>Question And Answer</h2>";
                if (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "customer") {

                    echo '<form action="productqaoperation.inc.php" method="post">                     
                            <div class="reviewContainer">       
                                <textarea name="question" id=""></textarea>
                                <input type="hidden" name="product_id" value="' . $productid . '">
                                <input type="hidden" name="customer_id" value="' . $userid . '">
                                <input type="hidden" name="vendor_id" value="' . $vendorid . '">
                            </div>
                            <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                        </form>';

                }

                $questionsandanswers = getQAsForCustomer($pdo, $productid);
                if ($questionsandanswers) {

                    foreach ($questionsandanswers as $key => $currentquestionsandanswers) {

                        $qaid = (int) $currentquestionsandanswers['id'];
                        $customerid = (int) $currentquestionsandanswers['customer_id'];
                        $customername = ucwords(str_replace("_", " ", $currentquestionsandanswers['user_first_name'])) . ' ' . ucwords(str_replace("_", " ", $currentquestionsandanswers['user_last_name']));
                        $question = ucwords(str_replace("_", " ", $currentquestionsandanswers['question']));
                        $answer = ucwords(str_replace("_", " ", $currentquestionsandanswers['answer']));

                        echo '<div>
                                <h3>Name: ' . htmlspecialchars($customername) . '</h3>
                                <p>Question: ' . htmlspecialchars($question) . '</p>
                                <p>Response: ' . htmlspecialchars($answer) . '</p>
                            </div></br>';

                            if (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && ($userid == $customerid) && $_SESSION['user_type'] == "customer") { 

                                echo '<a href="deletequestionoperation.inc.php?qa_id=' . $qaid . '&customer_id=' . $customerid . '&product_id=' . $productid .'&vendor_id=' . $vendorid .'">
                                    <button>Delete This Review</button>
                                </a>';
                                echo '<h2>Edit This Question</h2>';
                                echo '<form action="editquestionansweroperation.inc.php" method="post">
                                        <textarea name="newquery" id=""></textarea>
                                        <input type="hidden" name="qa_id" value="' . $qaid . '">
                                        <input type="hidden" name="product_id" value="' . $productid . '">
                                        <input type="hidden" name="customer_id" value="' . $customerid . '">
                                        <input type="hidden" name="vendor_id" value="' . $vendorid . '">
                                        <input type="hidden" name="edit_type" value="question">
                                        <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                                    </form>';

                            }

                            else if (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && ($userid == $vendorid) && $_SESSION['user_type'] == "vendor") {

                                echo '<a href="deletequestionoperation.inc.php?qa_id=' . $qaid . '&customer_id=' . $customerid . '&product_id=' . $productid .'&vendor_id=' . $vendorid .'">
                                    <button>Delete This Review</button>
                                </a>';
                                echo '<h2>Edit This Answer</h2>';
                                echo '<form action="editquestionansweroperation.inc.php" method="post">
                                        <textarea name="newquery" id=""></textarea>
                                        <input type="hidden" name="qa_id" value="' . $qaid . '">
                                        <input type="hidden" name="product_id" value="' . $productid . '">
                                        <input type="hidden" name="customer_id" value="' . $customerid . '">
                                        <input type="hidden" name="vendor_id" value="' . $vendorid . '">
                                        <input type="hidden" name="edit_type" value="answer">
                                        <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                                    </form>';

                            }

                    }

                }

                else {

                    echo "<h2>No Question And Answers</h2></br>";

                }

            }
        
        ?>

    </body>
</head>