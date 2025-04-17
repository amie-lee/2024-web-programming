<?php
    include_once("utils/carstorage.php");
    include_once("services/redirection.php");
    include_once("services/validation.php");
    
    session_start();

    $islogin = false;
    if (isset($_SESSION['user'])) {
        $islogin = true;
    }

    $data = [];
    $errors = [];
    
    if (count($_POST) > 0)
    {
        if (isCarValid($_POST, $errors, $data))
        {
            $data = [
                'brand' => $_POST['brand'],
                'model' => $_POST['model'],
                'year' => $_POST['year'],
                'transmission' => $_POST['transmission'],
                'fuel_type' => $_POST['fuel_type'],
                'passengers' => $_POST['passengers'],
                'daily_price_huf' => $_POST['daily_price_huf'],
                'image' => $_POST['image']
            ];

            $cs = new CarStorage();
            $cs->add($data);
            redirect("index.php");
        }
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
    <h1>Add a new car</h1>
    
    <form action="" method="post">
        <div>
        Brand <br>
        <input type="text" name="brand" value=<?= $_POST['brand'] ?? "" ?>><br>
        <?php if (isset($errors['brand'])) : ?>
            <span class="error"><?= $errors['brand'] ?></span>
        <?php endif; ?><br><br>
        </div> 

        <div>
        Model <br>
        <input type="text" name="model" value=<?= $_POST['model'] ?? "" ?>><br>
        <?php if (isset($errors['model'])) : ?>
            <span class="error"><?= $errors['model'] ?></span>
        <?php endif; ?><br><br>
        </div>

        <div>
        Year <br>
        <input type="number" name="year" value=<?= $_POST['year'] ?? "" ?>><br>
        <?php if (isset($errors['year'])) : ?>
            <span class="error"><?= $errors['year'] ?></span>
        <?php endif; ?><br><br>
        </div>

        <div>
        Transmission <br>
        <select name="transmission" id="transmission" value=<?= $_POST['transmission'] ?? "" ?>>
            <option value="Automatic" <?= (isset($_POST['transmission']) && $_POST['transmission'] === 'Automatic') ? 'selected' : '' ?>>Automatic</option>
            <option value="Manual" <?= (isset($_POST['transmission']) && $_POST['transmission'] === 'Manual') ? 'selected' : '' ?>>Manual</option>                        
        </select><br>
        <?php if (isset($errors['transmission'])) : ?>
            <span class="error"><?= $errors['trasmission'] ?></span>
        <?php endif; ?><br><br>
        </div>

        <div>
        Fuel Type <br>
        <select name="fuel_type" id="fuel_type" value=<?= $_POST['fuel_type'] ?? "" ?>>
            <option value="Petrol" <?= (isset($_POST['fuel_type']) && $_POST['fuel_type'] === 'Petrol') ? 'selected' : '' ?>>Petrol</option>
            <option value="Diesel" <?= (isset($_POST['fuel_type']) && $_POST['fuel_type'] === 'Diesel') ? 'selected' : '' ?>>Diesel</option>
            <option value="Electric" <?= (isset($_POST['fuel_type']) && $_POST['fuel_type'] === 'Electric') ? 'selected' : '' ?>>Electric</option>                        
        </select><br>
        <?php if (isset($errors['fuel_type'])) : ?>
            <span class="error"><?= $errors['fuel_type'] ?></span>
        <?php endif; ?><br><br>
        </div>

        <div>
        Passenger Capacity <br>
        <input type="number" name="passengers" value=<?= $_POST['passengers'] ?? "" ?>><br>
        <?php if (isset($errors['passengers'])) : ?>
            <span class="error"><?= $errors['passengers'] ?></span>
        <?php endif; ?><br><br>
        </div>

        <div>
        Daily Price in HUF <br>
        <input type="number" name="daily_price_huf" value=<?= $_POST['daily_price_huf'] ?? "" ?>><br>
        <?php if (isset($errors['daily_price_huf'])) : ?>
            <span class="error"><?= $errors['daily_price_huf'] ?></span>
        <?php endif; ?><br><br>
        </div>

        <div>
        Image URL <br>
        <input type="text" name="image" value=<?= $_POST['image'] ?? "" ?>><br>
        <?php if (isset($errors['image'])) : ?>
            <span class="error"><?= $errors['image'] ?></span>
        <?php endif; ?><br><br>
        </div>

        <?php if (isset($errors['global'])) : ?>
            <span class="error"><?= $errors['global'] ?></span>
        <?php endif; ?>

        <button class="submit">Add</button>
    </form>
    </div>
    
    
</body>
</html>