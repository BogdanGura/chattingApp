<!-- Chatting app by Bogdan Gura -->
<!-- Date: 10/29/23 -->
<?php
session_start();

require_once 'chattingApp/chatting-app/config.php';
/*
Checking if a user is not loged in
if not they will be redirected to the
login.php page
*/
if(!isset($_SESSION["user_name"]) && !isset($_SESSION["password"]))
{
    header("Location: chattingApp/chatting-app/login.php");
}
/*
if user is loged in then show him the index page 
with a welcome message
*/
else{
    $username = $_SESSION["user_name"];
    $password = $_SESSION["password"];

    //Each time a registered user would 
    //get to the index page, a function would run that would
    //retreive all the messages from the database and output them
    //in the div message container
    //Insert query for message

    //Retrieve all the messages
    $sql = "SELECT message_sender, message_content FROM messages";

    //Prepare the statement
    if($statement = mysqli_prepare($db_link, $sql)) 
    {
       if($statement->execute())
       {
            $raw_result = $statement->get_result();
       }
    } 
    else{
        echo "preparation failed";
    } 
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

    <div class="message-container">
        <?php
            while($result = $raw_result->fetch_assoc())
            {
                echo $result["message_content"] . "<br>";
                echo "-". $result["message_sender"] . "<br>";
                echo"<br>";
            }
        ?>
    </div>

    <form method="POST" action="chatting-app/post-message.php">
        <input name="message" placeholder="Enter your message here..." required>
        <button>Send message</button>
    </form>
    
    <br>
    <a href="/chatting-app/logout.php">Log Out</a>

    <style>
        .message-container{
            width: 300px;
            height: 400px;
            border: 2px solid black;
            margin-bottom: 20px;
            overflow-y: scroll;
        }
    </style>
</body>
</html>
