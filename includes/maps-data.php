<?php 
//db connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

$getPlaces = "SELECT cAddress, city, cState, zip, country FROM recyclers";

$placeResult = $conn->query($getPlaces);

//store the results in an array
$placeResultArray = [];

while($row=$placeResult->fetch_assoc()){
    $placeResultArray= array(
        'address' => $row['cAddress'],
        'city' => $row['city'],
        'state' => $row['cState'],
        'zip' => $row['zip'],
        'country' => $row['country']
);

// Concatenate address
$concatenatedAddress = $placeResultArray['address'] . ', ' . $placeResultArray['city'] . ', ' . $placeResultArray['state'] . ' ' . $placeResultArray['zip'] . ', ' . $placeResultArray['country'];
// Add the concatenated address to array
$concatenatedAddresses[] = $concatenatedAddress;
}

//convert to json to use in js
$jsonConcatenatedAddresses = json_encode($concatenatedAddresses);

$conn->close();
?>