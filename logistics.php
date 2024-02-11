<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <!-- JS --> 
    <!-- <script type="module" src="js/charts.js"></script> -->

    <!--CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include('includes/nav.php');?>

<?php
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }


$sql = "SELECT sum(t.quantity),
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
WHERE u.userID in (SELECT userID from user_transaction)
group by t.transactionID
order by sum(t.quantity) DESC
limit 15";

$sql2 = "SELECT t.transactionDate, sum(t.quantity) as quantity
from transactions as t
join user_transaction as ut on ut.transactionID=t.transactionID
join users as u on u.userID=ut.userID
join manufacturers as ma on ma.userID=u.userID
join materials as m on m.manufacturerID=ma.manufacturerID
group by t.transactionDate
order by t.transactionDate";

$result = $conn->query($sql);

$result2 = $conn->query($sql2);

$data = array();
while($row = $result->fetch_assoc()){
    $data[] = array(
        'quantity'=> $row['quantity'],
        // 'materialName' => $row['materialName'],
        'donator' => $row['donator']
    );
}

$jsonResult = json_encode($data);


$data2 = array();
while($row = $result2->fetch_assoc()){
    $data2[] = array(
        'transationDate' => $row['transactionDate'],
        'quantity'=> $row['quantity'],
        'materialName' => $row['materialName']
    );
}

$jsonResult2 = json_encode($data2);

$conn->close();
?>

        <!-- <div style="width: 500px;"><canvas id="dimensions"></canvas></div><br/> -->
        <div style="width: 800px;"><canvas id="chart-space"></canvas></div>


        <div class="chart-view">
            <canvas id="lineChartCanvas" width="573" height="286"
            style="display: block; box-sizing: border-box; height: 191px; width: 382px;"></canvas>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- <script type="module" src="dimensions.js"></script> -->
        <script type="module" src="js/charts.js"></script>


<script type="module">

    
    //Bar chart
    // import { createChart } from './js/charts.js';
    // var dataFromPHP = <?php echo $jsonResult; ?>;
    // createChart(dataFromPHP.map(entry => entry.donator), dataFromPHP.map(entry => entry.quantity));

    //Horizontal bar chart
    import { createHorizontalBarChart } from './js/charts.js';
    var dataFromPHP = <?php echo $jsonResult; ?>;
    createHorizontalBarChart(dataFromPHP.map(entry => entry.donator), dataFromPHP.map(entry => entry.quantity));

    //LINE CHART
    const dataFromPHP2 = <?php echo $jsonResult2; ?>;

    // Extract labels, quantities, and material names from the PHP data
    const labels2 = dataFromPHP2.map(entry => entry.transationDate);
    const quantities = dataFromPHP2.map(entry => entry.quantity);
    const materialName = dataFromPHP2.map(entry => entry.materialName);

    const dataa = {
        labels: labels2,
        datasets: [{
        label: 'lbs of materials donated',
        data: quantities,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
        }]
    };
    const lineChartConfig = {
    type: 'line',
    data: dataa,
    };

    const lineChartCanvas = document.getElementById('lineChartCanvas').getContext('2d');
    
    // Create the line chart
    new Chart(lineChartCanvas, lineChartConfig);

</script>

</body>
</html>

