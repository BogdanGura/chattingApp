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
                $user_name_valid = true;
            }
            else{
                echo "Your Username Did NOT match your records <br>";
            }

            //echo $password_result;
            //$hash_result = password_verify($password, $password_result);
            //echo $hash_result;

            if ($user_name_result->num_rows > 0) {
                // First, fetch a row from the SQL result
                $password_row = mysqli_fetch_array($password_result);
            
                // Then iterate through the elements in the $password_row array
                foreach ($password_row as $stored_password) 
                {
                    $password = $_POST["password"];
                    $hash_result = password_verify($password, $stored_password);
                    echo "Entered Password: " . $password . "<br>";
                    echo "Database password: " . $stored_password . "<br>";
                    if ($hash_result) 
                    {
                        echo "Password matches your records <br>";
                        $password_valid = true;
                        break; // Exit the loop since we found a match
                    } else 
                    {
                        echo "Password did NOT match your records <br>";
                    }
                }
                
                // Confirming validation and redirecting the user
                if ($user_name_valid && $password_valid) {
                    // Close the database connection
                    $connection->close();
                    // Save the username and password and redirect them to the index page
                    $_SESSION["user_name"] = $user_name;
                    $_SESSION["password"] = $password;
            
                    header("Location: /index.php");
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
