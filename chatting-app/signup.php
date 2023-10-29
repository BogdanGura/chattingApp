<?php
//Include neceserary files 
include "functions.php";
//Starting the session
session_start();

if(isset($_POST['user_name']) && isset($_POST['password'])
   && isset($_POST['email']))
{
    //Removing any whitespaces from the passed data
    $user_name = trim($_POST["user_name"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    // checking if username is long enogh 
    // and then removing any html from it
    //sanitize is a function from functions.php
    if(strlen($user_name) < 5)
    {
        echo("Username that you entered is too short. Valid usernames are atleast 5 
            characters and no greater than 20 characters <br>");
    }
    else if(strlen($user_name) > 21)
    {
        echo("Username that you entered is too long. Valid usernames can't be longer than 20 characters
            or shorter than 5 characters <br>");
    }
    else{
        $user_name = sanitize($user_name);
    }

    //Validating the password
    if(strlen($password) < 5)
    {
        echo("Password that you entered is too short. Valid passwords are atleast 5 
            characters and no greater than 20 characters <br>");
    }
    else if(strlen($password) > 21)
    {
        echo("Password that you entered is too long. Valid passwords can't be longer than 20 characters
            or shorter than 5 characters <br>");
    }
    else{
        $password = sanitize($password);
    }
    
    //Checking if password and user_name
    //got validated
    //Checking if this username already exists
    if(isset($user_name) && isset($password))
    {

        //connect to a database and check if the user_name already
        // exists

        $server = "localhost"; 
        $username = "root"; 
        $password = ""; 
        $database = "chatting_app";

        // Create a connection
        $connection = new mysqli($server, $username, $password, $database);

        // Check if the connection was successful
        if ($connection->connect_error) 
        {
            die("Connection failed: " . $connection->connect_error);

        } 
        else 
        {
           //When we connected to the database succesfully we should run a query and
           //see of your user_name is already present in the database
           $search_for_duplicates_query = "SELECT user_name FROM users WHERE user_name = '$user_name'";

           //run the query and harvest the result
           $result = $connection->query($search_for_duplicates_query);

           //if query is executed successfully, continue checking for 
           //diplicates
           if($result)
           {
                //echo"Query went through <br>";
                //num_rows is a property that 
                //returns the number of rows in
                //the result


                if($result->num_rows > 0)
                {
                    echo"Username you entered already exists. Please enter a different username.";
                }
                else{
                    //SO THE ISSUE IS THAT PASSWORD AND OTHER VARIABLES
                    //DON'T REACH DOWN THIS LOW OR THEY AREN'T THE TYPE THEY SHOULD
                    //BE

                    
                    //echo "Username is valid <br>"; 

                    //Now that user_name is valid and not taken
                    // we can finally input everithing into a database

                    //First, hash the password
                    die($password);
                    //$password = password_hash($password, PASSWORD_BCRYPT);

                    //Query that will insert all the data into the database
                    //$insert_user_password_email_query = "INSERT INTO users (user_name, password, email) VALUES ('$user_name', '$password', '$email')";

                    //$insertion_result = $connection->query($insert_user_password_email_query);
                    //Run the query
                    if($insertion_result)
                    {
                        //if query went through run everithing below
                        //After data insertion,close the connection then redirect the user to the login.php page
                        $connection->close();

                        header("Location: login.php");
                    }
                    else{
                        echo "Insertion Query failed: " . $connection->error;
                    }

                    
                }
           }
           else{
                echo"Query failed to execute: " . $connection->error;
           }
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
    <h1>Welcome to the Sign Up Page</h1>

    <!-- Form to input all the data required -->
    <form method="POST">
        <label>Username:</label>
        <input required name="user_name" placeholder="Type your username here...">
        <br>

        <label>Password:</label>
        <input required name="password" placeholder="Type your password here...">
        <br>

        <label>Email:</label>
        <input required name="email" type="email" placeholder="Type your email here...">

        <br>
        <button type="submit">Log in</button>
    </form>
</body>
</html>