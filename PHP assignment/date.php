<?php
    include_once("utils/carstorage.php");
    
    session_start();

    $islogin = false;
    if (isset($_SESSION['user'])) {
        $islogin = true;
    }

    $carId = 0;
    if (isset($_GET['id'])) {
        $carId = $_GET['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
    
        header("Location: detail.php?id=$carId&start_date=$startDate&end_date=$endDate");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iKarRental</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header role="banner">
        <h3 onclick="location.href='index.php'">iKarRental</h3>
        <div class="banner">
            <a href="login.php" id="login" style="display: <?= $islogin ? 'none' : 'block' ?>">Login</a>
            <button type="button" onclick="location.href='registration.php'" style="display: <?= $islogin ? 'none' : 'block' ?>">Registration</button>
            <form action="logout.php" style="display: <?= $islogin ? 'block' : 'none' ?>">
                <button>Logout</button>
            </form>
            <a href="profile.php" class="profile-link" style="display: <?= $islogin ? 'block' : 'none' ?>">
                <img src=<?= $_SESSION['user']['image'] ?> alt="" class="profile-img">
            </a>
        </div>
    </header>

    <div id="container">
    <h1>Select a date</h1>

    <form action="date.php?id=<?= $carId?>" method="post">
        <div>
        Start Date <br>
        <input type="date" name="start_date" min="<?= date('Y-m-d') ?>" required> <br><br>
        </div>
        
        <div>
        End Date <br>
        <input type="date" name="end_date" min="<?= date('Y-m-d') ?>" required> <br><br>
        </div>

        <button class="submit">Book</button>
    </form>
    </div>
    
    
</body>
</html>