<?php

    require_once '../login/loginview.inc.php';
    require_once '../signup/signupview.inc.php';
    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';

?>


<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>

        </br>
        <h2>Create an Account: </h2>
        <a href="../signup/signup.php">
            <button>Sign Up</button>
        </a>    
        </br>
        </br>

        <?php
        
            checkSignUpStatus();
            loggedInStatus();
        
        ?>

        <h2>Log In: </h2>
        <form action="loginoperation.inc.php" method="post">
            <label for="useremail">User Email: </label>
            <input required id="useremail" type="email" name="useremail" placeholder="Enter Your Email Address">
            </br>
            <label for="userpassword">Password: iamwasif</label>
            <input required id="userpassword" type="password" name="userpassword" placeholder="Enter Your Password">
            </br>           
            <button type="submit">Submit</button>
            </br>
        </form> 

    </body>
</html>