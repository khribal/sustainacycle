
<?php
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

//manufacturer historical donations accepted
$sql = "SELECT sum(re.quantity) as quantity, ma.companyName as manufacturer
from requests as re
join materials as m on m.materialID=re.materialID
join users as u on u.userID=m.userID
join manufacturers as ma on ma.userID=u.userID
WHERE re.reqStatus='Completed'
group by ma.companyName
order by sum(re.quantity) DESC
limit 10;
";

//recycler historical donations
$sqll = "SELECT sum(re.quantity) as quantity, r.companyName as recycler
from requests as re
join recyclers as r on r.companyID=re.recyclerID
WHERE re.reqStatus='Completed'
group by r.companyName
order by sum(re.quantity) DESC
limit 10";

//transactions and quantities over time
$sql2 = "SELECT DATE_FORMAT(transactionDate, '%c-%d-%Y') AS dateFormatted, SUM(quantity) AS quantity
FROM transactions
where status='Completed'
group by transactionDate
order by transactionDate";

//sum of each type of material in transactions
$sql3 = "SELECT m.materialName, sum(re.quantity) as quantity
from materials as m
JOIN requests AS re ON re.materialID = m.materialID
group by m.materialName
order by sum(re.quantity) desc";

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
        'transationDate' => $row['dateFormatted'],
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