<?php
//When user logs out, clear cache
session_start();
session_destroy();

//The redirect the user to the login page
header("Location: \chattingApp\chatting-app\login.php");
?>