<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'userprofilecontroller.inc.php';
    require_once 'userprofilemodel.inc.php';
    require_once '../signup/signupcontroller.inc.php';
    require_once '../signup/signupmodel.inc.php';

    if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nuserfirstname") {

        $userid = $_POST['user_id'];
        $userfirstname = $_POST['newuserfirstname'];
        
        try {

            if (editFieldEmptyCheck($userfirstname)) {

                $editprofileerrors['first_name_empty'] = "Please Insert First Name";
    
            }
    
            if ($editprofileerrors) {
    
                $_SESSION['edit_profil_errors'] = $editprofileerrors;
                header('Location: userprofileedit.php?current_user_id=' . $userid . '');
    
            }
    
            else {
                
                $userfirstname = strtolower((str_replace(" ", "_", $userfirstname)));
                editUserFirstName($pdo, $userid, $userfirstname);
                $changestatus = "User First Name Has Been changed Successfully";
                header('Location: userprofileedit.php?current_user_id=' . $userid . '&status=' . $changestatus . '');
    
            }
    
            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nuserlastname") {

        $userid = $_POST['user_id'];
        $userlastname = $_POST['newuserlastname'];
        
        try {

            if (editFieldEmptyCheck($userlastname)) {

                $editprofileerrors['last_name_empty'] = "Please Insert Last Name";
    
            }
    
            if ($editprofileerrors) {
    
                $_SESSION['edit_profil_errors'] = $editprofileerrors;
                header('Location: userprofileedit.php?current_user_id=' . $userid . '');
    
            }
    
            else {
                
                $userlastname = strtolower((str_replace(" ", "_", $userlastname)));
                editUserLastName($pdo, $userid, $userlastname);
                $changestatus = "User Last Name Has Been changed Successfully";
                header('Location: userprofileedit.php?current_user_id=' . $userid . '&status=' . $changestatus . '');
    
            }
    
            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nuserpassword") {

        $userid = $_POST['user_id'];
        $userpassword = $_POST['newuserpassword'];
        
        try {

            if (editFieldEmptyCheck($userpassword)) {

                $editprofileerrors['password_field_empty'] = "Please Insert Password";
    
            }
    
            if ($editprofileerrors) {
    
                $_SESSION['edit_profil_errors'] = $editprofileerrors;
                header('Location: userprofileedit.php?current_user_id=' . $userid . '');
    
            }
    
            else {
    
                editUserPassword($pdo, $userid, $userpassword);
                $changestatus = "User Password Has Been changed Successfully";
                header('Location: userprofileedit.php?current_user_id=' . $userid . '&status=' . $changestatus . '');
    
            }
    
            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nuseremail") {

        $userid = $_POST['user_id'];
        $useremail = $_POST['newuseremail'];
        
        try {

            if (editFieldEmptyCheck($useremail)) {

                $editprofileerrors['email_field_empty'] = "Please Insert Email";
    
            }

            if ($useremail) {

                if (emailValidation($useremail)) {

                    $editprofileerrors['email_format_error'] = "Please Insert Email In Correct Format";
    
                } 
    
                if (emailUniqueCheck($pdo, $useremail)) {
    
                    $editprofileerrors['email_duplicate_error'] = "Please Insert An Unique Email";
    
                }

            }

            if ($editprofileerrors) {
    
                $_SESSION['edit_profil_errors'] = $editprofileerrors;
                header('Location: userprofileedit.php?current_user_id=' . $userid . '');
    
            }
    
            else {
    
                editUserEmail($pdo, $userid, $useremail);
                $changestatus = "User Email Has Been changed Successfully";
                header('Location: userprofileedit.php?current_user_id=' . $userid . '&status=' . $changestatus . '');
    
            }
    
            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    } 

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nusernumber") {

        $userid = $_POST['user_id'];
        $usernumber = $_POST['newusernumber'];
        
        try {

            if (editFieldEmptyCheck($usernumber)) {

                $editprofileerrors['email_field_empty'] = "Please Insert Phone Number";
    
            }

            if ($usernumbe) {

                if (phoneNumberValidation($usernumber)) {

                    $editprofileerrors['phone_format_error'] = "Please Insert Phone Number In Correct Format";
    
                } 
    
                if (phoneUniqueCheck($pdo, $usernumber)) {
    
                    $editprofileerrors['phone_number_duplicate_error'] = "Please Insert An Unique Email";
    
                }

            }
    
            if ($editprofileerrors) {
    
                $_SESSION['edit_profil_errors'] = $editprofileerrors;
                header('Location: userprofileedit.php?current_user_id=' . $userid . '');
    
            }
    
            else {
    
                editUserNumber($pdo, $userid, $usernumber);
                $changestatus = "User Phone Number Has Been changed Successfully";
                header('Location: userprofileedit.php?current_user_id=' . $userid . '&status=' . $changestatus . '');
    
            }
    
            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['edit_type']) && $_POST['edit_type'] == "nshopname") {

        $userid = $_POST['user_id'];
        $usershopname = $_POST['newusershopname'];
        $usershopname = ($usershopname) ? strtolower((str_replace(" ", "_", $usershopname))) : null;
        
        try {

            if (editFieldEmptyCheck($usershopname)) {

                $editprofileerrors['email_field_empty'] = "Please Insert Phone Number";
    
            }

            if ($usershopname) {
    
                if (uniqueShopNameCheck($pdo, $usershopname)) {
    
                    $editprofileerrors['shop_name_duplicate_error'] = "Please Insert An Unique Shop Name";
    
                }

            }
    
            if ($editprofileerrors) {
    
                $_SESSION['edit_profil_errors'] = $editprofileerrors;
                header('Location: userprofileedit.php?current_user_id=' . $userid . '');
    
            }
    
            else {
    
                editUserShopName($pdo, $userid, $usershopname);
                $changestatus = "User Shop Name Has Been changed Successfully";
                header('Location: userprofileedit.php?current_user_id=' . $userid . '&status=' . $changestatus . '');
    
            }
    
            die();
            $pdo = null;
            $stmt = null;

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else {

        header('Location: userprofileedit.php?current_user_id=' . $userid . '');
        die();
    
    }

?>