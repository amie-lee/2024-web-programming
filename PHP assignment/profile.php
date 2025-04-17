<?php
    include_once("utils/carstorage.php");
    include_once("utils/bookingstorage.php");
    
    session_start();

    $bs = new BookingStorage();
    $cs = new CarStorage();

    $email = $_SESSION['user']['email'];

    $reservations = $bs->findMany(function($b) use ($email) {
    return $b['email'] === $email;
    });
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iKarRental</title>
    <link rel="stylesheet" href="style/profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header role="banner">
        <h3 onclick="location.href='index.php'">iKarRental</h3>
        <div class="banner">
        <a href="profile.php" class="profile-link">
            <img src=<?= $_SESSION['user']['image'] ?> alt="" class="profile-img">
        </a>
        </div>
    </header>

    <div id="profile">
        <img src=<?= $_SESSION['user']['image'] ?> alt="">
        <p>Logged in as <br> <strong><?= $_SESSION['user']['fullname'] ?></strong></p>
    </div>

    <h3>My reservations</h3>
    <div id="list">
        <?php if (!empty($reservations)) : ?>
            <?php foreach ($reservations as $r) : ?>
                <?php $c = $cs->findById($r['car_id']); ?>
                <div id="list-item">
                    <img src="<?= $c['image'] ?>" alt="">
                    <p id="brand"><?= $c['brand'] ?> <span id="model"><?= $c['model'] ?></span></p>
                    <p id="passengers"><?= $c['passengers'] ?> seats - <?= $c['transmission'] ?></p>
                    <p id="date"><?= $r['start_date']?> - <?= $r['end_date']?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No reservation found</p>
        <?php endif; ?>
    </div>

    <form action="logout.php">
        <button>Logout</button>
    </form>

</body>
</html>