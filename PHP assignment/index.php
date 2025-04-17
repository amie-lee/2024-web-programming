<?php
    include_once("utils/carstorage.php");
    include_once("utils/bookingstorage.php");
    
    session_start();

    $islogin = false;
    if (isset($_SESSION['user'])) {
        $islogin = true;
    }

    $isadmin = false;
    if ($islogin && in_array('admin', $_SESSION['user']['roles'])) {
        $isadmin = true;
    }

    $bs = new BookingStorage();
    $cs = new CarStorage();
    $cars = $cs->findAll();
    $filtered = $cars;
    
    $errors = [];

    if (isset($_POST)) {
        if (count($_POST) > 0) {
            // filter - number of seats
            if (!empty($_POST['passengers'])) {
                $filtered = array_filter($filtered, function($v) {
                    return $v['passengers'] === intval($_POST['passengers']);
                });
            }

            // filter - available date
            if (!empty($_POST['startdate']) && !empty($_POST['enddate'])) {
                $startDate = $_POST['startdate'];
                $endDate = $_POST['enddate'];
        
                $filtered = array_filter($filtered, function($car) use ($bs, $startDate, $endDate) {
                    $bookings = $bs->findMany(function($booking) use ($car) {
                        return $booking['car_id'] == $car['id'];
                    });
        
                    foreach ($bookings as $booking) {
                        if (
                            ($startDate >= $booking['start_date'] && $startDate <= $booking['end_date']) ||
                            ($endDate >= $booking['start_date'] && $endDate <= $booking['end_date']) ||
                            ($startDate <= $booking['start_date'] && $endDate >= $booking['end_date'])
                        ) {
                            return false;
                        }
                    }
                    return true;
                });
            }

            // filter - gear
            if (!empty($_POST['transmission'])) {
                if ($_POST['transmission'] !== 'Both'){
                    $filtered = array_filter($filtered, function($v) {
                        return $v['transmission'] === $_POST['transmission'];
                    });
                }
            }

            // filter - price range
            if (!empty($_POST['pricelow']) && !empty($_POST['pricehigh'])) {
                $filtered = array_filter($filtered, function($v) {
                    return ($v['daily_price_huf'] >= $_POST['pricelow']) && ($v['daily_price_huf'] <= $_POST['pricehigh']);
                });
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iKarRental</title>
    <link rel="stylesheet" href="style/index.css">
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
            <button class="admin" onclick="location.href='add.php'" style="display: <?= $isadmin ? 'block' : 'none' ?>">Add a new car</button>
            <form action="logout.php" style="display: <?= $islogin ? 'block' : 'none' ?>">
                <button>Logout</button>
            </form>
            <a href="profile.php" class="profile-link" style="display: <?= $islogin ? 'block' : 'none' ?>">
                <img src=<?= $_SESSION['user']['image'] ?> alt="" class="profile-img">
            </a>
        </div>
    </header>

    <div id="main-banner" style="display: <?= $islogin ? 'none' : 'block' ?>">
        <h1>Rent cars<br>easily!</h1>
        <button type="button" onclick="location.href='registration.php'">Registration</button>
    </div>
    
    <form id="filter" action="" method="post">
        <div id="options">
            <div class="optiondiv">
                <div class="optiondiv2"><input type="number" name='passengers' value=<?= $_POST['passengers'] ?? "" ?>> seats</div>    
                <div class="optiondiv2">  
                    from <input type="date" name='startdate' value=<?= $_POST['startdate'] ?? "" ?>>
                    until <input type="date" name='enddate' value=<?= $_POST['enddate'] ?? "" ?>>
                </div>
            </div>
            <div class="optiondiv">
                <div class="optiondiv2">
                    <select name="transmission" id="transmission" value=<?= $_POST['transmission'] ?? "" ?>>
                        <option value="Both" <?= (isset($_POST['transmission']) && $_POST['transmission'] === 'Both') ? 'selected' : '' ?>>both</option>
                        <option value="Automatic" <?= (isset($_POST['transmission']) && $_POST['transmission'] === 'Automatic') ? 'selected' : '' ?>>auto</option>
                        <option value="Manual" <?= (isset($_POST['transmission']) && $_POST['transmission'] === 'Manual') ? 'selected' : '' ?>>manual</option>                        
                    </select>
                </div>
                <div class="optiondiv2">
                    <input type="number" name='pricelow' value=<?= $_POST['pricelow'] ?? "" ?>> - <input type="number" name='pricehigh' value=<?= $_POST['pricehigh'] ?? "" ?>> Ft
                </div>
            </div>
        </div>
        <button>Filter</button>
    </form>

    <div id="list">
    <?php foreach ($filtered as $c) : ?>
        <div id="list-item">
            <img src="<?= $c['image'] ?>" alt="">
            <p id="brand"><?= $c['brand'] ?> <span id="model"><?= $c['model'] ?></span></p>
            <p id="passengers"><?= $c['passengers'] ?> seats - <?= $c['transmission'] ?></p>
            <p id="price"><?= $c['daily_price_huf']?> Ft</p>
            <button onclick="location.href='<?= 'detail.php?id=' . $c['id'] ?>'" id="book">Book</button>
        </div>
    <?php endforeach; ?>
    </div>
    
</body>
</html>