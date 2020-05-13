<?php
$servername = "localhost";
$username = "root";
$password = "root";
$db = "flightmondo";

$conn = new mysqli($servername, $username, $password, $db);
mysqli_set_charset($conn, "utf8");
if ($conn->connect_errno) {
    printf($conn->connect_errno);
    printf("tonto%s\n", $mysqli->connect_error);
    exit();
}

header('Content-Type: text/plain');

$airportId = intval($_POST['airportId']);
$userId = 2;

// get all userairports for user and check that the airport doesent exist yet

$sql = "INSERT INTO flightmondo.userairports (airport_id,user_id)  VALUES ($airportId ,$userId)";
$result = mysqli_query($conn, $sql);


return $result ;


?>