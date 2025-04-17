<?php
    include_once("utils/auth.php");
    include_once("utils/userstorage.php");

    include_once("services/redirection.php");
    
    session_start();

    $auth = new Auth(new UserStorage());

    $auth->logout();
    redirect("login.php");
