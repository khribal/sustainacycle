<?php session_start();
$recyID = $_SESSION['userID'];
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
if(isset($_SESSION['denied']) && $_SESSION['denied']){
    echo '<p style="color:red;"><strong>Request denied.</strong></p>';
    $_SESSION['denied']=false;
}
?>
<div class="container px-4 mx-auto p-2">
    <h1 class="com">Your requests</h1>
    <p class="com">Delete requests you no longer want.</p>

<?php 
  //db connection
  $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

//handle delete request button
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteBtn'])) {
        $materialIDPost = $_POST['materialIDhidden'];
    
        //delete request from db
        $deleteRequest = "DELETE FROM requests WHERE materialID=$materialIDPost";
        
        //refresh the page to show changes
        $deleteResult = $conn->query($deleteRequest);
        if ($deleteResult){
            $_SESSION['denied']=true;
            header('Location: recyrequests.php');
            exit();
        }
    }
  }

//get recyclerID
$recyclerIDquery = "SELECT companyID from recyclers where userID=$recyID";
$RecyclerResult = $conn->query($recyclerIDquery);
$recyclerData = $RecyclerResult->fetch_assoc();
//now have the recycler id
$recyclerID = $recyclerData['companyID'];


//GET each request for this user
$yourRequests = "select re.requestID, m.materialName, re.materialID, re.quantity, re.recyclerID, ma.manufacturerID, ma.companyName as 'manufacturerName', u.userID, r.companyName
from requests as re
join recyclers as r on r.companyID=re.recyclerID
join materials as m on m.materialID=re.materialID
join manufacturers as ma on ma.manufacturerID=m.manufacturerID
join users as u on u.userID=ma.userID
where re.recyclerID=$recyclerID";

$requestResult = $conn->query($yourRequests);

if ($requestResult->num_rows != 0){
    while ($row_request = mysqli_fetch_assoc($requestResult)) {
        //get request info
        $material = $row_request['materialName'];
        $quantity = $row_request['quantity'];
        $manufacturer = $row_request['manufacturerName'];
        $matID = $row_request['materialID'];

    //echo each request
    echo '<div class="card mb-3">';
    echo '<div class="card-header">';
    echo 'Request to: <strong>' . $manufacturer . '</strong>';
    echo '</div><div class="card-body"><h5 class="card-title">';
    echo 'Material name: ' . $material . '</h5>';
    echo '<p class="card-text">Quantity: ' . $quantity . ' lbs</p>';
    echo '<form action="recyrequests.php" method="post">';
    echo '<input type="hidden" name="materialIDhidden" value="' . $matID . '">';
    echo '<button type="submit" class="btn btn-danger" name="deleteBtn">Delete request</button></form></div>';
    }
}
else{
    echo '<div><strong>You have not made any requests yet.</strong></div>';
}

//close db
$conn->close();
?>

</div>

<?php 
include('../includes/footer.php');
include('../includes/boot-script.php');
?>
</body>
</html>