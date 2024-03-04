<?php

    require_once 'configsession.inc.php';
    require_once 'db.inc.php';

?>

<!DOCTYPE html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
    </head>
    <body>
        <?php

            function showData($pdo, $subid) {

                $query = "SELECT * FROM products WHERE subcategory_id = ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$subid]);
                $output = "<ul>\n";

                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $output .="<li>\n";
                    $output .= $result['product_title'];
                    $output .="</li>";

                }

                $output .= "</ul>";
                return $output;



            }

            function showSubCategory($pdo, $subid) {

                $query = "SELECT * FROM subcategories WHERE category_id = ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$subid]);
                $output = "<ul>\n";

                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $output .="<li>\n";
                    $output .= $result['sub_category_name'];
                    $output .= showData($pdo, $result['id']);
                    $output .="</li>";

                }

                $output .= "</ul>";
                return $output;

            }

            function showProducts($pdo) {

                $query = "SELECT * FROM categories;";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $output = "<ul>\n";

                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $output .= "<li>\n";
                    $output .= $result['category_name'];
                    $output .= showSubCategory($pdo, $result['id']);
                    $output .= "</li>";

                }

                $output .= "</ul>";
                return $output;

            }
        ?>
            
            <?php
            
                echo showProducts($pdo, 1);

            ?>

    </body>
</html>