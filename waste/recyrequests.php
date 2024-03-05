<?php session_start();
$recyID = $_SESSION['userID'];

//db connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['acptUserReq'])){
        $transactionID = $_POST['transactionID'];
        $updateTransaction = "UPDATE transactions SET status='Accepted' WHERE transactionID=$transactionID";
        $updateTransResult = $conn->query($updateTransaction);

        //refresh the page so changes are reflected
        header('Location: recyrequests.php');
        exit();
    }
    elseif(isset($_POST['denyUserReq'])){
        $transactionID = $_POST['transactionID'];
        $usersID = $_POST['userID'];

        //delete from user_transaction table
        $deleteUserTrans = "DELETE from user_transaction WHERE userID=$usersID AND recyclerID=$recyclerID AND transactionID=$transactionID";
        $conn->query($deleteUserTrans);

        //delete transaction from transaction table
        $deleteTransaction = "DELETE from transactions where transactionID=$transactionID";
        $conn->query($deleteTransaction);

        //reload page to reflect changes
        header('Location: recyrequests.php');
        exit();
    }
    elseif(isset($_POST['markComplete'])){
        $transactionID = $_POST['transactionID'];
        $updateTransactionStatus = "UPDATE transactions SET status='Completed' WHERE transactionID=$transactionID";
        $updateTransStatResult = $conn->query($updateTransactionStatus);
        
        //refresh page to show changes
        header('Location: recyrequests.php');
        exit();
    }
}

//close db
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<?php 
include('../includes/boot-head.php');
include('../includes/google-fonts.php');
?>

<!-- CSS -->
<link rel="stylesheet" href="../css/styles.css">

</head>
<body>
<?php 
include('../includes/waste-nav.php');
?>
<div class="container px-4 mx-auto p-2">
    <h1 class="com">Your requests</h1>
    <p class="com">Delete requests you no longer want, and chat with the manufacturers who have accepted your request for materials.</p>
    <div class ="row">

<?php 
  //db connection
  $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

//DELETE REQUEST BUTTON
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteBtn'])) {
        $materialIDPost = $_POST['materialIDhidden'];
    
        //delete request from db
        $deleteRequest = "DELETE FROM requests WHERE materialID=$materialIDPost";
        
        //refresh the page to show changes
        $deleteResult = $conn->query($deleteRequest);
        if ($deleteResult){
            echo '<script>alert("Request successfully deleted.");</script>';

        }
    }
  }

//get their recyclerID
$recyclerIDquery = "SELECT companyID from recyclers where userID=$recyID";
$RecyclerResult = $conn->query($recyclerIDquery);
$recyclerData = $RecyclerResult->fetch_assoc();
//now have the recycler id
$recyclerID = $recyclerData['companyID'];


//////////////////////////PAGE CONTENT HERE /////////////////////////////

//ACCEPTED REQUESTS so the user can access the chat
$recylersAcceptedRequests = "select re.requestID, m.materialName, re.materialID, re.quantity, re.recyclerID, ma.manufacturerID, ma.companyName as 'manufacturerName', u.userID, r.companyName, re.reqStatus
from requests as re
join recyclers as r on r.companyID=re.recyclerID
join materials as m on m.materialID=re.materialID
join users as u on u.userID=m.userID
join manufacturers as ma on ma.userID=u.userID
where re.recyclerID=$recyclerID AND re.reqStatus='Accepted'";

$acceptedResult = $conn->query($recylersAcceptedRequests);

//DISPLAY ACCEPTED REQUESTS & CHAT BUTTON
if ($acceptedResult->num_rows != 0){
    //Heading for accepted requests
    echo '<div class="col">
            <h3 class="com">Your accepted requests</h3>
            <p>Chat with the manufacturers who accepted your material request to complete your transaction.</p>
            ';

    while ($row_accepted = mysqli_fetch_assoc($acceptedResult)) {

        $manufacturerName = $row_accepted['manufacturerName'];
        $materialName = $row_accepted['materialName'];
        $acceptedQuantity = $row_accepted['quantity'];
        $requestID = $row_accepted['requestID'];
        $recycler = $row_accepted['companyName'];
        $matID = $row_accepted['materialID'];
        //manufacturer and recycler ids 
        $manufacturerID = $row_accepted['manufacturerID'];
        $recyclerID = $row_accepted['recyclerID'];

            //echo each request
            echo '<div class="grid-item mb-3">';
            echo '<h5>Request accepted by: ' . $manufacturerName . '</h5>';
            echo '<p> Material name: ' . $materialName . '</p>';
            echo '<p>Quantity: ' . $acceptedQuantity . ' lbs</p>';
            echo '<form action="requests.php" method="post">';
                
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
                $createChatQuery = "INSERT INTO chat (chatHead) VALUES ('$recycler and $manufacturerName')";
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
            echo '</a></form></div>';
        }
        //close the col
        echo '</div>';
}else{
    echo '<div class="col">
    <h3 class="com">Your accepted requests</h3>
    <p> You do not have any accepted requests yet. </p></div>';
}


