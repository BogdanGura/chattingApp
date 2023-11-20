<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'chatting_app');

$db_link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($db_link === false) {
    echo "Something went wrong. Please try again.";
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>
