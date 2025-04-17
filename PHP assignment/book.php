<?php
    include_once("utils/bookingstorage.php");
    include_once("utils/carstorage.php");

    session_start();
    
    $islogin = false;
    if (isset($_SESSION['user'])) {
        $islogin = true;
    }

    $data = [];

    if (count($_POST) > 0) 
    {
        $bs = new BookingStorage();
        $available = true;

        $carId = $_POST['car_id'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        $cs = new CarStorage();
        $car = $cs->findById($carId);

        $bookings = $bs->findMany(function ($b) use ($carId, $startDate, $endDate) {
            return $b['car_id'] == $carId && (
                ($startDate >= $b['start_date'] && $startDate <= $b['end_date']) ||
                ($endDate >= $b['start_date'] && $endDate <= $b['end_date']) ||
                ($startDate <= $b['start_date'] && $endDate >= $b['end_date'])
            );
        });

        if (!empty($bookings)) {
            $available = false;
        }
        
        if ($available) {
            $data = [
                'email' => $_SESSION['user']['email'],
                'car_id' => $_POST['car_id'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date']
            ];

            $bs->add($data);
            $issuccess = true;
        } else {
            $issuccess = false;
        }
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

    <div class="result" style="display: <?= $issuccess ? 'flex' : 'none' ?>">
        <img src="src/success.png" alt="">
        <h2>Successful booking!</h2>
        <p>The <?= $car['brand'] . ' ' . $car['model'] ?> has been successfully booked for the interval <?= $startDate ?> - <?= $endDate ?>. <br>
        You can track the status of your reservation on your profile page.</p>
        <button onclick="location.href='profile.php'">My profile</button>
    </div>

    <div class="result" style="display: <?= $issuccess ? 'none' : 'flex' ?>">
        <img src="src/fail.png" alt="">
        <h2>Booking failed!</h2>
        <p>The <?= $car['brand'] . ' ' . $car['model'] ?> is not available in the specified interval from <?= $startDate ?> to <?= $endDate ?>. <br>
        Try entering a different interval or search another vehicle.</p>
        <button onclick="location.href='index.php'">Back to the vehicle side</button>
    </div>

</body>
</html>