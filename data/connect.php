<?php 

/*
    If we want to do anything on a database, we need to connect to it AND be authorised to use it! 
    Here, we're going to create a connection string. We will include this in every subsequent page in our website.

    Because these credentials are HARD CODED, this is a very dangerous file. We need to make sure that it never goes into public_html (only our data/ directory on our server).
*/

define('DB_HOST', "mysql");
define("DB_USER", "student");
define('DB_PASS', 'student');
define('DB_NAME', 'dmit2025');

function db_connect() {
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (mysqli_connect_errno()) {
        echo 'Failed to connect to MYSQL: ' . mysqli_connect_error();
    } else {
        $connection->set_charset('utf8mb4');
        return $connection;
    }
}

function db_disconnect($connect) {
    if (isset($connect)) {
        mysqli_close($connect);
    }
}

?>