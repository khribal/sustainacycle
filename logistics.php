<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts</title>
    <!-- JS --> 
    <script scr="js/charts.js"></script>
</head>
<body>
<?php include('includes/nav.php');?>

<?php
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }


$sql = "SELECT t.quantity, m.materialName,
CASE 
WHEN u.usertype='individual_user' THEN CONCAT(u.firstName, ' ', u.lastName)
WHEN u.usertype = 'recycler' THEN r.companyName
WHEN u.usertype= 'manufacturer' THEN ma.companyName
END AS donator
from transactions as t
join materials as m on m.materialID = t.materialID
join user_transaction as ut on t.transactionID=ut.transactionID
join users as u on u.userID=ut.userID
join recyclers as r on r.userID=u.userID
join manufacturers as ma on ma.userID=u.userID
order by t.quantity DESC
limit 15";

$result = $conn->query($sql);

$data = array();
while($row = $result->fetch_assoc()){
    $data[] = array(
        'quantity'=> $row['quantity'],
        'materialName' => $row['materialName'],
        'donator' => $row['donator']
    );
}

$jsonResult = json_encode($data);

$conn->close();
?>

        <!-- <div style="width: 500px;"><canvas id="dimensions"></canvas></div><br/> -->
        <div style="width: 800px;"><canvas id="chart-space"></canvas></div>

        <!-- <script type="module" src="dimensions.js"></script> -->
        <script type="module" src="charts.js"></script>

<script>
    var dataFromPHP = <?php echo $jsonResult; ?>;
    console.log(dataFromPHP);
    // initializeChart(dataFromPHP);
</script>

</body>
</html>

