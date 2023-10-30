<?php
//include functions.php
include 'functions.php';
//Starting the session
session_start();

if(isset($_POST['user_name']) && isset($_POST['password']))
{
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];

    //sanitize input
    $user_name = sanitize($user_name);
    $password = sanitize($password);

    //Connect to the database and validate the input.
    //Then check if that account exist and if it does redirect user
    //to the index page where their info is displayed
    $server = "localhost"; 
    $username = "root"; 
    $passwordDB = ""; 
    $database = "chatting_app";

    // Create a connection
    $connection = new mysqli($server, $username, $passwordDB, $database);

    // Check if the connection was successful
    if ($connection->connect_error) 
    {
        die("Connection failed: " . $connection->connect_error);
    } 
    else{
        $retrieve_user_name_query = "SELECT user_name FROM users WHERE user_name = '$user_name'";
        $retrieve_passwords_query = "SELECT password FROM users";

        //Running both queries
        $user_name_result = $connection->query($retrieve_user_name_query);
        $password_result = $connection->query($retrieve_passwords_query);

        //Check the status user_name query
        if($user_name_result && $password_result)
        {
            //echo "Username query and password Query went through :)";

            //Compare the results
            //If username rows returned is greater than one IT'S a MATCH
            //same goes for password
            if($user_name_result->num_rows > 0)
            {
                echo "Username matches your records <br>";

                //Save the username and password and redirect them to the index page
                //$_SESSION["user_name"] = $user_name;
                //$_SESSION["password"] = $password;

                //header("Location: /index.php");
            }
            else{
                echo "Your Username Did NOT match your records <br>";
            }

            //echo $password_result;
            //$hash_result = password_verify($password, $password_result);
            //echo $hash_result;

            if($user_name_result->num_rows > 0)
            {
                //First we fetch a row from the sql object
                $password_row = mysqli_fetch_array($password_result);

                //Then we check each item for your passsword
                //if it matches it valid
                for ($i = 0; $i < count($password_row); $i++) 
                { 
                    //Checking if index exists first
                    if(empty($i))
                    {
                        $hash_result = password_verify($password, $password_row[$i]);
                        echo "Entered Password: " . $password . "<br>";
                        echo "Database password: " .  $password_row[$i] . "<br>";
                        if($hash_result)
                        {
                            echo "Password matches your records <br>";
                        }
                        else{
                            echo "Password did NOT match your records <br>";
                        }
                    }
                }
            }
        }
        else{
            echo "Insertion Query failed: " . $connection->error;
        }
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
        <a href="/chatting-app/signup.php">Don't have an account ? Click here to register</a>
        <br>
        
        <button type="submit">Log in</button>
    </form>
    
</body>
</html>
