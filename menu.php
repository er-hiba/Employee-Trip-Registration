<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: Login.php");
    exit;
}

include 'conxDB.php';

$name = $_SESSION['name'];
$position = $_SESSION['position'];
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        li {
            margin-left: 30px;
        }

        nav a {
            text-decoration: none;
            color: grey;
            font-size: 17px;
        }

        li.active a {
            color: rgb(174, 49, 49);
        }

        nav a:hover {
            text-decoration: underline rgb(174, 49, 49);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <h5>
                <?php echo "Welcome, $name ($position)" ?>
            </h5>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto mb-lg-0">
                    <li class="<?php echo ($currentPage == 'register') ? 'active' : ''; ?>"><a
                            href="register.php">Register</a></li>
                    <li class="<?php echo ($currentPage == 'registrations') ? 'active' : ''; ?>"><a
                            href="registrations.php">List of
                            Registrations</a></li>
                    <li class="<?php echo ($currentPage == 'logout') ? 'active' : ''; ?>"><a
                            href="logout.php">Logout</a></li>
                </ul>
            </div>

        </div>
    </nav>
</body>

</html>
