<?php session_start();
$userID = $_SESSION['userID'];

//db connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delReq'])){
    //vars so we can delete this entry from db
    $materialID = $_POST['materialID'];
    $recyclerID = $_POST['recyclerID'];
    $transactionID = $_POST['transID'];

    //delete material
    $delMaterial = "DELETE FROM materials where materialID=$materialID";
    $conn->query($delMaterial);

    //delete user transaction
    $deleteUT = "DELETE FROM user_transaction where userID=$userID AND transactionID=$transactionID";
    $conn->query($deleteUT);

    //delete from transaction table
    $delTransaction = "DELETE from transactions where transactionID=$transactionID";
    $conn->query($delTransaction);

    //reload page to reflect changes
    header('Location: user_request.php');
    exit();
}

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

<!-- Add to calendar button --> 
<script src="https://cdn.jsdelivr.net/npm/add-to-calendar-button@2" async defer></script>

<!-- CSS -->
<link rel="stylesheet" href="../css/styles.css">

</head>
<body>
<?php 
include('../includes/waste-nav.php');
if(isset($_SESSION['denied']) && $_SESSION['denied']){
    echo '<p style="color:red;"><strong>Request deleted.</strong></p>';
    $_SESSION['denied']=false;
}
?>
<div class="container px-4 mx-auto p-2">
    <h1 class="com">Your requests</h1>
    <p class="com">Delete requests you no longer want, and view your accepted requests.</p>
    <div class ="row">
<?php 
//DELETE REQUEST BUTTON
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteBtn'])) {
        $materialIDPost = $_POST['materialIDhidden'];
    
        //delete request from db
        $deleteRequest = "DELETE FROM transactions WHERE materialID=$materialIDPost";
        
        //refresh the page to show changes
        $deleteResult = $conn->query($deleteRequest);
        if ($deleteResult){
            $_SESSION['denied']=true;
            header('Location: user_request.php');
            exit();
        }
    }
  }

//////////////////////////PAGE CONTENT HERE /////////////////////////////

//ACCEPTED REQUESTS
$userAcceptedrequests = "select t.transactionID, DATE_FORMAT(t.transactionDate, '%M %e, %Y %l:%i %p') AS formatted_date, t.transactionDate, m.materialName, t.quantity
from transactions as t
join materials as m on m.materialID=t.materialID
join users as u on u.userID=m.userID
where m.userID=$userID AND t.status='Accepted'
order by t.transactionDate";

$userAcceptedResult = $conn->query($userAcceptedrequests);

//DISPLAY ACCEPTED REQUESTS
if ($userAcceptedResult->num_rows != 0){
    //Heading for accepted requests
    echo '<div class="col">
    <h3 class="com">Your accepted requests</h3>
    <p>View your accepted drop off requests, and the information you need to complete your drop off.</p>';

    while ($row_accepted = mysqli_fetch_assoc($userAcceptedResult)) {
        $transactionID = $row_accepted['transactionID'];
        $transDate = $row_accepted['formatted_date'];
        $materialName = $row_accepted['materialName'];
        $acceptQuantity = $row_accepted['quantity'];
        $transactionDateAccepted = $row_accepted['transactionDate'];

        $dateOnly = date("Y-m-d", strtotime($transactionDateAccepted));
        $timeOnly = date("H:i:s", strtotime($transactionDateAccepted));

        //get the information about the recycler based on transactionID
        $recyclerInfo = "select r.companyName, concat(r.cAddress, ', ', r.city, ', ', r.cState, ' ', r.zip, ', ', r.country) as recyAddress
        from recyclers as r
        join user_transaction as ut on ut.recyclerID=r.companyID
        where ut.transactionID=$transactionID";
        $recyclerInfoResult = $conn->query($recyclerInfo);

        //Display each accepted request and relevant info
        while ($recycler_row = mysqli_fetch_assoc($recyclerInfoResult)){
            $recyclerName = $recycler_row['companyName'];
            $recyAddress = $recycler_row['recyAddress'];

            //echo each request
            echo '<div class="grid-item">';
            echo '<h5>Request accepted by: ' . $recyclerName . '</h5>';
            echo '<p>Material name: ' . $materialName . '</p>
                <p>Quantity: ' . $acceptQuantity . ' lbs</p>
                <p>Recycler Name: ' . $recyclerName . '</p>
                <p>Address: ' . $recyAddress . '</p>
                <p>Drop off date and time: ' . $transDate . '</p>

                <add-to-calendar-button
                    name="Drop off: ' . $recyclerName . '"
                    options="\'Apple\',\'Google\', \'iCal\', \'Outlook.com\'"
                    location="' . $recyAddress . '"
                    startDate="' . $dateOnly . '"
                    endDate="' . $dateOnly . '"
                    startTime="' . $timeOnly . '"
                    endTime="' . $timeOnly . '"
                    timeZone="America/New_York">
                </add-to-calendar-button>

                </div>
                </div>';
        }     
}
}else{
    echo '<div class="col"><h3 class="com">Your accepted requests</h3>
    <p>View your accepted drop off requests, and the information you need to complete your drop off.</p>
    <p><strong>No accepted requests at this time. </strong></p>
    </div>';
}

