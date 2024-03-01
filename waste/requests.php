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
if(isset($_SESSION['denied']) && $_SESSION['denied']){
    echo '<p style="color:red;"><strong>Request denied.</strong></p>';
    $_SESSION['denied']=false;
}


  //db connection
  $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

      //handle approve and deny buttons
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['acceptBtn'])) {
            // Code to handle the accept button click
            echo "Accept button clicked";
        } elseif (isset($_POST['denyBtn'])) {
            //get materialID
            $materialIDPost = $_POST['materialIDhidden'];
    
            //delete request from db
            $deleteRequest = "DELETE FROM requests WHERE materialID=$materialIDPost";
            
            //refresh the page to show changes
            $deleteResult = $conn->query($deleteRequest);
            if ($deleteResult){
                $_SESSION['denied']=true;
                header('Location: requests.php');
                exit();
            }
        }
    }

            //GET each request for this user
            $yourRequests = "select re.requestID, m.materialName, re.materialID, re.quantity, re.recyclerID, ma.manufacturerID, u.userID, r.companyName
            from requests as re
            join recyclers as r on r.companyID=re.recyclerID
            join materials as m on m.materialID=re.materialID
            join manufacturers as ma on ma.manufacturerID=m.manufacturerID
            join users as u on u.userID=ma.userID
            where u.userID=$manuUserID";

            $requestResult = $conn->query($yourRequests);

            if ($requestResult->num_rows != 0){
                while ($row_request = mysqli_fetch_assoc($requestResult)) {
                    //get request info
                    $material = $row_request['materialName'];
                    $quantity = $row_request['quantity'];
                    $recycler = $row_request['companyName'];
                    $matID = $row_request['materialID'];

                //echo each request
                echo '<div class="container"><div class="card">';
                echo '<div class="card-header">';
                echo 'Request from: <strong>' . $recycler . '</strong>';
                echo '</div><div class="card-body"><h5 class="card-title">';
                echo 'Material name: ' . $material . '</h5>';
                echo '<p class="card-text">Quantity: ' . $quantity . ' lbs</p>';
                echo '<form action="requests.php" method="post">';
                echo '<input type="hidden" name="materialIDhidden" value="' . $matID . '">';
                echo '<button type="submit" class="btn btn-success" name="acceptBtn">Accept</button>';
                echo '<button type="submit" class="btn btn-danger" name="denyBtn">Deny</button></form></div></div>';
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
    // include('../includes/footer.php');
    include('../includes/boot-script.php');
    ?>
</body>
</html>