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


$sql = "SELECT sum(t.quantity) as quantity, ma.companyName as company
from transactions as t
join materials as m on m.materialID = t.materialID
join user_transaction as ut on t.transactionID=ut.transactionID
join users as u on u.userID=ut.userID
join recyclers as r on r.userID=u.userID
join manufacturers as ma on ma.userID=u.userID
WHERE u.userID in (SELECT userID from user_transaction) AND u.usertype='manufacturer'
group by ma.manufacturerID
order by sum(t.quantity) DESC
limit 15";


$sqll = "SELECT sum(t.quantity) as quantity, r.companyName as company
from transactions as t
join materials as m on m.materialID = t.materialID
join user_transaction as ut on t.transactionID=ut.transactionID
join users as u on u.userID=ut.userID
join recyclers as r on r.userID=u.userID
join manufacturers as ma on ma.userID=u.userID
WHERE u.userID in (SELECT userID from user_transaction) AND u.usertype='recycler'
group by ma.manufacturerID
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

$sql3 = "SELECT m.materialName, sum(m.quantity) as quantity
from materials as m
join manufacturers as ma on ma.manufacturerID=m.manufacturerID
join users as u on u.userID=ma.userID
join user_transaction as ut on u.userID=ut.userID
where u.userID in (select userID from user_transaction)
group by m.materialName
order by (m.quantity)";

$result = $conn->query($sql);
$resultt = $conn->query($sqll);

$result2 = $conn->query($sql2);

$result3 = $conn->query($sql3);

$data = array();
while($row = $result->fetch_assoc()){
    $data[] = array(
        'quantity'=> $row['quantity'],
        // 'materialName' => $row['materialName'],
        'company' => $row['company']
    );
}

$jsonResult = json_encode($data);

$data1 = array();
while($row = $resultt->fetch_assoc()){
    $data1[] = array(
        'quantity'=> $row['quantity'],
        'company' => $row['company']
    );
}

$jsonResult1 = json_encode($data1);

$data2 = array();
while($row = $result2->fetch_assoc()){
    $data2[] = array(
        'transationDate' => $row['transactionDate'],
        'quantity'=> $row['quantity'],
        'materialName' => $row['materialName']
    );
}

$jsonResult2 = json_encode($data2);

$data3 = array();
while($row = $result3->fetch_assoc()){
    $data3[] = array(
        'materialName' => $row['materialName'],
        'quantity'=> $row['quantity'],
    );
}

$jsonResult3 = json_encode($data3);

$conn->close();
?>
        <!-- Horizontal bar chart -->
        
            <!--Manufacturer-->
        <div style="width: 800px;"><canvas id="chart-space"></canvas></div>
        
            <!--Recycler-->
        <div style="width: 800px;"><canvas id="chart-space1"></canvas></div>

        <!--Line chart -->
        <div class="chart-view">
            <canvas id="lineChartCanvas" width="573" height="286"
            style="display: block; box-sizing: border-box; height: 191px; width: 382px;"></canvas>
        </div>

        <!-- Pie chart -->
        <div style="width: 800px;"><canvas id="chart-pie"></canvas></div>



        <!-- Link to charts.js extension -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <!-- Link to js chart functions -->
        <script type="module" src="js/charts.js"></script>

<!-- Calling chart functions -->
<script type="module">
    //Horizontal bar chart manufacturers
    import { createHorizontalBarChart } from './js/charts.js';
    var dataFromPHP = <?php echo $jsonResult; ?>;
    createHorizontalBarChart(dataFromPHP.map(entry => entry.company), dataFromPHP.map(entry => entry.quantity), 'chart-space');

    //Horizontal bar chart recyclers 
    import { createHorizontalBarChart } from './js/charts.js';
    var dataFromPHP1 = <?php echo $jsonResult1; ?>;
    createHorizontalBarChart(dataFromPHP1.map(entry => entry.company), dataFromPHP.map(entry => entry.quantity), 'chart-space1');

    //Line chart
    import { createLine } from './js/charts.js';
    var dataFromPHP2 = <?php echo $jsonResult2; ?>;
    createLine(dataFromPHP2.map(entry => entry.quantity), dataFromPHP2.map(entry => entry.transationDate));

    //Pie chart
    import { createPieChart } from './js/charts.js';
    var dataFromPHP3 = <?php echo $jsonResult3; ?>;
    createPieChart(dataFromPHP3.map(entry => entry.quantity), dataFromPHP3.map(entry => entry.materialName));
</script>

</body>
</html>

