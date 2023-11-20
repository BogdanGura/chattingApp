<?php
//include functions.php
include 'functions.php';
//Starting the session
session_start();

if(isset($_POST['user_name']) && isset($_POST['password']))
{
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];

    //Validation booleans
    $user_name_valid = false;
    $password_valid = false;

    //sanitize input
    $_POST["user_name"] = sanitize($user_name);
    $_POST["password"] = sanitize($password);

    //Run a config file
    require_once 'config.php';
   
    $retrieve_data_query = "SELECT user_name, password FROM users WHERE user_name = ?";

    //Prepare the statement
    if($statement = mysqli_prepare($db_link, $retrieve_data_query)) {
        mysqli_stmt_bind_param($statement, "s", $param_user_name);
        $param_user_name = $user_name;
    
        if(mysqli_stmt_execute($statement)) 
        {
            mysqli_stmt_store_result($statement);
    
            if(mysqli_stmt_num_rows($statement) == 1) 
            {
                mysqli_stmt_bind_result($statement, $user_name, $hashed_password);
    
                if(mysqli_stmt_fetch($statement)) 
                {
                    // varify password with password hash
                    if(password_verify($password, $hashed_password)) 
                    {
                        $_SESSION['user_name'] = $user_name;
                        $_SESSION['password'] = $password;
    
                        header('Location: /index.php');
                    }
                    else {
                        $login_error = "Invalid username or password";
                    }
                }
            }
            else {
                $login_error = "Invalid username or password";
            }
        }
        else {
            echo "Something went wrong. Please try again later.";
        }
    
        mysqli_stmt_close($statement);
    }
    
    mysqli_close($db_link);
    
    if(!empty($login_error))  
    {
        echo $login_error;
    }
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
        <a href="chattingApp/chatting-app/signup.php">Don't have an account ? Click here to register</a>
        <br>

        <br>
        <a href="chattingApp/chatting-app/forgot-password.php">Forgot your password ? Click here</a>
        <br>
        
        <button type="submit">Log in</button>
    </form>
    
</body>
</html>
