<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Logout</title>
    <style>
        body {
            background-image: url("background2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            margin-top: 30px;
            padding: 20px;
            text-align: center;
        }

        input[type='submit'] {
            width: 70px;
            margin-left: 30px;
            padding: 7px;
            font-size: 18px;
            color: white;
            border: 0;
            border-radius: 15px;
        }

        input[type='submit']:hover {
            box-shadow: 1px 5px 10px 1px #6f9aa8;
        }

        input[name='confirm'] {
            background-color: palevioletred;
        }

        input[name='cancel'] {
            background-color: #9e399e;
        }
    </style>
</head>

<body>
    <?php
    $currentPage = 'logout';
    include 'menu.php'
        ?>
    <div class="container">
        <h2> Are you sure you want to logout</h2>
        <br>
        <form method="post">
            <input type="submit" name="confirm" value="Yes">
            <input type="submit" name="cancel" value="No">
        </form>
    </div>
</body>

</html>
<?php
if (isset($_POST['confirm'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
} elseif (isset($_POST['cancel'])) {
    header('Location: register.php');
}

?>