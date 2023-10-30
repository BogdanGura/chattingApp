<!-- Chatting app by Bogdan Gura -->
<!-- Date: 10/29/23 -->
<?php
session_start();
/*
Checking if a user is not loged in
if not they will be redirected to the
login.php page
*/
if(!isset($_SESSION["user_name"]) && !isset($_SESSION["password"]))
{
    header("Location: chatting-app/login.php");
}
/*
if user is loged in then show him the index page 
with a welcome message
*/
else{
    $username = $_SESSION["user_name"];
    $password = $_SESSION["password"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?></h1>
    <a href="/chatting-app/logout.php">Log Out</a>
</body>
</html>
