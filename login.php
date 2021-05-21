<?php

if (!empty($_POST["login"])) {
    session_start();
    $username = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    require_once (__DIR__ . "/Users.php");
    
    $remember = false;
    if (isset($_POST["remember"])) 
    {
        $remember = true;
    }
    
    $member = new Users();
    $isLoggedIn = $member->processLogin($username, $password, $remember);
    if (! $isLoggedIn) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
    }
    header("Location: ./index.php");
    exit();
}