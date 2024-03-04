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

            if ($_SESSION['user_type'] == "admin") {

                echo '</br>
                    <a href="../admin/adminhomepage.php">
                        <button>Admin Homepage</button>
                    </a>    
                </br>';

            }

            if ($_SESSION['user_type'] == "vendor") {

                echo '</br>
                    <a href="../vendor/vendorhomepage.php">
                        <button>Vendor Homepage</button>
                    </a>    
                </br>';

            }

            if ($_SESSION['user_type'] == "customer") {

                echo '</br>
                    <a href="../customer/customerhomepage.php">
                        <button>Customer Homeapage</button>
                    </a>    
                </br>';

            }

            echo '</br>';

            if ($currentuserid == (int) $_SESSION['user_id']) {

                $myprofile = getMyProfile($pdo, $currentuserid);
                $userid = (String) $myprofile['id'];
                $username = ucwords(str_replace("_", " ", $myprofile['user_first_name'])) . ' ' . ucwords(str_replace("_", " ", $myprofile['user_last_name']));
                $useremail = $myprofile['user_email'];
                $usernumber = ($myprofile['user_number']) ? $myprofile['user_number'] : "No Number Found";
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

                    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "vendor") {

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

            }

        ?>
        
        <?php
        
            echo '</br>
                    <a href="../profile/userprofileedit.php?current_user_id=' . $currentuserid .'">
                        <button>My Profile Edit</button>
                    </a>    
                </br>';
        ?>

    </body>
</html>