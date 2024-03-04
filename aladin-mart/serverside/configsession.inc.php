<?php

    function generate_session_id() {

        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
        
    }

    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode', 1);

    session_set_cookie_params([
        'lifetime' => 1800,  // How long session will be alive
        'domain' => 'localhost',
        'path' => '/',
        'secure' => true,
        'httponly' => true
    ]);

    session_start();
    
    if (!isset($_SESSION['last_regeneration'])) {
        generate_session_id();
    }
    
    else {
        $interval = 60 * 60;

        if (time() - $_SESSION['last_regeneration'] >= $interval) {
            generate_session_id();
        }
    }

?>