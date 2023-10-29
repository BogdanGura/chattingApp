<?php
//Starting the session
session_start();

if(isset($_POST['user_name']) && isset($_POST['password']))
{
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];

    echo "My username is " . $user_name . ", and my password is " . $password;

    //Save the username and password and redirect them to the index page
    $_SESSION["user_name"] = $user_name;
    $_SESSION["password"] = $password;

    header("Location: /index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In Page</title>
</head>
<body>
    <h1>Welcome to the Log In Page</h1>

    <!-- Form to input all the data required -->
    <form method="POST">
        <label>Username:</label>
        <input required name="user_name" placeholder="Type your username here...">
        <br>

        <label>Password:</label>
        <input required name="password" placeholder="Type your password here...">

        <br>
        <button type="submit">Log in</button>
    </form>
</body>
</html>