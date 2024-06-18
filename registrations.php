<?php
session_start();
include ('conxDB.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: Login.php");
    exit;
}

$date = '';
if (isset($_POST['date'])) {
    $date = $_POST['date'];
}

$query = "SELECT r.regCode, r.tripDate, r.numPeople, t.ticketPrice * r.numPeople AS totalPayment
            FROM registration r
            JOIN trip t ON r.tripCode = t.tripCode
            WHERE r.empCode = ?";

if ($date) {
    $query .= " AND r.tripDate = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION['id'], $date]);
} else {
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION['id']]);
}

$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registrations</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            background-image: url("background2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        #d2 {
            margin-top: 20px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #fd {
            width: 180px;
            display: inline;
            margin: 0 10px;
        }

        label[for='fd'] {
            font-size: 18px;
            font-weight: 500;
        }

        #b1 {
            width: 70px;
            padding: 7px;
            color: white;
            border: 0;
            border-radius: 15px;
            background-color: palevioletred;
        }

        table {
            margin-top: 30px;
            border: 1px solid white;
            text-align: center;
            width: 1000px;
        }

        th {
            background-color: #f1b2c7dc !important;
            font-weight: 500;
        }

        td {
            background-color: #e7e7fd8e !important;
        }
    </style>
</head>

<body>
    <?php
    $currentPage = 'registrations';
    include 'menu.php'
        ?>
    <div class="container-fluid" id="d2">

        <form method="post" action="registrations.php">
            <label for="fd" class="form-label">Filter by Trip Date:</label>
            <input type="date" id="fd" name="date" class="form-control">
            <button id='b1' type="submit">Filter</button>
        </form>

        <table class='table-bordered' cellpadding="7px">
            <tr>
                <th>Registration Code</th>
                <th>Trip Date</th>
                <th>Number of People</th>
                <th>Total Payment</th>
                <th>Details</th>
            </tr>
            <?php foreach ($registrations as $registration): ?>
                <tr>
                    <td valign="middle"><?php echo htmlspecialchars($registration['regCode']); ?></td>
                    <td valign="middle"><?php echo htmlspecialchars($registration['tripDate']); ?></td>
                    <td valign="middle"><?php echo htmlspecialchars($registration['numPeople']); ?></td>
                    <td valign="middle"><?php echo htmlspecialchars($registration['totalPayment']) . " DH"; ?> </td>
                    <td valign="middle" style="width: 200px"><a
                            href="details.php?regCode=<?php echo $registration['regCode']; ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>