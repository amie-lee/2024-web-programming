<?php
    include_once("services/validation.php");
    include_once("services/redirection.php");
    include_once("utils/auth.php");
    include_once("utils/userstorage.php");

    session_start();

    $user_storage = new UserStorage();
    $auth = new Auth($user_storage);

    $data = [];
    $errors = [];

    if (count($_POST) > 0)
    {
        if (isLoginValid($_POST, $errors))
        {  
            $data = [
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];

            $auth_user = $auth->authenticate($data['email'], $data['password']);

            if (!$auth_user)
                $errors['global'] = "Login error";
            else
            {
                $auth->login($auth_user);
                redirect("index.php");
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
    <h1>Login</h1>

    <form action="" method="post">
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

        <?php if (isset($errors['global'])) : ?>
            <span class="error"><?= $errors['global'] ?></span>
        <?php endif; ?>

        <button class="submit">Login</button>
    </form>
    </div>
    
</body>
</html>