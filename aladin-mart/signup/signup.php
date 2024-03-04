<?php

    require_once '../login/loginview.inc.php';
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once '../signup/signupview.inc.php';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
    </head>
    <body>

        </br>
        <h3>Back: </h3>
        <a href="../login/login.php">
            <button>Go Back To Login Page</button>
        </a>    
        </br>
        </br>

        <?php
        
            checkSignUpStatus();
        
        ?>

        <?php
        
            echo '<form action="" method="get"
                    <label for="usertype">Enter User Type: </label>
                    <select id="usertype" name="usertype">
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                    </select>
                    <button type="submit">Submit</button>
                </form></br>';
        

            if (isset($_GET['usertype']) && $_GET['usertype'] == "customer") {

                echo '
                
                    <form action="../signup/signupoperations.inc.php" method="post">
                        <p>User Type: <input name="usertype" value="customer"></p>
                        <label for="userfirstname">User First Name: </label>
                        <input required id="userfirstname" type="text" name="userfirstname" placeholder="Enter Your First Name">
                        </br>
                        <label for="userlastname">User Last Name: </label>
                        <input required id="userlastname" type="text" name="userlastname" placeholder="Enter Your Last Name">
                        </br>
                        <label for="userpassword">Password: </label>
                        <input required id="userpassword" type="password" name="userpassword" placeholder="Enter Passwod">
                        </br>
                        <label for="useremail">Email: </label>
                        <input required id="useremail" type="email" name="useremail" placeholder="Enter Your Email">
                        </br>
                        <label for="userphonenumber">Phone Number: (Optional) </label>
                        <input id="userphonenumber" type="tel" name="userphonenumber" placeholder="Enter Your Phone Number" pattern="+8801-[0-9]{9}">
                        </br>
                        <button type="submit">Submit</button>
                        </br>
                    </form>

                ';

            }

            else if (isset($_GET['usertype']) && $_GET['usertype'] == "vendor") {

                echo '
                
                    <form action="../signup/signupoperations.inc.php" method="post">
                    <p>User Type: <input name="usertype" value="vendor"></p>
                        <label for="userfirstname">User First Name: </label>
                        <input required id="userfirstname" type="text" name="userfirstname" placeholder="Enter Your First Name">
                        </br>
                        <label for="userlastname">User Last Name: </label>
                        <input required id="userlastname" type="text" name="userlastname" placeholder="Enter Your Last Name">
                        </br>
                        <label for="userpassword">Password: </label>
                        <input required id="userpassword" type="password" name="userpassword" placeholder="Enter Passwod">
                        </br>
                        <label for="useremail">Email: </label>
                        <input required id="useremail" type="email" name="useremail" placeholder="Enter Your Email">
                        </br>
                        <label for="userphonenumber">Phone Number: </label>
                        <input required id="userphonenumber" type="tel" name="userphonenumber" placeholder="Enter Your Phone Number" pattern="+8801-[0-9]{9}">
                        </br>
                        <label for="usershopname">Shop Name: </label>
                        <input required id="usershopname" type="text" name="usershopname" placeholder="Enter You Shop Name">
                        </br>
                        <button type="submit">Submit</button>
                        </br>
                    </form>
                
                ';

            }

        ?>

    </body>
</html>

