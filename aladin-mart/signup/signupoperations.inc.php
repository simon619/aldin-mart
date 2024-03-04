<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $userfirstnametemp = $_POST['userfirstname'];
        $userlastnametemp = $_POST['userlastname'];
        $userfirstname = ($userfirstnametemp) ? strtolower((str_replace(" ", "_", $userfirstnametemp))) : null;
        $userlastname = ($userlastnametemp) ? strtolower((str_replace(" ", "_", $userlastnametemp))) : null;
        $userpassword = $_POST['userpassword'];
        $useremail = $_POST['useremail'];
        $usernumber = (isset($_POST['userphonenumber'])) ? $_POST['userphonenumber'] : null;
        $usertype = $_POST['usertype'];
        $usershopname = (isset($_POST['usershopname'])) ? strtolower((str_replace(" ", "_", $_POST['usershopname']))) : null;

        

        try {

            require_once 'signupmodel.inc.php';
            require_once 'signupcontroller.inc.php';
            require_once 'signupview.inc.php';

            $signuperrors = array();

            if (isEmpty($userfirstname, $userlastname, $userpassword, $useremail)) {

                $signuperrors['data_input_require'] = "Boxes Can Not Be Empty";

            }

            if ($usernumber) {

                if (phoneNumberValidation($usernumber)) {

                    $signuperrors['phone_number_invalid'] = "Enter Valid Number";
                
                }

            }
            
            if (emailValidation($useremail)) {

                $signuperrors['invalid_email'] = "Enter Valid Email";

            }

            if ($usertype == "vendor") {

                if (empty($usershopname))  {

                    $signuperrors['shopname_empty'] = "Shop Name Can Not Be Empty";

                }

                if (!empty($usershopname) && uniqueShopNameCheck($pdo, $usershopname)) {

                    $signuperrors['shopname_unique'] = "Shop Name Has To Be Unique";

                }

            }


            if (checkUserDataDuplication($pdo, $usernumber, $useremail)) {

                $signuperrors['number_duplicate'] = "Phone Number or Email Address Already Exists";

            }

            if ($signuperrors) {

                $_SESSION['error_at_signup'] = $signuperrors;
                header('Location: ../signup/signup.php');
                die();

            }

            else {

                createAUser($pdo, $userfirstname, $userlastname, $userpassword, $useremail, $usernumber, $usertype, $usershopname);
                header('Location: ../login/login.php?signup=successful');              
                die();
                $pdo = null;
                $stmt = null;

            }

        }

        catch (PDOException $e) {

            die("Query Faild: ". $e->getMessage()."</br>");
        
        }

    }

    else {

        header('Location: ../signup/signup.php');
        die();
        
    }

?>