//DISPLAY PENDING REQUESTS (allow user to delete them)
//PENDING REQUESTS
$userPendingrequests = "select t.transactionID, DATE_FORMAT(t.transactionDate, '%M %e, %Y %l:%i %p') AS formatted_date, m.materialName, t.quantity, m.materialID
from transactions as t
join materials as m on m.materialID=t.materialID
join users as u on u.userID=m.userID
where m.userID=$userID AND t.status='Pending'
order by t.transactionDate";

$userPendingResult = $conn->query($userPendingrequests);

//DISPLAY PENDING REQUESTS
if ($userPendingResult->num_rows != 0){
    //Heading for pending requests
    echo '<div class="col">
    <h3 class="com">Your pending requests</h3>
    <p>Find the details of your pending requests to recyclers, and delete drop off requests you no longer want.</p>';

    while ($row_pending = mysqli_fetch_assoc($userPendingResult)) {
        $transactionID = $row_pending['transactionID'];
        $transDate = $row_pending['formatted_date'];
        $materialName = $row_pending['materialName'];
        $acceptQuantity = $row_pending['quantity'];
        $materialID = $row_pending['materialID'];

        //get the information about the recycler based on transactionID
        $recyclerInfoPending = "select r.companyName, concat(r.cAddress, ', ', r.city, ', ', r.cState, ' ', r.zip, ', ', r.country) as recyAddress, r.companyID
        from recyclers as r
        join user_transaction as ut on ut.recyclerID=r.companyID
        where ut.transactionID=$transactionID";
        $recyclerPendingResult = $conn->query($recyclerInfoPending);

        //Display each accepted request and relevant info
        while ($recycler_pending = mysqli_fetch_assoc($recyclerPendingResult)){
            $recyclerName = $recycler_pending['companyName'];
            $recyAddress = $recycler_pending['recyAddress'];
            $recyclerID = $recycler_pending['companyID'];

            //echo each request
            echo '<div class="grid-item mb-3">
                <h5>Request to: ' . $recyclerName . '</h5>
                    <p>Material name: ' . $materialName . '</p>
                    <p>Quantity: ' . $acceptQuantity . ' lbs</p>
                    <p>Recycler Name: ' . $recyclerName . '</p>
                    <p>Address: ' . $recyAddress . '</p>
                    <p>Drop off date and time: ' . $transDate . '</p>
                <form method="post" action="user_request.php">
                <input type="hidden" name="transID" value="' . $transactionID . '">
                <input type="hidden" name="recyclerID" value="' . $recyclerID . '">
                <input type="hidden" name="materialID" value="' . $materialID . '">
                <button name="delReq" class="btn btn-danger">Delete request </button>
                </form>
                </div>';
        }    
}
}
else{
    echo '<div class="col"><h3 class="com">Your pending requests</h3>
    <p>Delete drop off requests you no longer want.</p>
    <p><strong>No pending requests at this time. </strong></p>
    </div>';
}


//close db
$conn->close();
?>

</div>
</div>

<?php 
    include('../includes/waste-footer.php');
    include('../includes/boot-script.php');
?>
</body>
</html>