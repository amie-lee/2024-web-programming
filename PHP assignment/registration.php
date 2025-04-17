<?php
    include_once("services/validation.php");
    include_once("services/redirection.php");
    include_once("utils/auth.php");
    include_once("utils/userstorage.php");

    session_start();
    //print_r($_SESSION);

    $data = [];
    $errors = [];

    if (count($_POST) > 0)
    {
        if (isUserValid($_POST, $errors, $data))
        {
            $data = [
                'fullname' => $_POST['fullname'],
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];

            $auth = new Auth(new UserStorage());

            if ($auth->user_exists($data['email']))
                $errors['exist'] = "User already exists";
            else
            {
                $auth->register($data);
                redirect("login.php");
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
    <link rel="stylesheet" href="style/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header role="banner">
    <h3 onclick="location.href='index.php'">iKarRental</h3>
        <div class="banner">
            <a href="login.php" id="login">Login</a>
            <button type="button" onclick="location.href='registration.php'">Registration</button>
        </div>
    </header>

    <div id="container">
    <h1>Registration</h1>

    <form action="" method="post">
        <div>
        Full name <br>
        <input type="text" name="fullname"><br>
        <?php if (isset($errors['fullname'])) : ?>
            <span class="error"><?= $errors['fullname'] ?></span>
        <?php endif; ?><br><br>
        </div>
        
        <div>
        Email address <br>
        <input type="text" name="email"><br>
        <?php if (isset($errors['email'])) : ?>
            <span class="error"><?= $errors['email'] ?></span>
        <?php endif; ?><br><br>
        </div>
        
        <div>
        Password <br>
        <input type="text" name="password"><br>
        <?php if (isset($errors['password'])) : ?>
            <span class="error"><?= $errors['password'] ?></span>
        <?php endif; ?><br><br>
        </div>
        
        <div>
        Password again <br>
        <input type="text" name="password-check"><br>
        <?php if (isset($errors['password-check'])) : ?>
            <span class="error"><?= $errors['password-check'] ?></span>
        <?php endif; ?><br><br>
        </div>

        <?php if (isset($errors['exist'])) : ?>
            <span class="error"><?= $errors['exist'] ?></span>
        <?php endif; ?>

        <button class="submit">Registration</button>
    </form>
    </div>
    
</body>
</html>