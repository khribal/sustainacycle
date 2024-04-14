<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Impact</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <?php 
        include('./includes/boot-head.php');
        include('./includes/google-fonts.php');
    ?>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
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

//get session vars
$userID = $_SESSION['userID'];
$usertype = $_SESSION['usertype'];

$userDonations = "SELECT m.materialName, SUM(t.quantity) AS totalQuantity
FROM materials AS m
JOIN transactions AS t ON t.materialID = m.materialID
JOIN user_transaction AS ut ON t.transactionID = ut.transactionID
JOIN users AS u ON u.userID = ut.userID
WHERE u.userID = $userID AND t.status='Completed'
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

$userDonationsOverTime = "SELECT t.quantity, DATE_FORMAT(t.transactionDate, '%c-%d-%Y') as transactionDate
FROM materials AS m
JOIN transactions AS t ON t.materialID = m.materialID
JOIN user_transaction AS ut ON t.transactionID = ut.transactionID
JOIN users AS u ON u.userID = ut.userID
WHERE u.userID = $userID AND t.status='Completed'
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
$allDonations = "SELECT sum(quantity) as quantity, DATE_FORMAT(transactionDate, '%c-%d-%Y') as formattedDate
FROM transactions
where status = 'Completed'
GROUP BY transactionDate
order by transactionDate";

$allResult = $conn->query($allDonations);

//store in an array to convert to json
$allDon = array();
while($row = $allResult->fetch_assoc()){
    $allDon[] = array(
        'transactionDate' => $row['formattedDate'],
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
where u.userID=$userID AND t.status='Completed'";


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
    WHERE u.usertype= '$usertype' AND t.status='Completed'
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

//find sum of total donations completed!
$totalDonations = "SELECT sum(quantity) as quantity from transactions where status='Completed'";
$totalDonResult = $conn -> query($totalDonations);

$totalDon = array();
while ($row = $totalDonResult->fetch_assoc()){
    $totalDon[] = array(
        'allDonations' => $row['quantity']
    );
}

//convert to json
$jsonTotalDonations = json_encode($totalDon);

//close conn
$conn->close();
?>

<!--Chart container -->
<div class="container mx-auto">
  <h4 class="com">Your Impact</h4>
  <p class="impact-lead">Explore our visual overview showcasing the transformative journey of your textile donations. We bridge manufacturers, users, and recycling centers, creating a circular fashion ecosystem. Dive into the graphs below to witness the collective impact on sustainability.
</p>

<div class="container">
  <div class="row align-items-start">
    <div class="col">
    <!-- total materials -->
        <h5 class="impact">Total Textiles Recycled</h5>
        <p class="impact">This horizontal bar chart illustrates the pounds of textiles recycled for each material category, showcasing your overall impact.</p>
    <canvas id="chart-space"></canvas>
    </div>
    <div class="col">
        <h5 class="impact">Textile Donations Over Time</h5>
        <p class="impact">Track the progression of your textile donations alongside the overall donations over time. The chart combines a bar graph for each donation and a line graph for the cumulative total, providing a comprehensive view.</p>
    <canvas id="mixed-chart"></canvas>
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
    </div>
  </div>

<div class="row">
    <div class="col">
    <h5 class="impact">Comparison of Your Donations</h5>
        <p class="impact">Compare your individual textile donations with the average donations made by other users. This vertical bar chart helps you understand how your efforts align with the broader community.</p>
        <canvas id="compare-bar"></canvas>
    </div>
    <div class="col-6">
    <h5 class="impact">Distribution of Textile Donations</h5>
        <p class="impact">Explore the composition of textile donations with this pie chart. It illustrates the proportion of your contributions compared to the total donations, offering a visual representation of your impact within the larger context.</p>
        <div class="container mt-0">
            <canvas id="pie-canvas"></canvas>
        </div>

    </div>
</div>
        


        
        
</div>



<!-- Link to charts.js extension -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Link to js chart functions -->
<script type="module" src="js/charts.js"></script>
<!-- Year dropdown -->



<!-- render charts -->
<script type="module">
    //import necessary charts
    import { createHorizontalBarChart, mixedChart, vertBarSpecific, createPieChart } from './js/charts.js';


    //Your Amount Donated Chart
    var dataFromPHP = <?php echo $jsonResult; ?>;
    // Check if dataFromPHP is null
    if (dataFromPHP === null || dataFromPHP.length === 0) {
        // If null, display a message on the chart canvas
        const chartCanvas1 = document.getElementById('chart-space');
        const messageDiv1 = document.createElement('div');
        messageDiv1.innerHTML = '<p class="impact-no"><strong>No information to display yet.</strong></p>';
        chartCanvas1.parentNode.replaceChild(messageDiv1, chartCanvas1);

    } else {
    createHorizontalBarChart(dataFromPHP.map(entry => entry.materialName), dataFromPHP.map(entry => entry.totalQuantity), 'chart-space', 'chart-space1', 'rgba(113, 188, 120, 0.3)', 'rgba(113, 188, 120, 1)');
    }
    //Mixed Chart
    var mixedUser = <?php echo $jsonUserDon; ?>;
    var mixedAll = <?php echo $jsonAllDon; ?>;
    
    if (mixedUser === null || mixedUser.length === 0) {
        var yearBut = document.getElementById('yearSelector');
        // Hide the year selector button
        yearBut.style.display = 'none';

        // If null, display a message on the chart canvas
        const chartCanvas = document.getElementById('mixed-chart');
        const messageDiv = document.createElement('div');
        messageDiv.innerHTML = '<p class="impact-no"><strong>No information to display yet.</strong></p>';
        chartCanvas.parentNode.replaceChild(messageDiv, chartCanvas);

    } else {
            var yearBut = document.getElementById('yearSelector');
            // Show the year selector button
            yearBut.style.display = 'block';
            
            mixedChart(mixedAll.map(entry => entry.transactionDate), mixedUser.map(entry => ({ x: entry.transactionDate, y: entry.quantity })), 
            mixedAll.map(entry => ({ x: entry.transactionDate, y: entry.quantity })), 
            "Your donations (lbs)", "All donations (lbs)");


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
}


//COMPARE USERS TO OTHER USERS, bar chart
var yourAvg = <?php echo $jsonYourAvg; ?>;
var allAvg = <?php echo $jsonAllAvg; ?>;

var userType
if ('<?php echo $usertype ?>' === 'individual_user'){
    userType = 'individual users';
}
else{
    userType = 'manufacturers';
}

vertBarSpecific("Your donations", "Avg donations by other " + userType, yourAvg.map(entry => entry.uQuantity), allAvg.map(entry => entry.allQuantity), 'compare-bar');


//Pie chart, your total compared to whole total
var allTotal = <?php echo $jsonTotalDonations; ?>;
createPieChart(yourAvg.map(entry => entry.uQuantity), allTotal.map(entry => entry.allDonations), "pie-canvas");
</script>



<!-- Footer and bootstrap documentation -->
<?php 
include('./includes/boot-script.php');
include('./includes/footer.php');
?>
</body>
</html>