<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Impact</title>
    <?php include('./includes/boot-head.php')?>
</head>
<body>
<?php 
include('./includes/nav.php');
//Get user data
//start session to get userID
session_start();
//connect to db
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$userID = $_SESSION['userID'];

$userDonations = "SELECT m.materialName, SUM(t.quantity) AS totalQuantity
FROM materials AS m
JOIN manufacturers AS ma ON ma.manufacturerID = m.manufacturerID
JOIN transactions AS t ON t.materialID = m.materialID
JOIN user_transaction AS ut ON t.transactionID = ut.transactionID
JOIN users AS u ON u.userID = ut.userID
WHERE u.userID = $userID
GROUP BY m.materialName
ORDER BY totalQuantity DESC";

$result = $conn->query($userDonations);

//store in an array to convert to json
$data = array();
while($row = $result->fetch_assoc()){
    $data[] = array(
        'materialName'=> $row['materialName'],
        // 'materialName' => $row['materialName'],
        'totalQuantity' => $row['totalQuantity']
    );
}
//convert to json
$jsonResult = json_encode($data);

$userDonationsOverTime = "SELECT t.quantity, t.transactionDate
FROM materials AS m
JOIN manufacturers AS ma ON ma.manufacturerID = m.manufacturerID
JOIN transactions AS t ON t.materialID = m.materialID
JOIN user_transaction AS ut ON t.transactionID = ut.transactionID
JOIN users AS u ON u.userID = ut.userID
WHERE u.userID = $userID
order by t.transactionDate";

$resultUser = $conn->query($userDonationsOverTime);

//store in an array to convert to json
$userDon = array();
while($row = $resultUser->fetch_assoc()){
    $userDon[] = array(
        'transactionDate' => $row['transactionDate'],
        'quantity'=> (int)$row['quantity']
    );
}
//convert to json
$jsonUserDon = json_encode($userDon);



//all donations, so you can compare yourself
$allDonations = "SELECT sum(quantity) as quantity, transactionDate
FROM transactions
GROUP BY transactionDate
order by transactionDate";

$allResult = $conn->query($allDonations);

//store in an array to convert to json
$allDon = array();
while($row = $allResult->fetch_assoc()){
    $allDon[] = array(
        'transactionDate' => $row['transactionDate'],
        'quantity'=> (int)$row['quantity']
    );
}
//convert to json
$jsonAllDon = json_encode($allDon);


$yourDonations = "select sum(m.quantity) as user_quantity
from materials as m
join transactions as t on t.materialID=m.materialID
join user_transaction as ut on ut.transactionID=t.transactionID
join users as u on ut.userID=u.userID
where u.userID=$userID";


$resultAvg = $conn->query($yourDonations);

//store in an array to convert to json
$yourAvg = array();
while($row = $resultAvg->fetch_assoc()){
    $yourAvg[] = array(
        'uQuantity'=> $row['user_quantity']
    );
}
//convert to json
$jsonYourAvg = json_encode($yourAvg);


$avgDonations = "SELECT AVG(averageTextilesDonated) AS overallAverage
FROM (
    SELECT u.userID, AVG(t.quantity) AS averageTextilesDonated
    FROM transactions AS t
    JOIN user_transaction AS ut ON t.transactionID = ut.transactionID
    JOIN users AS u ON u.userID = ut.userID
    WHERE u.usertype = 'individual_user'
    GROUP BY u.userID
) AS userAverages";


$resultAllAvg = $conn->query($avgDonations);

//store in an array to convert to json
$allAvg = array();
while($row = $resultAllAvg->fetch_assoc()){
    $allAvg[] = array(
        'allQuantity'=> $row['overallAverage']
    );
}
//convert to json
$jsonAllAvg = json_encode($allAvg);


//close conn
$conn->close();
?>


<div class="container">
<!-- total materials recycled -->
<div style="width: 800px;"><canvas id="chart-space"></canvas></div>

<!-- mixed line/bar chart -->
<div style="width: 800px;"><canvas id="mixed-chart"></canvas></div>


<select id="yearSelector">
    <option value="">Select Year</option>
<?php 
//connect to db
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//select each year 
$getYear = "SELECT DISTINCT Year(t.transactionDate) as transYear from transactions as t join user_transaction as ut on ut.transactionID=t.transactionID join users as u on u.userID=ut.userID where u.userID=$userID order by transYear";
$yearResult = $conn->query($getYear);
//add results to dropdown
while($row = $yearResult->fetch_assoc()){
    echo '<option value=' . $row['transYear'] . '>' . $row['transYear'] . '</option>';
}
//close conn
$conn->close();
?>

</select>

<div><canvas id="compare-bar"></canvas></div>

</div>



<!-- Link to charts.js extension -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Link to js chart functions -->
<script type="module" src="js/charts.js"></script>
<!-- Year dropdown -->
<script type="module" src="js/year-filter.js"></script>


<!-- render charts -->
<script type="module">
    //amt of materials donated
    import { createHorizontalBarChart } from './js/charts.js';
    var dataFromPHP = <?php echo $jsonResult; ?>;
    createHorizontalBarChart(dataFromPHP.map(entry => entry.materialName), dataFromPHP.map(entry => entry.totalQuantity), 'chart-space');

    
    import {mixedChart} from './js/charts.js';
        //get chart values
    var mixedUser = <?php echo $jsonUserDon; ?>;
    var mixedAll = <?php echo $jsonAllDon; ?>;
    
    mixedChart(mixedAll.map(entry => entry.transactionDate), mixedUser.map(entry => ({ x: entry.transactionDate, y: entry.quantity })), 
            mixedAll.map(entry => ({ x: entry.transactionDate, y: entry.quantity })), 
            "Your donations", "All donations");


    //YEAR DROPDOWN SELECTOR
    document.getElementById('yearSelector').addEventListener('change', function () {
        //grab the selected year
        const selectedYear = this.value;
        
        if (selectedYear !== "") {
            // Filter data based on the selected year
            const filteredMixedUser = mixedUser.filter(entry => entry.transactionDate.startsWith(selectedYear));
            const filteredMixedAll = mixedAll.filter(entry => entry.transactionDate.startsWith(selectedYear));

            mixedChart(filteredMixedAll.map(entry => entry.transactionDate), filteredMixedUser.map(entry => ({ x: entry.transactionDate, y: entry.quantity })), 
            filteredMixedAll.map(entry => ({ x: entry.transactionDate, y: entry.quantity })), 
            "Your donations", "All donations");
        } else {
            mixedChart(mixedAll.map(entry => entry.transactionDate), mixedUser.map(entry => ({ x: entry.transactionDate, y: entry.quantity })), 
            mixedAll.map(entry => ({ x: entry.transactionDate, y: entry.quantity })), 
            "Your donations", "All donations");
        }
});



//COMPARE USERS TO OTHER USERS
import { regBar } from './js/charts.js';
var yourAvg = <?php echo $jsonYourAvg; ?>;
var allAvg = <?php echo $jsonAllAvg; ?>;


regBar(yourAvg.map(entry => entry.uQuantity), allAvg.map(entry => entry.allQuantity));



</script>

<!-- Footer and bootstrap documentation -->
<?php 
include('./includes/boot-script.php');
include('./includes/footer.php');
?>
</body>
</html>