<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

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


$sql = "SELECT sum(t.quantity) as quantity, ma.companyName as manufacturer
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


$sqll = "SELECT sum(t.quantity) as quantity, r.companyName as recycler
from transactions as t
join materials as m on m.materialID = t.materialID
join user_transaction as ut on t.transactionID=ut.transactionID
join users as u on u.userID=ut.userID
join recyclers as r on r.userID=u.userID
join manufacturers as ma on ma.userID=u.userID
WHERE u.userID in (SELECT userID from user_transaction) AND u.usertype='recycler'
group by r.companyID
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
        'manufacturer' => $row['manufacturer']
    );
}

$jsonResult = json_encode($data);

$data1 = array();
while($row = $resultt->fetch_assoc()){
    $data1[] = array(
        'quantity'=> $row['quantity'],
        'recycler' => $row['recycler']
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

<div>
<div class="heading">
    <h1>Textile Recycling Logistics Overview</h1>
    <p>Welcome to our Textile Recycling Logistics Overview page, where we provide a comprehensive view of the journey your textile donations take within our recycling ecosystem. Explore detailed graphs and insightful data visualizations showcasing manufacturers' generous contributions, recyclers' acceptance of various textile quantities, the evolving pattern of donations over time, and a breakdown of the types of textiles generously given by our community. Gain valuable insights into the impact of textile recycling on sustainability and contribute to a greener, more eco-friendly future. Join us on this visual journey through the logistics of textile recycling, illustrating the positive influence each donation makes in our collective effort to promote environmental responsibility.</p>
</div class="container-charts">

        <!-- Horizontal bar chart -->
        
            <div class=horiz-parent>
                    <!--Manufacturer-->
                <div class="horiz-chart">
                    <h2>Manufacturer Donated Textiles</h2>
                    <p>Here you will find some of the manufacturers who have donated textiles, ranked by those who donated the most according to our database.</p>
                    <div style="width: 800px;"><canvas id="chart-space"></canvas></div>
                </div>
                    <!--Recycler-->
                    <div class="horiz-chart">
                    <h2>Recycler Accepted Textiles</h2>
                    <p>Here you will find some of the recyclers who have accepted textiles, ranked by those who accepted the most according to our database.</p>
                    <div style="width: 800px;"><canvas id="chart-space1"></canvas></div>
                    </div>
            </div>
        <!--Line chart -->
        <div class="line-parent">
            <h2>Textiles recycled over time</h2>
            <p>Below is a graph of the quantities of textiles recycled, per the data we have kept historically.</p>
            <div class="chart-view">
                <canvas id="lineChartCanvas" width="573" height="286"
                style="display: block; box-sizing: border-box; height: 191px; width: 382px;"></canvas>
            </div>
        </div>

        <!-- Pie chart -->
        <div class="pie-parent">
            <h2>Types of textiles recycled</h2>
            <p>In the pie chart below, we have tracked all the different types of textiles that have been recycled, so you can see the proportions of each type of material. The quantity is the amount in lbs that have been recycled since the creation of our platform.</p>
            <div style="width: 800px;"><canvas id="chart-pie"></canvas></div>
        </div>
</div>
        <!-- Link to charts.js extension -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <!-- Link to js chart functions -->
        <script type="module" src="js/charts.js"></script>

<!-- Calling chart functions -->
<script type="module">
    //Horizontal bar chart manufacturers
    import { createHorizontalBarChart } from './js/charts.js';
    var dataFromPHP = <?php echo $jsonResult; ?>;
    createHorizontalBarChart(dataFromPHP.map(entry => entry.manufacturer), dataFromPHP.map(entry => entry.quantity), 'chart-space');

    //Horizontal bar chart recyclers 
    var dataFromPHP1 = <?php echo $jsonResult1; ?>;
    createHorizontalBarChart(dataFromPHP1.map(entry => entry.recycler), dataFromPHP1.map(entry => entry.quantity), 'chart-space1');

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

