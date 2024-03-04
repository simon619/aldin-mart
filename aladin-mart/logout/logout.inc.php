<?php

    unset($_SESSION['time']);
    unset($_SESSION['user_district_id']);
    unset($_SESSION['user_cart']);
    unset($_SESSION['current_customer_id']);
    session_start();
    session_unset();
    session_destroy();

    header('Location: ../index.php');
    die();

?>