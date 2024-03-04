<?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $useremail = $_POST['useremail'];
        $userpassword = $_POST['userpassword'];

        try {

            require_once 'logincontroller.inc.php';
            require_once 'loginmodel.inc.php';
            require_once '../signup/signupcontroller.inc.php';
            require_once '../signup/signupmodel.inc.php';
            require_once '../serverside/db.inc.php';

            $login_errors = array();

            if (loginEmpty($useremail, $userpassword)) {

                $login_errors['empty_box'] = "Please Insert Data Correctly";

            }


            if (emailValidation($useremail)) {

                $login_errors['email_format_invalid'] = "Enter Valid Email";
            
            }

            $result = getUserData($pdo, $useremail);

            if (userExistanceValidation($result)) {

                $login_errors['user_existance'] = "Inserted Phone Number Does Not Exist";

            }

            if (!userExistanceValidation($result) && userInformationValidation($pdo, $useremail, $userpassword)) {

                $login_errors['incorrect_information'] = "Inserted Password Is Incorrect";

            }

            require_once '../serverside/configsession.inc.php';

            if ($login_errors) {

                $_SESSION["errors_on_login"] = $login_errors;
                header('Location: ../login/login.php');
                die();
                
            }

            else if (!$result['profile_status']) {

                $_SESSION['blocked_error'] = "User, You Have Been Blocked By Admin. Please Contact For More";
                header('Location: ../index.php');

            }

            else {

                
                $username  = (String) $result['user_first_name'] . '_' . $result['user_last_name'];

                if ($result['user_type'] == "admin") {
                    
                    $_SESSION['user_type'] = $result['user_type'];
                    $_SESSION['user_name'] = $username;
                    $_SESSION['user_id'] = $result['id'];
                    header('Location: ../admin/adminhomepage.php?loggedin=successful');

                }

                else if ($result['user_type'] == "vendor") {
                    
                    $_SESSION['user_type'] = $result['user_type'];
                    $_SESSION['user_name'] = $username;
                    $_SESSION['user_id'] = $result['id'];
                    $_SESSION['user_shop_name'] = $result['user_shop_name'];
                    header('Location: ../vendor/vendorhomepage.php?loggedin=successful');

                }

                else if ($result['user_type'] == "customer") {
                    
                    $_SESSION['user_type'] = $result['user_type'];
                    $_SESSION['user_name'] = $username;
                    $_SESSION['user_id'] = $result['id'];
                    $_SESSION['user_cart'] = array();
                    header('Location: ../index.php?loggedin=successful');

                }

                $_SESSION['last_regeneration'] = time();
                $pdo = null;
                $stmt = null;
                die();
            
            }
        
        }

        catch (PDOException $e) {

            header('Location: ../index.php');
            die("Query Faild: ". $e->getMessage()."</br>");

        }

    }

    else {

        header('Location: ../login/login.php');
        die(); 

    }
?>