<?php

// Connection to DB, replace this with yours (there is a .SQL file in the repo to add sample data if you need it)
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


// The output type we send to the autocomplete form
header('Content-Type: text/plain');

$search = $_POST['service'];
$userIdArray = array();
$airportIdArray[] = array();

$exists = "SELECT airport_id
            FROM usersairports
            WHERE user_id = $userId";
$result = mysqli_query($conn, $exists);
if ($result === true) {
    while ($row = mysqli_fetch_array($result)) {
        $airportIdArray[] = $row['airport_id'];
    }
}
$sql = "SELECT distinct a.airport_iata, c.city_name, a.airport_name, a.airport_id FROM airports a, cities c
WHERE (INSTR(c.city_name,'". $search ."') OR INSTR(a.airport_name,'" . $search . "')
OR INSTR(a.airport_iata,'" . $search . "'))  AND a.city_id = c.city_id ORDER BY airport_name DESC
LIMIT 15";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_array($result)) {
            if (in_array($row['airport_id'], $airportIdArray)) {
                $alreadyAdded = 'autocomplete__item--added';
            } else {
                $alreadyAdded = 'suggest-element';
            }
            echo '<div data-id="' . $row['airport_id'] . '" id="' . $row['airport_name'] . ' - ' . $row['city_name'] . ' - ' . $row['airport_iata'] . ' - ' . $row['airport_id'] . '" class="' . $alreadyAdded . ' autocomplete__item">';
            echo '<div><b>' . $row['airport_name'] . '</b> (' . $row['airport_iata'] . ')</div><small class="display-block">' . $row['city_name'] . '</small>';
            echo "</div>";
        }
        mysqli_free_result($result);
    } else {
        echo '<div class="autocomplete__item alert--warning"> No records matching your query were found.</div>';
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
