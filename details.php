<?php
session_start();
include ('conxDB.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: Login.php");
    exit;
}

if (!isset($_GET['regCode'])) {
    header("Location: registrations.php");
    exit;
}

$regCode = $_GET['regCode'];

$query = "SELECT r.tripDate, td.departureCity, td.arrivalCity, t.departureTime, t.duration 
            FROM registration r
            JOIN trip t ON r.tripCode = t.tripCode
            JOIN tripdescription td ON t.descCode = td.descCode
            WHERE r.regCode = ?";

$stmt = $conn->prepare($query);
$stmt->execute([$regCode]);

$details = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$details) {
    header("Location: registrations.php");
    exit;
}

$departureTime = new DateTime($details['departureTime']);
$duration = new DateInterval('PT' . $details['duration'] . 'H');
$arrivalTime = clone $departureTime;
$arrivalTime->add($duration);
$arrivalTimeString = $arrivalTime->format('H:i');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Trip Details</title>
    <style>
        body {
            background-image: url("background2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        #d3 {
            margin-top: 20px;
            padding: 20px;
            background-color: #e7e7fd8e;

        }

        h4 {
            color: purple !important;
            margin-bottom: 15px !important;
        }

        #d3 ul li {
            font-size: 18px;
            margin-left: 20px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        #d3 ul {
            list-style: circle;
        }
    </style>
</head>

<body>
    <?php
    $currentPage = '';
    include 'menu.php'
        ?>

    <div class="container-fluid" id="d3">
        <h4>Trip Details:</h4>
        <ul>
            <li>Trip Date: <?php echo htmlspecialchars($details['tripDate']); ?></li>
            <li>Departure City: <?php echo htmlspecialchars($details['departureCity']); ?></li>
            <li>Arrival City: <?php echo htmlspecialchars($details['arrivalCity']); ?></li>
            <li>Departure Time: <?php echo htmlspecialchars($details['departureTime']); ?></li>
            <li>Arrival Time: <?php echo htmlspecialchars($arrivalTimeString); ?></li>
        </ul>
    </div>
</body>

</html>