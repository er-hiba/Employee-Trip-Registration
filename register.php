<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: Login.php");
    exit;
}

include 'conxDB.php';

$currentPage = 'register';

$departureCities = $conn->query("SELECT DISTINCT departureCity FROM tripDescription");
$arrivalCities = $conn->query("SELECT DISTINCT arrivalCity FROM tripDescription");

$citiesD = $departureCities->fetchAll(PDO::FETCH_ASSOC);
$citiesA = $arrivalCities->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Register for a Trip</title>
    <style>
        body {
            background-image: url("background2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            padding: 20px;
            margin-top: 20px;
            width: 50% !important;
        }

        .form-label {
            font-size: 18px;
            font-weight: bold;
        }

        .form-control,
        .form-select {
            min-width: 70% !important;
            margin: auto;
        }

        .btn {
            text-align: center;
            background-color: #dabcbb !important;
            width: 100%;
            font-size: 18px !important;
            font-weight: bold !important;
        }

        .btn:hover {
            box-shadow: 2px 5px 20px;
        }

        .alert {
            width: 50%;
            margin: auto !important;
            color: black !important;
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <form method="POST" action="">
            <label for="dc" class='form-label'>Departure City: </label>
            <select id="dc" name="cityD" class="form-select" required>
                <?php foreach ($citiesD as $record): ?>
                    <option value="<?php echo $record['departureCity']; ?>">
                        <?php echo $record['departureCity']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label for="ac" class='form-label'>Arrival City: </label>
            <select id="ac" name="cityA" class="form-select" required>
                <?php foreach ($citiesA as $record): ?>
                    <option value="<?php echo $record['arrivalCity']; ?>">
                        <?php echo $record['arrivalCity']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label for="td" class='form-label'>Trip Date: </label>
            <input type="date" id="td" name="tripDate" class="form-control" required><br>

            <label for="np" class='form-label'>Number of People: </label>
            <input type="number" id="np" name="numPeople" class="form-control" min="1" required><br>
            <button type="submit" class="btn">REGISTER</button>
        </form>
    </div>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empCode = $_SESSION['id'];
    $cityD = $_POST['cityD'];
    $cityA = $_POST['cityA'];
    $tripDate = $_POST['tripDate'];
    $numPeople = $_POST['numPeople'];

    $stmt = $conn->prepare('SELECT tripCode FROM Trip WHERE descCode IN 
    (SELECT descCode FROM tripDescription WHERE departureCity = ? AND arrivalCity = ?);');
    $stmt->execute([$cityD, $cityA]);

    $result = $stmt->fetch(PDO::FETCH_NUM);

    if ($result) {
        $stmt2 = $conn->prepare('INSERT INTO registration values (null, ?, ?, ?, ?)');
        $stmt2->execute([$empCode, $result[0], $numPeople, $tripDate]);

    } else {
        $stmt3 = $conn->query('SELECT departureCity, arrivalCity FROM tripDescription');
        $trips = $stmt3->fetchAll(PDO::FETCH_ASSOC);
        $tripList = '';
        foreach ($trips as $trip) {
            $tripList .= $trip['departureCity'] . ' to ' . $trip['arrivalCity'] . '<br>';
        }
        echo '<div class="alert alert-danger" role="alert">There is no trip available for the selected departure and arrival cities.
        <br><br><u>Available trips:</u><br>' . $tripList . '</div>';
    }
}
?>