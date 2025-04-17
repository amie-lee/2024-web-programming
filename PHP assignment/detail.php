<?php
    include_once("utils/carstorage.php");
    
    session_start();

    $islogin = false;
    if (isset($_SESSION['user'])) {
        $islogin = true;
    }

    $startDate = $_GET['start_date'] ?? '';
    $endDate = $_GET['end_date'] ?? '';

    $errors = [];
    $data = [];

    //print_r($_GET);

    if (isset($_GET['id']))
    {
        $cs = new CarStorage();
        $car = $cs->findById($_GET['id']);
    
        //print_r($car);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iKarRental</title>
    <link rel="stylesheet" href="style/detail.css">
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

    <div id="item">
        <h1><?= $car['brand'] ?> <span id="model"><?= $car['model'] ?></span></h1>
        <div id="info">
            <img src="<?= $car['image'] ?>">
            <div id="box">
                <div id="details">
                    Fuel: <?= $car['fuel_type'] ?><br>
                    Shifter: <?= $car['transmission'] ?><br>
                    Year of maufacture: <?= $car['year'] ?><br>
                    Number of seats: <?= $car['passengers'] ?><br><br>
                    <h2>HUF <?= $car['daily_price_huf'] ?>/day</h2>

                    <?php if ($startDate && $endDate): ?>
                    <p>Selected Dates: <?= $startDate ?> - <?= $endDate ?></p>
                    <?php endif; ?>
                </div>

                <div id="buttons">
                <form action="<?= $islogin ? 'date.php' : 'login.php' ?>" method="get">
                    <input type="hidden" name="id" value="<?= $car['id'] ?>">
                    <button id="date" name="date">Select a date</button>
                </form>

                <?php if ($startDate && $endDate) : ?>
                <form action="book.php" method="post">
                    <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                    <input type="hidden" name="start_date" value="<?= $startDate ?>">
                    <input type="hidden" name="end_date" value="<?= $endDate ?>">
                    <button id="book">Book it</button>
                </form>
                <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>