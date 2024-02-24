
<?php
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

//manufacturer historical donations accepted
$sql = "SELECT sum(t.quantity) as quantity, ma.companyName as manufacturer
from transactions as t
join user_transaction as ut on ut.transactionID=t.transactionID
join users as u on u.userID=ut.userID
join manufacturers as ma on ma.userID=u.userID
WHERE u.usertype='manufacturer'
GROUP BY ma.companyName
order by sum(t.quantity) DESC
limit 10";

//recycler historical donations
$sqll = "SELECT sum(t.quantity) as quantity, r.companyName as recycler
from transactions as t
join user_transaction as ut on t.transactionID=ut.transactionID
join users as u on u.userID=ut.userID
join recyclers as r on r.companyID=u.userID
group by ut.recyclerID
order by quantity desc
limit 10";

//transactions and quantities over time
$sql2 = "SELECT DATE_FORMAT(transactionDate, '%M %Y') AS monthYear, SUM(quantity) AS quantity
FROM transactions
GROUP BY monthYear
ORDER BY transactionDate";

//sum of each type of material in transactions
$sql3 = "SELECT m.materialName, sum(t.quantity) as quantity
from materials as m
JOIN transactions AS t ON t.materialID = m.materialID
group by m.materialName
order by sum(t.quantity) desc";

$bubbleQuery = "SELECT t.transactionDate, count(ut.userID) as users, sum(t.quantity) as quantity
from transactions as t 
join user_transaction as ut on ut.transactionID=t.transactionID
group by t.transactionDate
order by t.transactionDate";


//get results
$result = $conn->query($sql);
$resultt = $conn->query($sqll);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$resultBubble = $conn->query($bubbleQuery);


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
        'transationDate' => $row['monthYear'],
        'quantity'=> $row['quantity']
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


$dataBubble = array();
while($row = $resultBubble->fetch_assoc()){
    $dataBubble[] = array(
        'x' => $row['transactionDate'],
        'y'=> $row['quantity'],
        'r' => $row['users']
    );
}

$jsonBubble = json_encode($dataBubble);

$conn->close();



?>