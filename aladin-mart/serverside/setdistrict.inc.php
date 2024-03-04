<?php

    require_once 'configsession.inc.php';
    require_once 'db.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $_SESSION['user_district_id'] = (int) $_POST['districtid'];
        header('Location: ../index.php');

    }