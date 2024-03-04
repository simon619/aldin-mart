<?php

    require_once 'configsession.inc.php';
    require_once 'db.inc.php';

    $handle = fopen("districts.txt", "r");
    if ($handle) {

        while (($line = fgets($handle)) !== false) {
            
            $districts = strtolower((str_replace(" ", "_", $line)));
            $query = "INSERT INTO districts (district_name) VALUES (?);";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$districts]);

        }

        fclose($handle);
        echo "Successfully Done";
        
    }

?>