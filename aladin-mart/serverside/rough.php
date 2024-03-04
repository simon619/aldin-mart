<?php

    require_once 'configsession.inc.php';

    // $_SESSION['cart'] = array();
    // $carts = array();
    // $carts[1] = 10;
    // $carts[2] = 15;

    // $_SESSION['cart'] = $carts;
    // $temp = $_SESSION['cart'];

    // foreach ($_SESSION['cart'] as $key => $values) {

    //     if ($key == 1) {

    //         $_SESSION['cart'][$key]++;

    //     }

    // }

    // $temp = $_SESSION['cart'];

    // foreach ($temp as $key => $values) {

    //     echo $key . ' ' . $temp[$key] . '</br>'; 

    // }

    // $_SESSION['is_me'] = array();

    // if ($_SESSION['is_me']) {

    //     echo "a";

    // }

    // else {

    //     echo "b";
    
    // }

    function printdata() {

        foreach ($_SESSION['cart'] as $key => $value) {

            echo $key . " " . $_SESSION['cart'][$key] . "</br>";
    
        }

    } 


    $_SESSION['cart'] = array();
    $_SESSION['cart'][0] = "Avi";
    $_SESSION['cart'][1] = "Akib";
    $_SESSION['cart'][2] = "Anik";
    $_SESSION['cart'][7] = "joty";

    printdata();

    unset($_SESSION['cart'][7]);

    printdata();



?>