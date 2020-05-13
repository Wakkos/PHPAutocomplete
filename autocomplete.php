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


$userID = 2; //$_SESSION['id'];
?>

<!doctype html>
<html lang="en"><!--<![endif]-->

<head>
<link rel="alternate" hreflang="en-us" href="https://flightmondo.com" />



<?php
  $analyticsPath = $_SERVER['DOCUMENT_ROOT'];
  $analyticsPath .= "/shared/analytics.php";
  include_once($analyticsPath);
?>

<meta charset="utf-8">

<title>Flightmondo: flight deals in your email.</title>
<meta name="description" content="We will make you save 50% or more in your next airtickets.">

<!-- http://bit.ly/18VB51x -->
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">


<?php
  include_once "partials/facebook-meta.php";
?>
<!-- CSS Para todos los navegadores -->
<link rel="stylesheet" href="css/style.css">




<!--iOS -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Windows 8 / RT http://bit.ly/HHkt7m -->
<meta name="msapplication-TileImage" content="img/apple-touch-icon-144x144-precomposed.png">
<meta name="msapplication-TileColor" content="#000">
<meta http-equiv="cleartype" content="on">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<!-- OneTrust Cookies Consent Notice start -->

<script type="text/javascript">

function OptanonWrapper() { }

</script>

<!-- Include JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- OneTrust Cookies Consent Notice end -->
</head>

<body class="bg-color-lightergrey stickyfooter">

        <aside class="max-width-small margin-bottom">

            <label for="js-userlocations" class="align-center display-block">Start typing a city or an airport name or even an IATA code</label>
            <div class="formgroup margin-bottom--mini">
                <input type="text" id="js-userlocations" name="service" placeholder="NYC / New York" />
                <span role="button" title="Add Airport" id="js-addLocation" class="btn">Add</span>
            </div>
            <div id="js-suggestions" class="autocomplete"></div>

        </aside>

        <main class="max-width stickyfooter__content">
            <div class="padding-top grid max-width-medium" id="js-locations">
                <?php
                    //We search for current airports in the Database
                    $sql = "SELECT i.airport_id, a.airport_iata, a.airport_name, c.city_name
                    FROM userairports i
                        inner join airports a on i.airport_id = a.airport_id
                        inner join cities c on a.city_id = c.city_id
                    WHERE i.user_id = $userID";
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <div class="airportBadge">
                                    <div class="airportBadge__header">
                                        <?php echo $row['airport_iata']?>
                                    </div>
                                    <p class="airportBadge__cityname">
                                    <?php echo $row['city_name']?>
                                    </p>
                                    <p class="airportBadge__description">
                                        <?php echo $row['airport_name']?>
                                    </p>
                                    <div class="airportBadge__actions">
                                        <button onclick='deleteField(this.id);' id="<?php echo $row['airport_id']?>" class='airportBadge__delete'>
                                        <svg viewBox="0 0 24 24" class="iconsvg">
                                            <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z" />
                                        </svg>
                                            <span class='hide-sr'>Delete</span>
                                        </button>
                                    </div>
                                </div>
                            <?php

                            }

                            mysqli_free_result($result);
                        // If no records are found, we print that ugly skeleton (yeah I can do that with CSS but... TIME!)
                        } else {
                            ?>
                                <div class="airportBadge--skeleton__container" id="js-skeleton">
                                    <div class="airportBadge--skeleton">
                                    </div>
                                    <div class="airportBadge--skeleton">
                                    </div>
                                    <div class="airportBadge--skeleton">
                                    </div>
                                    <div class="airportBadge--skeleton">
                                    </div>
                                    <div class="airportBadge--skeleton">
                                    </div>
                                    <div class="airportBadge--skeleton">
                                    </div>
                                    <div class="airportBadge--skeleton">
                                    </div>
                                    <div class="airportBadge--skeleton">
                                    </div>
                                    <div class="airportBadge--skeleton">
                                    </div>
                                    <div class="airportBadge--skeleton">
                                    </div>
                                </div>
                            <?php
                        }
                    } else {
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                    }
                ?>
            </div>
        </main>




<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/shared/footer-dashboard.php";
?>
 <script id="blockOfStuff" type="text/html">
        <svg viewBox="0 0 24 24" class="iconsvg">
            <path d="M21,16V14L13,9V3.5A1.5,1.5 0 0,0 11.5,2A1.5,1.5 0 0,0 10,3.5V9L2,14V16L10,13.5V19L8,20.5V22L11.5,21L15,22V20.5L13,19V13.5L21,16Z" />
        </svg>
    </script>
    <script id="deleteicon"  type="text/html">
    <svg viewBox="0 0 24 24" class="iconsvg">
    <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z" />
</svg>
</script>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="js/write-airport.js"></script>
</body>
</html>
