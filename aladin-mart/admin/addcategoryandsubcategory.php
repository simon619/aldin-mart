<?php

    require_once '../serverside/configsession.inc.php';
    require_once '../serverside/db.inc.php';
    require_once 'categoryview.inc.php';
    require_once 'categorycontroller.inc.php';
    require_once 'categorymodel.inc.php';

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
        <a href="adminhomepage.php">
            <button>Back To Admin Page</button>
        </a>    
        </br>
        </br>

        <form action="addcategoryoperation.inc.php" method="post">
            <label for="categoryname">New Category Name: </label>
            <input required id="categoryname" type="text" name="categoryname" placeholder="Enter Your New Category Name">
            <button type="submit">Submit</button>
            </br>
        </form>

        <?php
        
            categoryAddedStatus();
        
        ?>
        </br>

        <form action="addsubcategoryoperation.inc.php" method="post">

            <?php
                
                $categorynames = getCategoryName($pdo);

            ?>

            <label for="subcategoryname">New Sub Category Name: </label>
            <input required id="subcategoryname" type="text" name="subcategoryname" placeholder="Enter Your New Sub Category Name">
            </br>
            <label for="categoryid">Enter Category Name: </label>
            <select id="categoryid" name="categoryid">
                
                <?php
                
                    foreach ($categorynames as $keys => $values) {

                        echo "<option value=" . $values['id'] . ">" . htmlspecialchars(ucwords(str_replace("_", " ", $values['category_name']))) . "</option>";

                    }
                    
                ?>

            </select>
            </br>
            <button type="submit">Submit</button>
            </br>
        </form>

        <?php
        
            subcategoryAddedStatus();
        
        ?>

    </body>
</html>