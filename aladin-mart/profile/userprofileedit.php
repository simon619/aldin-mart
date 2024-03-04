<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'userprofilecontroller.inc.php';
    require_once 'userprofilemodel.inc.php';

    if (isset($_GET['current_user_id'])) {

        $currentuserid = (int) $_GET['current_user_id'];

    }

    if (!isset($_SESSION['user_id']) || !($_SESSION['user_id']) || (isset($_SESSION['user_id']) && (int) $_SESSION['user_id']) != $currentuserid) {

        header('Location: ../index.php');

    }

    $username = (String) $_SESSION['user_name'];
    $userid = (int) $_SESSION['user_id'];
    echo 'Logged In As: ' . htmlspecialchars(ucwords($_SESSION['user_type'])) . ' ' . htmlspecialchars(ucwords(str_replace("_", " ", $username))) . '</br>';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <style>
      body {
        margin: 0;
        padding: 0;
      }
      h2 {
        padding: 0;
        margin: 0;
      }
      main {
        .profileContainer {
          width: 350px;

          /* .profileImage {
            width: 150px;

            img {
              width: 100%;
            }
          } */

          .profileInfo {
            display: flex;
            flex-direction: column;
            row-gap: 0.2rem;

            div {
              display: flex;
              align-items: center;
              gap: 0.5rem;

              span:first-child,
              h2:first-child {
                width: 90px;
                display: flex;
                justify-content: space-between;
              }
            }
          }
        }
      }
    </style>
    </head>
    <body>

        

        <?php

            echo '<a href="userprofile.php?current_user_id=' . $userid .'">
                <button>back To Profile Page</button>
            </a> ';

            echo '</br>';

            if (isset($_SESSION['edit_profil_errors'])) {

              $errors = $_SESSION["edit_profil_errors"];
              echo "<h3> Error: </h3>";
  
              foreach ($errors as $key => $value) {
  
                  $errorkey = ucwords(str_replace("_", " ", $key));
                  $errorname = ucwords(str_replace("_", " ", $errors[$key]));
                  echo '<p class="form-error">Error: ' . htmlspecialchars($errorkey) . ' Solve: ' . htmlspecialchars($errorname) . '</br></p>';
  
              }
  
              unset($_SESSION['edit_profil_errors']);
              
            }
            
            else if (isset($_GET['status'])) {
    
                echo '<p class="form-success">' . htmlspecialchars($_GET['status']) . '</br></p>';
                unset($_GET['status']);
            
            }

            if ($currentuserid == (int) $_SESSION['user_id']) {

                $myprofile = getMyProfile($pdo, $currentuserid);
                $userid = (String) $myprofile['id'];
                $username = ucwords(str_replace("_", " ", $myprofile['user_first_name'])) . ' ' . ucwords(str_replace("_", " ", $myprofile['user_last_name']));
                $useremail = $myprofile['user_email'];
                $usernumber = ($myprofile['user_number']) ? $myprofile['user_number'] : "No Number Founder";
                $usershopename = ucwords(str_replace("_", " ", $myprofile['user_shop_name']));
                $usertype = $myprofile['user_type'];
                
                echo '<main>
                <div class="profileContainer">
                  <!-- <div class="profileImage">
                    <img src="https://randomuser.me/api/portraits/men/91.jpg" alt="" />
                  </div> -->
                  <div class="profileInfo">
                    <div class="profileName">
                      <h2>
                        <span>Name</span>
                        <span>:</span>
                      </h2>
                      <h2>' . htmlspecialchars($username) . '</h2>
                    </div>
                    <div class="profileEmail">
                      <span>
                        <span>Email</span>
                        <span>:</span>
                      </span>
                      <span>' . htmlspecialchars($useremail) . '</span>
                    </div>
                    <div class="profileContact">
                      <span>
                        <span>Number</span>
                        <span>:</span>
                      </span>
                      <span>' . htmlspecialchars($usernumber) . '</span>
                    </div>
                    <div class="profileNumber">
                      <span>
                        <span>ID</span>
                        <span>:</span>
                      </span>
                      <span>' . htmlspecialchars($userid) . '</span>
                    </div>
                    <div class="profileType">
                      <span>
                        <span>Type</span>
                        <span>:</span>
                      </span>
                      <span>' . htmlspecialchars($usertype) . '</span>
                    </div>';

                    if ($_SESSION['user_type'] == "vendor") {

                        echo '<div class="profileShopName">
                            <span>
                            <span>Shop Name</span>
                            <span>:</span>
                            </span>
                            <span>' . htmlspecialchars($usershopename) . '</span>
                        </div>';

                    }
                    
                echo '</div>
                </div>
              </main>';

              echo '<h2>Edit User Profile</h2></br>';

              echo '
                    
                <form action="userprofileeditoperations.inc.php" method="post">
                    <input type="hidden" name="user_id" value="'. $currentuserid .'">
                    <input type="hidden" name="edit_type" value="nuserfirstname">
                    <label for="newuserfirstname">Change User First Name: </label>
                    <input required id="newuserfirstname" type="text" name="newuserfirstname" placeholder="Enter New User First Name">
                    <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                </form>

                <form action="userprofileeditoperations.inc.php" method="post">
                    <input type="hidden" name="user_id" value="'. $currentuserid .'">
                    <input type="hidden" name="edit_type" value="nuserlastname">
                    <label for="newuserlastname">Change User Last Name: </label>
                    <input required id="newuserlastname" type="text" name="newuserlastname" placeholder="Enter New User Last Name">
                    <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                </form>

                <form action="userprofileeditoperations.inc.php" method="post">
                    <input type="hidden" name="user_id" value="'. $currentuserid .'">
                    <input type="hidden" name="edit_type" value="nuserpassword">
                    <label for="newuserpassword">Change User Password: </label>
                    <input required id="newuserpassword" type="text" name="newuserpassword" placeholder="Enter New Password">
                    <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                </form>

                <form action="userprofileeditoperations.inc.php" method="post">
                    <input type="hidden" name="user_id" value="'. $currentuserid .'">
                    <input type="hidden" name="edit_type" value="nuseremail">
                    <label for="newuseremail">Change User Email: </label>
                    <input required id="newuseremail" type="email" name="newuseremail" placeholder="Enter New User Email">
                    <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                </form>

                <form action="userprofileeditoperations.inc.php" method="post">
                    <input type="hidden" name="user_id" value="'. $currentuserid .'">
                    <input type="hidden" name="edit_type" value="nusernumber">
                    <label for="newusernumber">Change User Number: </label>
                    <input required id="newusernumber" type="tel" name="newusernumber" placeholder="Enter New User Phone Number">
                    <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                </form>';

            }

            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "vendor") {

              echo '<form action="userprofileeditoperations.inc.php" method="post">
                  <input type="hidden" name="user_id" value="'. $currentuserid .'">
                  <input type="hidden" name="edit_type" value="nshopname">
                  <label for="newusershopname">Change Vendor Shop Name: </label>
                  <input required id="newusershopname" type="text" name="newusershopname" placeholder="Enter New Vendor Shop Name">
                  <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
              </form>';

            }

        ?>
        
    </body>
</html>