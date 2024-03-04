<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nested nav bar code with sk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous">
    </script>

    <script src="asset/navbar.js"></script>
</head>

<body>

    <?php

        require_once 'db.inc.php';
        require_once 'configsession.inc.php';

        function showProductTest($pdo, $subcatid) {

            $query = "SELECT * FROM products WHERE subcategory_id = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$subcatid]);
            $html = "";
            $html .= "<ul class='dropdown-menu'>";

            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $productid = $result['id'];
                $vendorid = $result['vendor_id'];
                $child = "no-child";
                $html .= "<li class = '$child " . "parent-" .
                $subcatid .
                "'><a href='../products/productdetail.php?product_id=" . $productid . "&vendor_id=" . $vendorid . "'>" . $result['product_title'] . 
                "</a></li>";
                // $parentDepth0 = "parent-depth-all";
                // $html .= "<li class= '$parentDepth0 " . 'parent-' .
                // $subcatid . "'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>" . 
                // $result['product_title'] . " <b class='caret caret-right'></b></a>";
                // // showProductTest($pdo, $result['id']);
                // $html .= "</li>";

            }

            $html .= "</ul>";
            return $html;

        }

        function showSubCategoryTest($pdo, $catid) {

            $query = "SELECT * FROM subcategories WHERE category_id = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$catid]);
            $html = "";
            $html .= "<ul class='dropdown-menu'>";

            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                
                $parentDepth0 = "parent-depth-all";
                $html .= "<li class= '$parentDepth0 " . 'parent-' .
                $catid . "'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>" . 
                $result['sub_category_name'] . " <b class='caret caret-right'></b></a>";
                $html .= showProductTest($pdo, $result['id']);
                $html .= "</li>";

            }

            $html .= "</ul>";
            return $html;

        }

        function showCategoryTest($pdo) {

            $query = "SELECT * FROM categories;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $html = "";
            $html .= "<ul class='dropdown-menu'>";
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $parentDepth0 = "parent-depth-0";
                $html .= "<li class= '$parentDepth0 " . 'parent-' . 0 ."'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>" . 
                $result['category_name'] . " <b class='caret caret-right'></b></a>";
                $html .= showSubCategoryTest($pdo, $result['id']);
                $html .= "</li>";

            }

            $html .= "</ul>";
            return $html;

        }

    ?>

    <div class="container">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <a href="" class="navbar-brand">Code with sk</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li>
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Web <b class="caret"></b></a>
                       <?php

                            echo showCategoryTest($pdo);
                       
                       ?>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="">Login</a></li>
                    <li><a href="">Signup</a></li>
                </ul>
            </div>
        </nav>
        <div class="jumbotron">
            <h1>Code With SK</h1>
            <p>This tutorial is a quick exercise to illustrate how the make dynamic nested category menu, In top navbar.
                 It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
            </p>
            <p>
                <a href="" class="btn btn-primary btn-lg">Subscribe our Channel</a>
            </p>
        </div>
    </div>

</body>

</html>