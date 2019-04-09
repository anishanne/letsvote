<?php
    define('DB_SERVER', 'localhost:3306');
    define('DB_USERNAME', 'username');
    define('DB_PASSWORD', 'password');
    define('DB_DATABASE', 'database');
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($db === false)
        die("Uh-oh, MySQL connection error: " . mysqli_connect_error());