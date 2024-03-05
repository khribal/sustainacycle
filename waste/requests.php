<?php session_start();
$manuUserID=$_SESSION['userID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Requests</title>
    <?php 
    include('../includes/boot-head.php');
    include('../includes/google-fonts.php');
    ?>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
</head>
<body>
<?php 
include('../includes/waste-nav.php');?>
<div class="container px-4 mx-auto p-2">
    <h1 class="com">Your requests</h1>
    <p class="com">Approve and deny requests from recyclers to pick up your waste.</p>

<?php
  //db connection
  $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

      //handle approve and deny buttons
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['acceptBtn'])) {
            // Code to handle the accept button click
            $materialID = $_POST['materialIDhidden'];
            
            //update request status 
            $updateReq = "UPDATE requests SET reqStatus='Accepted' WHERE materialID=$materialID";
            $conn->query($updateReq);

            //redirect to load changes
            header('Location: requests.php');
            exit();

        } elseif (isset($_POST['denyBtn'])) {
            //get materialID
            $materialIDPost = $_POST['materialIDhidden'];
    
            //delete request from db
            $deleteRequest = "DELETE FROM requests WHERE materialID=$materialIDPost";
            
            //echo alert to show changes
            $deleteResult = $conn->query($deleteRequest);
            if ($deleteResult){
                echo '<script>alert("Request denied!");</script>';
                // header('Location: requests.php');
                // exit();
            }
        }
    }

            //GET each request for this user
            $yourRequests = "select re.requestID, m.materialName, re.materialID, re.quantity, re.recyclerID, ma.manufacturerID, ma.companyName as 'manuCompany', u.userID, r.companyName, re.reqStatus
            from requests as re
            join recyclers as r on r.companyID=re.recyclerID
            join materials as m on m.materialID=re.materialID
            join users as u on u.userID=m.userID
            join manufacturers as ma on ma.userID=u.userID
            where u.userID=$manuUserID";

            $requestResult = $conn->query($yourRequests);

            if ($requestResult->num_rows != 0){
                while ($row_request = mysqli_fetch_assoc($requestResult)) {
                    //get request info
                    $material = $row_request['materialName'];
                    $quantity = $row_request['quantity'];
                    $recycler = $row_request['companyName'];
                    $matID = $row_request['materialID'];
                    $status = $row_request['reqStatus'];
                    $manuName = $row_request['manuCompany'];
                    $requestID = $row_request['requestID'];
                    
                    //IDS TO CHECK for CHAT
                    $recyclerID = $row_request['recyclerID'];
                    $manufacturerID = $row_request['manufacturerID'];

                    // check if the status is pending or accepted
                    if ($status=="Accepted"){
                        $isAccepted = true;
                    }
                    else{
                        $isAccepted = false;
                    }

                //echo each request
                echo '<div class="grid-item mb-3">';
                echo '<div>';
                echo '<h5>Request from: ' . $recycler . '</h5>';
                echo '</div><div><p>';
                echo 'Material name: <strong>' . $material . '</strong></p>';
                echo '<p>Quantity: <strong>' . $quantity . ' lbs</strong></p></div>';
                echo '<form action="requests.php" method="post">';
                if (!$isAccepted) {
                    // Show "Accept" and "Deny" buttons
                    echo '<input type="hidden" name="materialIDhidden" value="' . $matID . '">';
                    echo '<button type="submit" class="btn btn-success mr-3" name="acceptBtn">Accept</button>';
                    echo '<button type="submit" class="btn btn-danger" name="denyBtn">Deny</button>';
                } else {
                    // Check if the chat already exists
                    $checkChatQuery = "SELECT cm.chatID FROM chat_members as cm
                    JOIN chat as c ON c.chatID = cm.chatID
                    JOIN manufacturers as m ON m.manufacturerID = cm.manufacturerID
                    JOIN users as u ON u.userID = m.userID
                    JOIN requests as re on re.chatID=c.chatID
                    WHERE cm.recyclerID=$recyclerID AND cm.manufacturerID=$manufacturerID and re.materialID=$matID";
                    
                    $checkChatResult = $conn->query($checkChatQuery);
                
                    if ($checkChatResult->num_rows > 0) {
                        // Chat already exists, retrieve chatID
                        $chatIDRow = $checkChatResult->fetch_assoc();
                        $chatID = $chatIDRow['chatID'];
                    } else {
                        // Chat doesn't exist, create a new chat with and value for header, and retrieve chatID
                        $createChatQuery = "INSERT INTO chat (chatHead) VALUES ('$recycler and $manuName')";
                        $conn->query($createChatQuery);
                        $chatID = $conn->insert_id;
                        
                        //add this chatID to the request table
                        $updateRequest = "UPDATE requests SET chatID=$chatID WHERE requestID=$requestID";
                        $stmt = $conn->prepare($updateRequest);
                        $stmt->bind_param("ii", $chatID, $requestID);
                        $stmt->execute();
                        $stmt->close();
                        

                        //insert chat members
                        $createMembers = "INSERT INTO chat_members (chatID, recyclerID, manufacturerID) VALUES ($chatID, $recyclerID, $manufacturerID)";
                        $conn->query($createMembers);

                        // Retrieve the newly created chatID
                        date_default_timezone_set('America/New_York');

                        // Get the current timestamp
                        $currentTimestamp = time();

                        // Convert the timestamp to a formatted date with the correct timezone
                        $formattedDateTime = date('n-d-Y h:i A', $currentTimestamp);
                    }
                
                    // Redirect the user to the chat with the correct chatID
                    echo '<a href="chat.php?chatID=' . $chatID . '&time_stamp=' . $formattedDateTime . '&requestID=' . $requestID .'">';
                    echo '<button type="button" class="btn btn-primary">Go to Chat</button>';
                    echo '</a>';
                }
                echo '</form></div>';
            }
        }
            else{
                echo '<div"><strong>You do not have any requests yet.</strong></div>';
            }
        
//close db
$conn->close();
?>

</div>



<?php 
    include('../includes/waste-footer.php');
    include('../includes/boot-script.php');
    ?>
</body>
</html>