<?php 
ob_start(); // Start output buffering
session_start(); 
$userID = $_SESSION['userID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <?php include('../includes/boot-head.php'); 
    include('../includes/google-fonts.php');?>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <title>Add Waste</title>

<!-- CSS FOR MESSAGE SYSTEM, HAVING ISSUES LINKING THE STYLES -->
<style>
.container-messages {
    display: flex;
    flex-direction: column;
}

.message-container {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 10px;
    max-width: 70%;
    word-wrap: break-word;
}

.user-message {
    background-color: #7ac5cd;
    align-self: flex-end;
}

.other-user-message {
    background-color: #d3d3d3;
    align-self: flex-start;
}
</style>

</head>
<body>
<?php 
include('../includes/waste-nav.php'); 
?>

<div class="container px-4 mx-auto p-2">
    <?php 
    if ($_SESSION['usertype'] == 'recycler'){
        echo '<a href="recyrequests.php">Go back to requests</a>';
    }else{
        echo '<a href="requests.php">Go back to requests</a>';
    }
    
    ?>
</div>


<?php
//connect to the database
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}


if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET['chatID'])){
        if (isset($_GET['time_stamp'])){
            //worry about the time stamps later!!!!!!!!!

            // date_default_timezone_set('America/New_York');
            // $timestamp = time();
            // $formattedDateTime = date('Y-n-d h:i A', $timestamp);
            // echo $formattedDateTime;

        }


        $chatID = $_GET['chatID'];
        //grab the heading for this chat
        $getChats = "SELECT * from chat WHERE chatID=$chatID";
        $chatResults = $conn->query($getChats);
        $chatMessages = $chatResults->fetch_assoc();
        
        //grab chat messages
        $getChatInfo = "SELECT cc.message_content, cc.time_stamp, u.firstName, u.userID
        from chat_content as cc
        join users as u on u.userID=cc.userID
        WHERE chatID=$chatID
        ORDER BY cc.time_stamp;";
        
        $getChatInfoResults = $conn->query($getChatInfo);


        echo '<div class="container px-4 mx-auto p-2"><h3>' . $chatMessages['chatHead'] . '</h3><div class="grid-item container-messages">';
        while ($message = $getChatInfoResults->fetch_assoc()) {
            $formattedDateTime = date('n-d-Y h:i A', strtotime($message['time_stamp']));
            
            //check which user sent message to assign classes
            $isCurrentUser = ($message['userID'] == $userID);
            $messageClass = $isCurrentUser ? 'user-message' : 'other-user-message';


            // Display each message with timestamp
            echo '<div class="message-container ' . $messageClass . '">';
            echo '<strong>' . $message['firstName'] . '</strong>: ' . $message['message_content'];
            echo '<br>';
            echo 'Sent: ' . $formattedDateTime;
            echo '</div>';
        }
        //close "container-message" class
        echo '</div>';

        // Add input field and send button
        echo '<form method="post" action="chat.php">
        <input type="text" name=messageInput class="form-control message-input" placeholder="Type your message...">
        <input type="hidden" name="chatID" value="' . $chatID . '">';
        echo '<button type="submit" class="btn btn-primary send-button">Send</button></form>';

        //Add mark this transaction as complete
        if ($_SESSION['usertype'] == 'recycler'){
            echo '<div class="grid-item p-2 mt-5"><form method="post" action="chat.php">
            <h5> Mark as completed </h5>
            <p>Mark this transaction as completed, waste has successfully been sent to the recycler. This will end your chat.</p>
            <input type="hidden" name="chatID" value="' . $chatID . '">
            <button type="submit" class="btn btn-success" name="markCompletedBtn">Transaction completed</button>
            </form></div>';
        }
        

    }
}//RECYCLER MARKED TRANSACTION AS COMPLETE
elseif($_SERVER["REQUEST_METHOD"] == "POST"){
 if(isset($_POST['markCompletedBtn'])){
    $chatID = $_POST['chatID'];
    $currentTime = time();
    $currentTimeFormatted = date('Y-m-d H:i:s', $currentTime);

    // Update request status to "Completed"
    $updateRequestStatus = "UPDATE requests SET reqStatus='Completed' WHERE chatID=$chatID";
    //binding as integer
    $stmt = $conn->prepare($updateRequestStatus);
    $stmt->bind_param("i", $chatIDPost);
    $stmt->execute();
    $stmt->close();

    //update completion time
    $updateRequestTime = "UPDATE requests SET completionDate='$currentTimeFormatted' WHERE chatID=$chatID";
    $stment = $conn->prepare($updateRequestTime);
    $stment->execute();
    $stment->close();

    // Delete chat content records
    $deleteChatContent = "DELETE FROM chat_content WHERE chatID=$chatID";
    $conn->query($deleteChatContent);

    // Delete chat members record
    $deleteChatMembers = "DELETE FROM chat_members WHERE chatID=$chatID";
    $conn->query($deleteChatMembers);

    // Delete chat record
    $deleteChat = "DELETE FROM chat WHERE chatID=$chatID";
    $conn->query($deleteChat);

    // Redirect to avoid resubmission on page refresh
    if($_SESSION['usertype'] == 'recycler'){
        header("Location: recyrequests.php");
        exit();
    }
    else{
        header("Location: requests.php");
        exit();
    }
 }
 else{
    //add new message to database
    $messageContent = $_POST['messageInput'];
    $chatIDPost = $_POST['chatID'];

    //get the current time
        date_default_timezone_set('America/New_York');
        $timestamp = time();
        $formattedDateTime = date('Y-m-d H:i:s', $timestamp);

    //insert this message into the db
    $insertNewMessage = "INSERT INTO chat_content (chatID, message_content, userID, time_stamp) VALUES ($chatIDPost, '$messageContent', $userID, '$formattedDateTime')";
    
    if($conn->query($insertNewMessage) == TRUE){
        //reload the page to reflect new chats
        header("Location: chat.php?chatID=$chatIDPost");
        exit();
    }else {
        echo "Error: " . $insertNewMessage . "<br>" . $conn->error;
    }

 } 
}

//close conn
$conn->close();
?>

</div>

<!-- Footer, bootstrap --> 
<?php 
    include('../includes/boot-script.php'); 
    include('../includes/waste-footer.php');
?>


<?php ob_end_flush(); // Flush the output buffer and send it to the browser ?>

</body>
</html>