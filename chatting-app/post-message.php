<?php
session_start();
require_once 'config.php';

//Insert a message in to the database
//from the insert message input
if(isset($_POST['message']) && isset($_SESSION['user_name']))
{
    $sender = $_SESSION['user_name'];
    $message = $_POST['message'];
    //Insert query for message
    $sql = "INSERT INTO messages (message_sender, message_content) VALUES (?, ?)";

    //Prepare the statement
    if($statement = mysqli_prepare($db_link, $sql)) 
    {
        mysqli_stmt_bind_param($statement, "ss", $sender, $message);
    
        if(mysqli_stmt_execute($statement)) 
        {
            mysqli_stmt_close($statement);
            mysqli_close($db_link);
            header('Location: /index.php');
        }
        else 
        {
            echo "statement failed to execute.";
        }
    }  
}
else{
    echo"Your message is not defined";
}  
?>
