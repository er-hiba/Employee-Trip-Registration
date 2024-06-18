<?php
session_start();
include 'conxDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = htmlspecialchars($_POST['user']);
    $pwd = htmlspecialchars($_POST['pwd']);

    $stmt = $conn->prepare("SELECT * FROM Employee WHERE username = ? AND pwd = ?");
    $stmt->execute([$user, $pwd]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data == false) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('error').textContent = 'Invalid username or password';

                });
              </script>";
    } else {
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $user;
        $_SESSION['name'] = $data['name'];
        $_SESSION['position'] = $data['position'];
        $_SESSION['id'] = $data['empCode'];
        header('Location: register.php');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>LOGIN</title>
    <style>
        body {
            background-image: url("background.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            width: 450px;
            margin-top: 130px;
            background-color: #d6c3c37b;
            padding: 50px;
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 30px;
            text-align: center;
            color: #2f2f27;
            font-weight: bold;
        }

        .btn {
            background-color: #816969;
            border: 0;
            width: 100%;
            color: white;
            font-weight: bold;
            font-size: larger;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .input-group-text {
            background-color: #d6c3c3;
        }

        span {
            color: red;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class=container>
        <h1> Welcome back!</h1>
        <form method="POST" action="Login.php">
            <div class="input-group mb-3">
                <span class="input-group-text"> <i class="fa-solid fa-user" style="color: #816969;"></i></span>
                <input type="text" name="user" class="form-control" required placeholder="Username">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text"> <i class="fa-solid fa-lock" style="color: #816969;"></i> </span>
                <input type="password" name="pwd" class="form-control" required placeholder="Password">
            </div>
            <button type="submit" class="btn">LOGIN </button>
            <span id="error"></span>
        </form>
    </div>
</body>

</html>