//USER REQUESTS TO RECYCLER
$userRequests = "SELECT t.transactionDate, t.transactionID, ut.recyclerID, t.quantity, m.materialName, m.materialID, u.firstName, t.status, u.userID
from transactions as t
join user_transaction as ut on ut.transactionID=t.transactionID
join materials as m on m.materialID=t.materialID
join users as u on u.userID=m.userID
where ut.recyclerID=$recyclerID AND t.status <> 'Completed'";


//requests by indiv users to this recycler
$userRequestsResults = $conn->query($userRequests);

echo '<div class="col">
        <h3 class="com">Drop off Requests</h3>
        <p>Requests from individuals to drop off their textile waste to your facility.</p>
    <div class="grid-container">';
while ($row_userReq = mysqli_fetch_assoc($userRequestsResults)) {
    //assign values to vars
    $userName = $row_userReq['firstName'];
    $transDate = $row_userReq['transactionDate'];
    $transID = $row_userReq['transactionID'];
    $materialName = $row_userReq['materialName'];
    $materialID = $row_userReq['materialID'];
    $quantity = $row_userReq['quantity'];
    $transStatus = $row_userReq['status'];
    $reqUserID = $row_userReq['userID'];

    //Each user request
    echo '<form method="post" action="recyrequests.php"><div class="grid-item">
            <h5><strong>Request from:</strong> ' . $userName . '</h5>
            <p><strong>Material:</strong> ' . $materialName . '</p>
            <p><strong>Quantity:</strong> ' . $quantity . ' lbs</p>
            <p><strong>Requested dropoff date and time:</strong> ' . $transDate . '</p>
            <input type="hidden" name="transactionID" value="' . $transID . '">
            <input type="hidden" name="userID" value="' . $reqUserID . '">';
            //Echo either the accept/deny buttons, or mark as completed
            if ($transStatus === 'Accepted') {
                echo '<div><button type="submit" class="btn btn-info" name="markComplete">Mark Transaction as Complete</button></div>';
            } elseif ($transStatus === 'Pending') {
                echo '<div><button type="submit" class="btn btn-success mr-3" name="acptUserReq">Accept</button><button type="submit" name="denyUserReq" class="btn btn-danger">Deny</button></div>';
            }
        echo '</div></form>';
}

echo "</div></div>";



//GET each PENDING REQUEST for this user
$yourRequests = "select re.requestID, m.materialName, re.materialID, re.quantity, re.recyclerID, ma.manufacturerID, ma.companyName as 'manufacturerName', u.userID, r.companyName, re.reqStatus
from requests as re
join recyclers as r on r.companyID=re.recyclerID
join materials as m on m.materialID=re.materialID
join users as u on u.userID=m.userID
join manufacturers as ma on ma.userID=u.userID
where re.recyclerID=$recyclerID AND re.reqStatus='Pending'";

$requestResult = $conn->query($yourRequests);

if ($requestResult->num_rows != 0){
    //Heading for pending requests
    echo '<div class="col"><h3 class="com">Pending requests</h3>
    <p>Your requests that are still awaiting approval from the manufacturer.</p>';
    
    while ($row_request = mysqli_fetch_assoc($requestResult)) {
        //get request info
        $material = $row_request['materialName'];
        $quantity = $row_request['quantity'];
        $manufacturer = $row_request['manufacturerName'];
        $matID = $row_request['materialID'];
        $requestID = $row_request['requestID'];
    
    //echo each request
    echo '<div class="card mb-3">';
    echo '<div class="card-header">';
    echo 'Request to: <strong>' . $manufacturer . '</strong>';
    echo '</div><div class="card-body"><h5 class="card-title">';
    echo 'Material name: ' . $material . '</h5>';
    echo '<p class="card-text">Quantity: ' . $quantity . ' lbs</p>';
    echo '<form action="recyrequests.php" method="post">';
    echo '<input type="hidden" name="materialIDhidden" value="' . $matID . '">';
    echo '<button type="submit" class="btn btn-danger" name="deleteBtn">Delete request</button></form></div></div>';
    }
}
else{
    echo '<div class="col">
    <h3 class="com">Your pending requests</h3>
    <p>You have no pending requests.</p>
    </div>';
}


?>

</div>
</div>

<?php 
    include('../includes/waste-footer.php');
    include('../includes/boot-script.php');
?>
</body>
</html>