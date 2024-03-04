<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'adminmodel.inc.php';
    require_once 'admincontroller.inc.php';
    require_once 'adminview.inc.php';

    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "admin") {

        header('Location: ../index.php');

    }

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
    </head>
    <body>

        </br>
        <a href="../admin/adminhomepage.php">
            <button>Admin Homepage</button>
        </a>    
        </br>

        <h2>Get Users Earn/Spend</h2>
        <?php
        
            if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "admin")) {

                echo '<h3>Enter Prefix of Vendor Name</h3>
                    <form action="" method="get">
                        <label for="usertype">Choose An User:</label>
                        <select name="usertype" id="cars">
                            <option value="0">Customer</option>
                            <option value="1">Vendor</option>
                        </select></br>
                        <label for="prefixname">User Name: </label>
                        <input id="prefixname" type="text" name="prefixname" placeholder="Enter Vendor Name">
                        </br>
                    <button type="submit">Submit</button>
                </form></br>';

                if (isset($_GET['usertype']) && isset($_GET['prefixname'])) {

                    $prefixname = (String) $_GET['prefixname'];
                    $usertype = (int) $_GET['usertype'];
                    $usersdata = getUsersEarnSpendData($pdo, $prefixname, $usertype);
                    
                    if ($usersdata) {

                        showUsersEarnSpendData($usersdata);
                        die();
                        $pdo = null;
                        $stmt = null;

                    }

                    else {

                        echo '<p class="form-error">No User Found</br></p>';

                    }

                }

                else {

                    echo '<p class="form-error">Please Insert Data Correctly</br></p>';

                }

            }
        
        ?>

    </body>
</html>